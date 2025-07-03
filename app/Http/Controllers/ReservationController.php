<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Reserv;
use App\Models\OpeningHour;
use App\Models\Timereservs;
use App\Models\Naildesign;
use App\Models\OtherService;
use App\Models\DetailTimereserv;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Promotion;
use App\Models\UseCode;
use App\Models\DetailPromotion;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Checkout\Session as StripeSession;
use App\Models\Payment;
use Illuminate\Support\Facades\Session;


class ReservationController extends Controller
{
    public function create(Request $request)
    {
        // ตรวจสอบข้อมูลที่ได้รับ
        $validatedData = $request->validate([
            'date' => 'required|date',
            'nail' => 'required|exists:naildesigns,nail_design_id',
            'additional_services' => 'array',
            'promotion_code' => 'nullable|string' // รับค่า promotion_code ได้
        ]);

        // ดึงข้อมูลลายเล็บและคำนวณเวลารวม
        $nailDesign = Naildesign::findOrFail($validatedData['nail']);
        $designTime = $nailDesign->design_time;
        $designPrice = $nailDesign->design_price;

        // คำนวณราคารวมของบริการเสริม
        $additionalServices = $request->input('additional_services', []);
        $totalServiceTime = $designTime;
        $totalServicePrice = 0; // ราคารวมของบริการเสริม

        foreach ($additionalServices as $serviceId) {
            $service = OtherService::where('service_id', $serviceId)->first();
            if ($service) {
                $totalServiceTime += $service->service_time;
                $totalServicePrice += $service->service_price;
            }
        }

        // คำนวณราคารวมก่อนใช้โปรโมชั่น (รวมลายเล็บและบริการเสริม)
        $totalPrice = $designPrice + $totalServicePrice;

        // คำนวณราคาหลังลดเฉพาะลายเล็บ
        $usePromotionPrice = null; // ตั้งค่าเริ่มต้นเป็น null
        $promotion = null;

        if (!empty($validatedData['promotion_code'])) {
            $promotion = Promotion::where('promotion_code', $validatedData['promotion_code'])
                                ->where('status', 'A')
                                ->first();

                                // ตรวจสอบว่าโปรโมชั่นยังไม่เคยใช้โดยผู้ใช้คนนี้
            if ($promotion) {
                $promotionUsed = UseCode::where('user_id', $request->user()->id)
                                        ->where('promotion_id', $promotion->promotion_id)
                                        ->exists();

                                if ($promotionUsed) {
                                        return response()->json(['  เตือน!!!  ' => '  คุณเคยใช้โค้ดโปรโมชั่นนี้แล้ว  '], 400, [], JSON_UNESCAPED_UNICODE);
                                    }

                if ($promotion) {
                    $detailPromotion = DetailPromotion::where('promotion_id', $promotion->promotion_id)
                        ->where(function($query) use ($validatedData) {
                            $query->where('nail_design_id', $validatedData['nail']);
                        })
                        ->first();

                    // ตรวจสอบว่ามีเงื่อนไข promotion หรือไม่
                    if (!$detailPromotion && DetailPromotion::where('promotion_id', $promotion->promotion_id)->count() === 0) {
                        $detailPromotion = true; // promotion ใช้ได้กับทุก nail_design_id
                    }

                    if ($detailPromotion) {
                        // คำนวณส่วนลดตามประเภท
                        if ($promotion->discount_type === 'percentage') {
                            $usePromotionPrice = $designPrice - ($designPrice * ($promotion->discount_value / 100));
                        } elseif ($promotion->discount_type === 'fixed') {
                            $usePromotionPrice = $designPrice - $promotion->discount_value;
                        }

                        // ตรวจสอบไม่ให้ราคาติดลบ
                        $usePromotionPrice = max($usePromotionPrice, 0);
                    }
                }
            }
        }
        // คำนวณเวลาเริ่มต้นและเวลาสิ้นสุดสำหรับการจอง
        $start = new \DateTime($validatedData['date']);
        $end = (clone $start)->add(new \DateInterval('PT' . (int)($totalServiceTime * 60) . 'M'));

        // บันทึกข้อมูลการจองใน Timereservs
        $reservation = new Timereservs();
        $reservation->id = $request->user()->id;
        $reservation->reservs_start = $start->format('Y-m-d H:i:s');
        $reservation->reservs_end = $end->format('Y-m-d H:i:s');
        $reservation->price = $totalPrice; // ราคารวมลายเล็บและบริการเสริม

        // บันทึกข้อมูลการใช้โปรโมชั่นเฉพาะเมื่อมีการลดราคา
        if ($usePromotionPrice !== null && $usePromotionPrice < $designPrice) {
            $reservation->use_promotion_price = $usePromotionPrice + $totalServicePrice; // ราคาลายเล็บหลังลด + บริการเสริม
            $reservation->promotion_id = $promotion->promotion_id;
        }


        // บันทึกข้อมูลการใช้โปรโมชั่นในตาราง use_code
        if ($promotion) {
            UseCode::create([
                'user_id' => $request->user()->id,
                'promotion_id' => $promotion->promotion_id,
            ]);
        }

        if ($reservation->save()) {
            // บันทึกรายละเอียดการจอง
            $reservationId = $reservation->reservs_id;

            if (empty($additionalServices)) {
                DetailTimereserv::create([
                    'C_id' => $request->user()->id,
                    'reservs_id' => $reservationId,
                    'nail' => $validatedData['nail']
                ]);
            } else {
                foreach ($additionalServices as $serviceId) {
                    DetailTimereserv::create([
                        'C_id' => $request->user()->id,
                        'reservs_id' => $reservationId,
                        'nail' => $validatedData['nail'],
                        'additional_services' => $serviceId
                    ]);
                }
            }
            //$reservation->payment_expiration = now()->addMinutes(1);
            // $reservation->payment_expiration = now()->addHours(2);
            $reservation->payment_expiration = now()->addSeconds(60); // ตั้งเวลาให้หมดอายุภายใน นาที
            $reservation->save();



            return response()->json([
                'message' => 'การจองสำเร็จ!',
                'reservs_id' => $reservation->reservs_id // ส่งรหัสการจองกลับไป
            ]);
        } else {
            return response()->json(['message' => 'การจองล้มเหลว'], 500);
        }

    }


