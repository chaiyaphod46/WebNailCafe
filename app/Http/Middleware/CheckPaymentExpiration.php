<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Timereservs;

class CheckPaymentExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

     // เพิ่มตอนนับเวลาถอยหลัง
     public function handle($request, Closure $next)
     {
         $reservs_id = $request->route('reservs_id');
         $reservation = Timereservs::where('reservs_id', $reservs_id)->first();
     
         if ($reservation && $reservation->payment_expiration && now()->greaterThan($reservation->payment_expiration)) {
             if ($reservation->statusdetail == 'รอชำระเงินมัดจำ') {
                 $reservation->statusdetail = 'หมดเวลาชำระเงิน';
                 $reservation->save();
                 $reservation->delete();
             }
         }
     
         return $next($request);
     }
}
