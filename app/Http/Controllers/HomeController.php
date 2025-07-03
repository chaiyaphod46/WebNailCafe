<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Naildesign;
use App\Models\Timereservs;
use App\Models\User;
use App\Models\ClosedDate;
use App\Models\DetailTimereserv;
use App\Models\OtherService;
use App\Models\Promotion;
use App\Models\Like;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $query = Naildesign::query();
        $user = Auth::user();
        $query = Naildesign::withCount('likes');

// ใหม่----------------------------------
        // กรองตามประเภทลายเล็บ
        if ($request->has('design_type') && $request->input('design_type') !== 'all') {
            $query->where('design_type', $request->input('design_type'));
        }

        // เรียงลายเล็บใหม่ล่าสุด
        if ($request->has('sort') && $request->input('sort') === 'newest') {
            $query->orderBy('created_at', 'desc')->limit(10);
        }

        // เรียงลายเล็บแนะนำ (ยอดไลก์สูงสุด)
        elseif ($request->has('recommended') && $request->input('recommended') == 'true') {
            $query->orderByDesc('likes_count')->limit(10);
        }
// ----------------------------------
        $naildesign = $query->get();

        return view('home', compact('naildesign','user'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminHome()
    {
        return view('adminHome');
    }

    public function show()
    {
          // ดึงข้อมูลการจองเเละรายละเอียดการจองและลายเล็บ
        $reservations = Timereservs::with(['user', 'detailTimereservs.nailDesign'])->get();
        // ดึงข้อมูลการจอง และตรวจสอบสถานะ
    $bookedEvents = Timereservs::select('reservs_start as start', 'reservs_end as end', 'statusdetail')
    ->get()
    ->map(function ($event) {
        return [
            'start' => $event->start,
            'end' => $event->end,
            'color' => $event->statusdetail === 'จองสำเร็จ' ? 'green' : 'blue', // สีเขียวถ้าจองสำเร็จ
        ];
    });
        $closedDates = ClosedDate::pluck('closed_date');
        return view('adminHome', compact('reservations', 'bookedEvents','closedDates'));
    }

   public function getReservationDetails(Request $request)
    {
         // ดึงข้อมูลการจองจากวันที่ที่ได้รับ
        $reservation = Timereservs::where('reservs_start', $request->date)
            ->with(['user', 'detailTimereservs.nailDesign', 'detailTimereservs.additionalServices', 'promotion'])
            ->first();

        // ส่งข้อมูลการจอง กลับในรูปแบบ JSON สำหรับ AJAX
        return response()->json([
            'html' => view('reservationDetails', compact('reservation'))->render()
        ]);
    }





}
