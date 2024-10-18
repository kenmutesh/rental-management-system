<?php

namespace App;

use App\Models\Messages;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait SmsTenant
{
    public function sendSmsToTenant($tenant, $messageType)
    {
        $url = "https://sms.textsms.co.ke/api/services/sendsms/";
        $apikey = env('SMS_APIKEY');
        $partnerID = env('SMS_PARTNERID');
        $shortcode = env('SMS_TextSMS');
        $userId = auth()->user()->id ?? 1;

        $phone = $tenant->phone;
        $formattedPhone = $this->formatPhoneNumber($phone);

        $message = $messageType === 'welcome'
            ? "Welcome, {$tenant->firstName }! \n We're excited to have you here."
            : "Goodbye, {$tenant->firstName }! We wish you all the best in your future endeavors.";

        $response = Http::post($url, [
            'apikey'    => $apikey,
            'partnerID' => $partnerID,
            'message'   => $message,
            'shortcode' => $shortcode,
            'mobile'    => $formattedPhone,
        ]);

        $responseBody = $response->json();

        if ($response->successful() && isset($responseBody['responses'])) {
            $responseData = $responseBody['responses'][0];

            Log::info('SMS Sent:', ['response' => $responseData]);

            Messages::create([
                'tenant_id'           => $tenant->id,
                'user_id'             => $userId,
                'message'             => $message,
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
                'message'             => $message,
                'phone'               => $phone,
                'response_code'       => $errorCode,
                'response_description' => $errorDescription,
                'error_details'       => json_encode($errorDetails),
                'status'              => 'Failed',
            ]);
        }
    }

    private function formatPhoneNumber($phone)
    {
        $phone = preg_replace('/\D/', '', $phone);

        if (str_starts_with($phone, '0')) {
            $phone = '254' . substr($phone, 1);
        } elseif (str_starts_with($phone, '7') || str_starts_with($phone, '1')) {
            $phone = '254' . $phone;
        }

        if (strlen($phone) !== 12) {
            throw new \Exception("Invalid phone number format: {$phone}");
        }

        return $phone;
    }
}
