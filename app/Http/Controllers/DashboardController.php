<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timereservs;
use App\Models\User;
use App\Models\Payment;
use Carbon\Carbon;
use App\Models\UseCode;
use App\Models\Promotion;
use App\Models\DetailTimereserv;

class DashboardController extends Controller
{
    public function index()
    {
        Carbon::setLocale('th');
         // ดึงจำนวนการจองทั้งหมดจากตาราง timereservs
        $totalReservations = Timereservs::withTrashed()->count(); // ใช้ withTrashed() เพื่อรวมรายการที่ถูกลบด้วย Soft Delete

        $reservations = Timereservs::withTrashed()->with('user')->get();

         // ดึงรายการจองที่มีสถานะ "จองสำเร็จ"
        $successfulBookings = Timereservs::where('statusdetail', 'จองสำเร็จ')->count();

         // ดึงรายละเอียดการจองสำเร็จ
        $successfulBookingDetails = Timereservs::where('statusdetail', 'จองสำเร็จ')
            ->with('user') // โหลดข้อมูลผู้จอง
            ->get();

        // ดึงรายการที่ถูกยกเลิกการจองจากตาราง timereservs "
        $cancelledBookings = Timereservs::withTrashed()
        ->whereIn('statusdetail', ['ยกเลิกการจอง', 'หมดเวลาชำระเงิน', 'ยกเลิกการจองจากผู้ใช้'])
        ->count(); // ใช้ count() เพื่อหาจำนวนรายการที่ยกเลิก

        $allcancelledBookingDetails = Timereservs::withTrashed()
        ->whereIn('statusdetail', ['ยกเลิกการจอง', 'หมดเวลาชำระเงิน', 'ยกเลิกการจองจากผู้ใช้'])
        ->with('user') // ดึงข้อมูลผู้จอง
        ->get();


        $expiredPayments = Timereservs::withTrashed()
        ->where('statusdetail', 'หมดเวลาชำระเงิน')
        ->with('user') // โหลดข้อมูลผู้ใช้
        ->get();

        $ownerCancelledBookings = Timereservs::withTrashed()
        ->where('statusdetail', 'ยกเลิกการจอง')
        ->count();

        $cancelledBookingDetails = Timereservs::withTrashed()
        ->where('statusdetail', 'ยกเลิกการจอง')
        ->with('user') // โหลดข้อมูลผู้จอง
        ->get();


        // ดึงรายการที่ถูกยกเลิกโดยผู้ใช้
        $cancelledBookingsbyUser = Timereservs::withTrashed()
        ->where('statusdetail', 'ยกเลิกการจองจากผู้ใช้')
        ->count();

        // ดึงรายละเอียดการจองที่ถูกยกเลิกโดยผู้ใช้
        $cancelledBookingbyUserDetails = Timereservs::withTrashed()
        ->where('statusdetail', 'ยกเลิกการจองจากผู้ใช้')
        ->with('user') // โหลดข้อมูลผู้ใช้ที่จอง
        ->get();


         // ดึงข้อมูลลูกค้าที่ไม่ใช่แอดมิน และคำนวณจำนวนการจองสำเร็จและการยกเลิก
         $customers = User::where('is_admin', '!=', 1)
    ->withCount([
        'timereservs as successful_count' => function ($query) {
            $query->where('statusdetail', 'จองสำเร็จ');
        },
        'timereservs as cancelled_count' => function ($query) {
            $query->withTrashed()->whereIn('statusdetail', ['ยกเลิกการจองจากผู้ใช้']);
        },
        'timereservs as expired_payment_count' => function ($query) {
            $query->withTrashed()->whereIn('statusdetail', ['หมดเวลาชำระเงิน']);
        }
    ])
    ->paginate(10); // แบ่งหน้า หน้าละ 10 รายชื่อ

            $totalUsers = User::where('is_admin', '!=', 1)->count();

       // ดึงข้อมูลการชำระเงินที่จ่ายเข้ามา
    $payments = Payment::where('status', 'ชำระเงินเเล้ว')
    ->join('timereservs', 'payments.reservs_id', '=', 'timereservs.reservs_id')
    ->join('users', 'timereservs.id', '=', 'users.id')
    ->select('payments.amount', 'payments.payment_date',  'users.name as customer_name','timereservs.statusdetail', 'timereservs.deleted_at', 'payments.reservs_id')
    ->get();

    // กรองเฉพาะค่ามัดจำที่เป็น +300 เท่านั้น
    $depositPayments = $payments->filter(function ($payment) {
        return $payment->statusdetail !== 'ยกเลิกการจอง'; // ตัดออกถ้าเป็นการยกเลิก
    });

    // คำนวณค่ามัดจำทั้งหมด
    $totalDeposit = $payments->sum(function ($payment) {
        return ($payment->statusdetail === 'ยกเลิกการจอง') ? ($payment->amount - 300) : $payment->amount;
    });

     // คำนวณค่ามัดจำที่ต้องคืน
     $refundAmount = $payments->sum(function ($payment) {
        return ($payment->statusdetail === 'ยกเลิกการจอง') ? -300 : 0;
    });

    $refundPayments = $payments->filter(function ($payment) {
        return $payment->statusdetail === 'ยกเลิกการจอง';
    });

    // จัดกลุ่มข้อมูลตามวันที่
    $groupedPayments = [];
    foreach ($payments as $payment) {
        $dateKey = ($payment->statusdetail === 'ยกเลิกการจอง' && $payment->deleted_at)
            ? Carbon::parse($payment->deleted_at)->format('Y-m-d') // เปลี่ยนเป็น YYYY-MM-DD (ไม่ใช่ภาษาไทย)
            : Carbon::parse($payment->payment_date)->format('Y-m-d');

        $type = ($payment->statusdetail === 'ยกเลิกการจอง' && $payment->deleted_at) ? 'red' : 'green';

        if (!isset($groupedPayments[$dateKey][$type])) {
            $groupedPayments[$dateKey][$type] = ['total' => 0, 'details' => []];
        }

        $amount = ($type === 'red') ? -300 : $payment->amount;
        $groupedPayments[$dateKey][$type]['total'] += $amount;
        $groupedPayments[$dateKey][$type]['details'][] = [
            'reservs_id' => $payment->reservs_id,
            'time' => Carbon::parse(($type === 'red') ? $payment->deleted_at : $payment->payment_date)->translatedFormat('d F Y เวลา H:i'), // แสดงภาษาไทย
            'amount' => $amount,
            'status' => $payment->statusdetail
        ];
    }

    // แปลงข้อมูลสำหรับ FullCalendar
    $paymentEvents = [];
    foreach ($groupedPayments as $date => $types) {
        foreach ($types as $type => $data) {
            $paymentEvents[] = [
                'title' => ($type === 'green' ? '+' : '') . $data['total'],
                'start' => $date, // ใช้ YYYY-MM-DD ตามปกติ
                'color' => $type,
                'textColor' => 'white',
                'details' => $data['details']
            ];
        }
    }

    // จำนวนครั้งที่เจ้าของร้านยกเลิกรายการจองของลูกค้า ที่ลูกค้าชำระเงินเเล้ว
    $cancelledPaidBookings = Payment::where('payments.status', 'ชำระเงินเเล้ว')
    ->join('timereservs', 'payments.reservs_id', '=', 'timereservs.reservs_id')
    ->where('timereservs.statusdetail', 'ยกเลิกการจอง')
    ->count();

    $cancelledPaidBookingDetails = Payment::where('payments.status', 'ชำระเงินเเล้ว')
    ->join('timereservs', 'payments.reservs_id', '=', 'timereservs.reservs_id')
    ->join('users', 'timereservs.id', '=', 'users.id')
    ->where('timereservs.statusdetail', 'ยกเลิกการจอง')
    ->select(
        'timereservs.reservs_id',
        'users.name as customer_name',
        'timereservs.reservs_start',
        'timereservs.reservs_end',
        'payments.payment_date',
        'timereservs.deleted_at',
        'timereservs.statusdetail'
    )
    ->get();


    // จำนวนครั้งที่ลูกค้ายกเลิกรายการจองของลูกค้าเอง ที่ลูกค้าชำระเงินเเล้ว
    $userCancelledPaidBookings = Payment::where('status', 'ชำระเงินเเล้ว')
    ->join('timereservs', 'payments.reservs_id', '=', 'timereservs.reservs_id')
    ->where('timereservs.statusdetail', 'ยกเลิกการจองจากผู้ใช้')
    ->count();


    $cancelledPaidBookingbyUserDetails = Payment::where('payments.status', 'ชำระเงินเเล้ว')
            ->join('timereservs', 'payments.reservs_id', '=', 'timereservs.reservs_id')
            ->join('users', 'timereservs.id', '=', 'users.id')
            ->where('timereservs.statusdetail', 'ยกเลิกการจองจากผู้ใช้')
            ->select(
                'timereservs.reservs_id',
                'users.name as customer_name',
                'timereservs.reservs_start',
                'timereservs.reservs_end',
                'payments.payment_date',
                'timereservs.deleted_at',
                'timereservs.statusdetail'
            )
            ->get();


    // คำนวณจำนวนครั้งที่ใช้โค้ดโปรโมชั่นทั้งหมด
    $totalPromotionUsage = UseCode::count();

     // ดึงข้อมูลโปรโมชั่นที่มีการใช้ และเรียงจากจำนวนการใช้มากไปน้อย
     $usedPromotions = UseCode::select('promotion_id', \DB::raw('COUNT(*) as usage_count'))
        ->groupBy('promotion_id')
        ->orderByDesc('usage_count')
        ->paginate(10) // ใช้ paginate(10) โดยตรง
        ->through(function ($promo) { // ใช้ through() แทน transform()
            $promotion = Promotion::find($promo->promotion_id);
        return [
            'promotion_name' => $promotion->promotion_name,
            'promotion_code' => $promotion->promotion_code,
            'discount_type' => $promotion->discount_type,
            'discount_value' => $promotion->discount_value,
            'usage_count' => $promo->usage_count
        ];
    });


     // ดึงข้อมูลโปรโมชั่นที่ถูกใช้ พร้อมกับชื่อผู้ใช้ และรายละเอียดโปรโมชัน
     $usedPromotionsbyUser = UseCode::join('users', 'use_code.user_id', '=', 'users.id')
     ->join('promotions', 'use_code.promotion_id', '=', 'promotions.promotion_id')
     ->select(
         'users.name as customer_name',
         'users.email as customer_email',
         'promotions.promotion_name',
         'promotions.promotion_code',
         \DB::raw('COUNT(use_code.promotion_id) as usage_count')
     )
     ->groupBy('users.id', 'users.name', 'users.email', 'promotions.promotion_name', 'promotions.promotion_code')
     ->orderByDesc('usage_count')
     ->paginate(10);

  // ดึงลายเล็บที่ถูกจองสำเร็จ และเลือกมาแค่ 1 รูปต่อการจอง
    $popularNailDesigns = DetailTimereserv::whereHas('timereserv', function ($query) {
    $query->where('statusdetail', 'จองสำเร็จ');
    })
        ->select('nail', \DB::raw('COUNT(DISTINCT reservs_id) as total_reservations'))
        ->whereNotNull('nail')
        ->groupBy('nail')
        ->orderByDesc('total_reservations')
        ->limit(7)
        ->with('nailDesign') // โหลดข้อมูลลายเล็บที่เกี่ยวข้อง
        ->get();


         return view('dashboard', compact('totalReservations', 'reservations','successfulBookings','cancelledBookings', 'customers','totalDeposit'
         , 'paymentEvents', 'ownerCancelledBookings', 'cancelledBookingDetails','allcancelledBookingDetails','totalUsers','refundAmount', 'expiredPayments','usedPromotions','totalPromotionUsage',
         'popularNailDesigns', 'cancelledPaidBookings', 'cancelledPaidBookingbyUserDetails', 'cancelledPaidBookingDetails', 'userCancelledPaidBookings','usedPromotionsbyUser'
         , 'successfulBookingDetails','cancelledBookingsbyUser', 'cancelledBookingbyUserDetails', 'payments', 'depositPayments', 'refundPayments'));
    }

