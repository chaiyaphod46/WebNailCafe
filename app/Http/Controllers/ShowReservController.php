<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Timereservs;
use App\Models\User;


class ShowReservController extends Controller
{
    public function showReservations(Request $request)
{
    $user = Auth::user();
    $userId = Auth::id();
    $filter = $request->query('filter', 'active'); // ค่าเริ่มต้นคือ active

    // กรองตาม filter ที่เลือก
    if ($filter == 'history') {
        // ดึงเฉพาะรายการที่ reservs_end ผ่านมาแล้ว และ statusdetail เป็น "จองสำเร็จ"
        $reservations = Timereservs::with('detailTimereservs.nailDesign', 'detailTimereservs.additionalServices', 'promotion')
            ->where('id', $userId)
            ->where('reservs_end', '<', now()) 
            ->where('statusdetail', 'จองสำเร็จ')
            ->get();
    } else {
        // ดึงเฉพาะรายการที่ reservs_end ยังไม่หมดอายุ
        $reservations = Timereservs::with('detailTimereservs.nailDesign', 'detailTimereservs.additionalServices', 'promotion')
            ->where('id', $userId)
            ->where('reservs_end', '>=', now())
            ->get();
    }
    

    return view('showreserv', ['reservations' => $reservations, 'user' => $user]);
}

    public function cancel($reservs_id)
    {
        $reservation = Timereservs::where('reservs_id', $reservs_id)->first();
    
        if ($reservation) {
            $reservation->statusdetail = 'ยกเลิกการจองจากผู้ใช้';
            $reservation->save();
        
            $reservation->delete();

            return redirect()->back()->with('success', 'การจองถูกยกเลิกแล้ว');
        } else {
            return redirect()->back()->with('error', 'ไม่พบการจองที่ต้องการยกเลิก');
        }

        
    }

    
    
    

    
}
