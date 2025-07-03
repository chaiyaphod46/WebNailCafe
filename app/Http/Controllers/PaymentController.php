<?php

namespace App\Http\Controllers;

use App\Models\Timereservs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Stripe\Stripe;
use Stripe\Checkout\Session as CheckoutSession;
use Stripe\PaymentIntent;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function getOrder($id)
    {
        $payment = DB::table('payments')->where('order_id', $id)->first();
    
        if (!$payment) {
            return response()->json(['error' => 'Payment not found'], 404);
        }
    
        return response()->json($payment);
    }
    
    public function updateOrder($id)
    {
        DB::table('payments')
            ->where('order_id', $id)
            ->update(['status' => 'ชำระเงินเเล้ว', 'payment_date' => now()]);

            
    
        return response()->json(['message' => 'Payment updated.']);
    }

    
    


   
}
