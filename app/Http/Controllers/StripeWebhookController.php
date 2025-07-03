<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Event;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $endpoint_secret = 'whsec_091695ab786d9dbc219c70574c1297b016a0c6aa27faeff163803670fe37ea74';

        $payload = $request->getContent();
        $event = null;

        try {
            $event = Event::constructFrom(json_decode($payload, true));
        } catch (\UnexpectedValueException $e) {
            return response()->json(['error' => 'Invalid payload'], 400);
        }
    
        if ($endpoint_secret) {
            $sig_header = $request->header('Stripe-Signature');
            try {
                $event = Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
            } catch (SignatureVerificationException $e) {
                return response()->json(['error' => 'Invalid signature'], 400);
            }
        }
    
        if ($event->type === 'checkout.session.completed') {
            $paymentSuccessData = $event->data->object;
            $sessionId = $paymentSuccessData->id;
            $status = $paymentSuccessData->status;
    
            // อัปเดตสถานะในตาราง payments
            $payment = DB::table('payments')->where('session_id', $sessionId)->first();
            if ($payment) {
                DB::table('payments')
                    ->where('session_id', $sessionId)
                    ->update([
                        'status' => $status,
                        'payment_date' => now(), // บันทึกวันที่ชำระเงิน
                    ]);
    
                Log::info("Updating payment status for session_id: $sessionId, status: $status");
    
                return response()->json(['message' => 'Payment updated.']);
            } else {
                return response()->json(['message' => 'Payment not found.'], 404);
            }
        }
    
        return response()->json(['status' => 'success'], 200);
    }


}
