<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function createSource(Request $request)
    {
        $request->validate([
            'amount' => 'required|integer|min:1',
        ]);

        $amount = $request->input('amount') * 100; // Convert to satang
        $currency = 'THB';

        $publicKey = config('services.omise.public_key');
        $secretKey = config('services.omise.secret_key');

        if (!$publicKey || !$secretKey) {
            return response()->json(['error' => 'API keys are not set properly'], 400);
        }

        // Debugging: Log the keys to check if they are loaded
        \Log::info('OMISE_PUBLIC_KEY: ' . $publicKey);
        \Log::info('OMISE_SECRET_KEY: ' . $secretKey);

        // Define Omise API keys
        define('OMISE_PUBLIC_KEY', $publicKey);
        define('OMISE_SECRET_KEY', $secretKey);

        try {
            $source = \OmiseSource::create([
                'type' => 'promptpay',
                'amount' => $amount,
                'currency' => $currency,
            ]);

            return response()->json($source);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
