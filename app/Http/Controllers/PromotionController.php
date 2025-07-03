<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promotion;
use App\Models\Naildesign;
use Carbon\Carbon;
use App\Models\DetailPromotion;

class PromotionController extends Controller
{
    public function index()
    {
        $naildesigns = \App\Models\Naildesign::all();

        // ตรวจสอบวันที่ปัจจุบัน
        $today = Carbon::now();

        $promotions = Promotion::all();
        foreach ($promotions as $promotion) {
            $promotion->start_time = Carbon::parse($promotion->start_time);
            $promotion->end_time = $promotion->end_time ? Carbon::parse($promotion->end_time) : null;

        // อัปเดตสถานะ
        if ($promotion->start_time > $today) {
            // ถ้ายังไม่ถึงเวลาของ start_time ให้สถานะเป็น D (ใช้ไม่ได้)
            $promotion->status = 'D';
        } elseif ($promotion->end_time && $promotion->end_time < $today) {
            // ถ้าเลยเวลาของ end_time ให้สถานะเป็น D (ใช้ไม่ได้)
            $promotion->status = 'D';
        } else {
            // ถ้าอยู่ระหว่าง start_time และ end_time ให้สถานะเป็น A (ใช้ได้)
            $promotion->status = 'A';
        }

        $promotion->save(); // บันทึกการเปลี่ยนแปลง
        }
        return view('add_promotion', compact('promotions', 'naildesigns'));
    }

    public function store(Request $request)
    {


        $request->validate([
            'promotion_name' => 'required|string|max:255',
            'promotion_code' => 'required|string|max:255',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric',
            'nail_names' => 'required|array|min:1', // ตรวจสอบให้เลือกอย่างน้อยหนึ่งลายเล็บ
            'nail_names.*' => 'exists:naildesigns,nail_design_id',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after:start_time',
        ]);


        $promotion = Promotion::create([
            'promotion_name' => $request->promotion_name,
            'promotion_code' => $request->promotion_code,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,

        ]);

         // บันทึกข้อมูล nail_names
    if ($request->has('nail_names')) {
        foreach ($request->nail_names as $nail_design_id) {
            DetailPromotion::create([
                'promotion_id' => $promotion->promotion_id,
                'nail_design_id' => $nail_design_id,
            ]);
        }
    }
        session()->flash('success', 'บันทึกสำเร็จ');
        return redirect()->back();
    }

    public function deletepromotion($promotion_id)
    {
        $promotion = Promotion::findOrFail($promotion_id);
        $promotion->delete();

        session()->flash('success', 'ลบสำเร็จ');
        return redirect()->back();
    }

    public function editpromotion($promotion_id)
    {
        $promotion = Promotion::find($promotion_id);

        $promotion->start_time = Carbon::parse($promotion->start_time)->format('Y-m-d');
        $promotion->end_time = $promotion->end_time ? Carbon::parse($promotion->end_time)->format('Y-m-d') : null;

        $selectedNailDesigns = DetailPromotion::where('promotion_id', $promotion_id)->pluck('nail_design_id')->toArray();
        $naildesigns = NailDesign::all(); // ดึงข้อมูลลายเล็บทั้งหมด

        return view('edit_promotion', compact('promotion','naildesigns','selectedNailDesigns'));
    }

    public function saveeditpromotion(Request $request, $promotion_id)
    {
        $promotion = Promotion::find($promotion_id);
        $promotion->promotion_name = $request->promotion_name;
        $promotion->promotion_code = $request->promotion_code;
        $promotion->discount_value = $request->discount_value;
        $promotion->discount_type = $request->discount_type;
        $promotion->start_time = $request->start_time;
        $promotion->end_time = $request->end_time;


        $promotion->save();

        DetailPromotion::where('promotion_id', $promotion_id)->delete();

    // เพิ่มลายเล็บที่เลือกใหม่
    if ($request->has('nail_names')) {
        foreach ($request->nail_names as $nailDesignId) {
            DetailPromotion::create([
                'promotion_id' => $promotion_id,
                'nail_design_id' => $nailDesignId,
            ]);
        }
    }
        session()->flash('success', 'แก้ไขโปรโมชันสำเร็จ');
        return redirect()->back();
    }




}