    private function getBookedEvents() {
        $bookedEvents = Timereservs::select('reservs_start as start', 'reservs_end as end')->get();
        return $bookedEvents;
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        $bookedEvents = $this->getBookedEvents();
        $nailDesigns = Naildesign::query();

        if ($request->filled('design_type') && $request->design_type !== 'all') {
            $nailDesigns->where('design_type', $request->design_type);
        }

        $nailDesigns = $nailDesigns->get();
        $otherServices = OtherService::all();

        return view('reserv', compact('bookedEvents', 'nailDesigns', 'otherServices','user'));
    }
    public function checkPromotion(Request $request)
    {
        $request->validate([
            'promotion_code' => 'required|string',
            'nail_design_id' => 'required|exists:naildesigns,nail_design_id', // ตรวจสอบ nail_design_id
        ]);

        $promotion = Promotion::where('promotion_code', $request->promotion_code)
                          ->where('status', 'A')
                          ->first();

        if ($promotion) {
            $detailPromotion = DetailPromotion::where('promotion_id', $promotion->promotion_id)
                ->where(function($query) use ($request) {
                    $query->where('nail_design_id', $request->nail_design_id); // ยอมรับทุก nail_design_id
                })
                ->first();

            if (!$detailPromotion && DetailPromotion::where('promotion_id', $promotion->promotion_id)->count() === 0) {
                $detailPromotion = true; // promotion ใช้ได้กับทุก nail_design_id
            }

            if ($detailPromotion) {
                return response()->json([
                    'valid' => true,
                    'discount_value' => $promotion->discount_value,
                    'discount_type' => $promotion->discount_type,
                ]);
            }
        }
        return response()->json(['valid' => false]);
    }

    public function cancel($reservs_id)
    {
        $reservation = Timereservs::where('reservs_id', $reservs_id)->first();

            if ($reservation) {
                $reservation->statusdetail = 'ยกเลิกการจอง';
                $reservation->save();

                $reservation->delete();

                return redirect()->back()->with('success', 'การจองถูกยกเลิกแล้ว');
            } else {
                return redirect()->back()->with('error', 'ไม่พบการจองที่ต้องการยกเลิก');
            }
    }

    public function confirm($reservs_id)
    {
        $reservation = Timereservs::where('reservs_id', $reservs_id)->first();

        if ($reservation) {
            $reservation->statusdetail = 'จองสำเร็จ';
            $reservation->save();

            return redirect()->back()->with('success', 'การจองได้รับการยืนยันแล้ว');
        } else {
            return redirect()->back()->with('error', 'ไม่พบการจองที่ต้องการยืนยัน');
        }
    }

    // เพิ่มตอนนับเวลาถอยหลัง
    public function getExpiration($reservs_id)
{
    $reservation = Timereservs::where('reservs_id', $reservs_id)->first();

    if (!$reservation || !$reservation->payment_expiration) {
        return response()->json(['error' => 'ไม่พบเวลาหมดอายุ'], 404);
    }

    return response()->json(['expiration' => $reservation->payment_expiration]);
}

// เพิ่มตอนนับเวลาถอยหลัง
public function cancelReservation($reservs_id)
{
    $reservation = Timereservs::where('reservs_id', $reservs_id)->first();

    if ($reservation) {
        // ตรวจสอบว่าหากสถานะเป็น 'จองสำเร็จ' หรือสถานะอื่นที่ไม่ต้องการให้ยกเลิก ต้องไม่ให้เปลี่ยนแปลง
        if ($reservation->statusdetail == 'จองสำเร็จ') {
            return response()->json(['message' => 'ไม่สามารถยกเลิกได้ เนื่องจากสถานะคือ "จองสำเร็จ"']);
        }

        if ($reservation->statusdetail == 'รอชำระเงินมัดจำ') {
            $reservation->statusdetail = 'หมดเวลาชำระเงิน';
            $reservation->save();
            $reservation->delete();
            return response()->json(['message' => 'การจองถูกยกเลิก']);
        } else {
            return response()->json(['message' => 'การจองล่าสุดมีการชำระเงินแล้ว']);
        }
    }

    return response()->json(['message' => 'ไม่พบการจอง'], 404);
}
// เช็คการจองก่อนหน้าว่าค้างชำระไหม
public function checkPendingDeposit(Request $request)
{
    $user_id = $request->user_id;

    // เปลี่ยนจาก where('user_id', $user_id) เป็น where('id', $user_id)
    $pending = Timereservs::where('id', $user_id)
                         ->where('statusdetail', 'รอชำระเงินมัดจำ')
                         ->exists();

    return response()->json(['pending' => $pending]);
}


}