    public function getDepositDataYearly(Request $request)
{
    $year = $request->input('year', now()->year); // รับค่า year จาก request, default เป็นปีปัจจุบัน

    $monthlyData = array_fill(1, 12, ['deposit' => 0, 'refund' => 0]);

    $payments = Payment::where('status', 'ชำระเงินเเล้ว')
        ->whereYear('payment_date', $year)
        ->join('timereservs', 'payments.reservs_id', '=', 'timereservs.reservs_id')
        ->selectRaw('MONTH(payment_date) as month,
                     SUM(CASE WHEN timereservs.statusdetail = "ยกเลิกการจอง" THEN amount - 300 ELSE amount END) as deposit,
                     SUM(CASE WHEN timereservs.statusdetail = "ยกเลิกการจอง" THEN 300 ELSE 0 END) as refund')
        ->groupByRaw('MONTH(payment_date)')
        ->get();

    foreach ($payments as $payment) {
        $monthlyData[$payment->month] = [
            'deposit' => $payment->deposit,
            'refund' => $payment->refund
        ];
    }

    return response()->json([
        'deposit' => array_column($monthlyData, 'deposit'),
        'refund' => array_column($monthlyData, 'refund')
    ]);
}


public function getBookingStatistics()
{
    $year = now()->year; // ปีปัจจุบัน
    $bookings = Timereservs::withTrashed()
        ->selectRaw('MONTH(created_at) as month,
                     SUM(CASE WHEN statusdetail = "จองสำเร็จ" THEN 1 ELSE 0 END) as successful,
                     SUM(CASE WHEN statusdetail IN ("ยกเลิกการจอง", "หมดเวลาชำระเงิน", "ยกเลิกการจองจากผู้ใช้") THEN 1 ELSE 0 END) as cancelled')
        ->whereYear('created_at', $year)
        ->groupByRaw('MONTH(created_at)')
        ->orderByRaw('MONTH(created_at)')
        ->get();

    // สร้าง array ให้มีค่า default ทุกเดือน (กรณีไม่มีข้อมูล)
    $monthlyData = array_fill(1, 12, ['successful' => 0, 'cancelled' => 0]);

    foreach ($bookings as $booking) {
        $monthlyData[$booking->month] = [
            'successful' => $booking->successful,
            'cancelled' => $booking->cancelled,
        ];
    }

    return response()->json([
        'labels' => array_map(fn($m) => date("F", mktime(0, 0, 0, $m, 1)), range(1, 12)),
        'successful' => array_column($monthlyData, 'successful'),
        'cancelled' => array_column($monthlyData, 'cancelled'),
    ]);
}





}
