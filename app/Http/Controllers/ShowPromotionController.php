<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promotion;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\DetailPromotion;
use App\Models\Naildesign;

class ShowPromotionController extends Controller
{
    public function showPromotion()
    {
        $user = Auth::user();
       // ดึงข้อมูลเฉพาะโปรโมชั่นที่มี status เป็น 'A'
        $promotions = Promotion::where('status', 'A')->get();

        foreach ($promotions as $promotion) {
            $promotion->start_time = Carbon::parse($promotion->start_time);
            $promotion->end_time = $promotion->end_time ? Carbon::parse($promotion->end_time) : null;
        }
        return view('showpromotion', compact('promotions','user'));
    }

    public function formatPromotionDate($date)
    {
    return Carbon::parse($date)->translatedFormat('j F Y');
    }

    public function showPromotionDetails($id)
    {
        $promotion = Promotion::with('detailPromotions.nailDesign')->findOrFail($id);

        return view('showdetail_promotion', compact('promotion'));
    }
}
