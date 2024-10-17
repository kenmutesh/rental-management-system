<?php

namespace App\Http\Controllers;

use App\Http\Resources\MessageResource;
use App\Models\Messages;
use App\Models\Tenants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class CommunicationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accountBalance = $this->getBalance();
        $messages = MessageResource::collection(Messages::paginate(10));

        return Inertia::render('Communication/Index',[
            'balance' => $accountBalance['credit'],
            'messages' => $messages
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $query = Tenants::query();

        $tenants = $this->applySearch($query, $request->search)->get();

        return Inertia::render('Communication/Create', [
            'tenants' => $tenants,
        ]);
    }

    private function applySearch($query, $search)
    {
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        return $query;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function single(Request $request)
    {
        $validatedData = $request->validate([
            'tenants' => 'required|array',
            'message' => 'required|string',
        ]);

        $url = "https://sms.textsms.co.ke/api/services/sendsms/";

        $apikey = env('SMS_APIKEY');
        $partnerID = env('SMS_PARTNERID');
        $shortcode = env('SMS_TextSMS');

        foreach ($validatedData['tenants'] as $tenant) {
            $userId = auth()->user()->id ?? 1;
            $phone = $tenant['phone'];

            $formattedPhone = $this->formatPhoneNumber($phone);

            $response = Http::post($url, [
                'apikey'    => $apikey,
                'partnerID' => $partnerID,
                'message'   => $validatedData['message'],
                'shortcode' => $shortcode,
                'mobile'    => $formattedPhone,
            ]);

            $responseBody = $response->json();

            if ($response->successful() && isset($responseBody['responses'])) {
                $responseData = $responseBody['responses'][0];

                Log::info('SMS Sent:', ['response' => $responseData]);

                Messages::create([
                    'tenant_id'           => $tenant['user_id'],
                    'user_id'             => $userId,
                    'message'             => $validatedData['message'],
                    'phone'               => $phone,
                    'response_code'       => $responseData['response-code'],
                    'response_description' => $responseData['response-description'],
                    'message_id'          => $responseData['messageid'],
                    'status'              => 'Success',
                ]);
            } else {
                $errorCode = $responseBody['response-code'] ?? null;
                $errorDescription = $responseBody['response-description'] ?? 'Unknown Error';
                $errorDetails = $responseBody['errors'] ?? [];

                Log::error('SMS API Error:', ['response' => $responseBody]);

                Messages::create([
                    'tenant_id'           => $tenant['user_id'],
                    'user_id'             => $userId,
                    'message'             => $validatedData['message'],
                    'phone'               => $phone,
                    'response_code'       => $errorCode,
                    'response_description' => $errorDescription,
                    'error_details'       => json_encode($errorDetails),
                    'status'              => 'Failed',
                ]);
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function getBalance()
    {
        $url = 'https://sms.textsms.co.ke/api/services/getbalance';

        $params = [
            'apikey' => env('SMS_APIKEY'),
            'partnerID' => env('SMS_PARTNERID'),
        ];

        $response = Http::get($url, $params);

        if ($response->successful()) {
            return $response->json();
        } else {
            return response()->json(['error' => 'Failed to retrieve balance'], 500);
        }
    }

    /**
     * Helper function to format the phone number according to the required rules.
     * - If phone starts with '0', replace it with '254'
     * - If phone starts with '7' or '1', append '254'
     * - Phone number must be 12 characters
     */
    private function formatPhoneNumber($phone)
    {
        $phone = preg_replace('/\D/', '', $phone);

        if (str_starts_with($phone, '0')) {
            $phone = '254' . substr($phone, 1);
        }
        elseif (str_starts_with($phone, '7') || str_starts_with($phone, '1')) {
            $phone = '254' . $phone;
        }

        if (strlen($phone) !== 12) {
            throw new \Exception("Invalid phone number format: {$phone}");
        }

        return $phone;
    }
}
