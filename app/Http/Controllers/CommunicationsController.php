<?php

namespace App\Http\Controllers;

use App\Models\Tenants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class CommunicationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accountBalance = $this->getBalance();

        return Inertia::render('Communication/Index',[
            'balance' => $accountBalance['credit']
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch registered tenants from the database
        $tenants = Tenants::select('id', 'name', 'phone')->get();

        // Fetch message templates from the database
        // $templates = MessageTemplate::select('id', 'content')->get();

        return Inertia::render('Communication/Create', [
            'tenants' => $tenants,         // Pass tenants to the Vue component
            // 'templates' => $templates      // Pass templates to the Vue component
        ]);
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
    public function show(string $id)
    {
        //
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
}
