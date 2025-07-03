<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Naildesign;
use App\Models\Like;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Naildesign::query();
        $query = Naildesign::withCount('likes');

        if ($request->has('design_type') && $request->input('design_type') !== 'all') {
            $query->where('design_type', $request->input('design_type'));
        }

        if ($request->has('sort') && $request->input('sort') === 'newest') {
            $query->orderBy('created_at', 'desc')->limit(10);
        }

        if ($request->has('recommended') && $request->input('recommended') == 'true') {
            $query->orderByDesc('likes_count')->limit(10);
        }

        $naildesign = $query->get();

        return view('welcome', compact('naildesign'));
    }

    public function index1()
    {


        return view('test');
    }

    public function index2(Request $request) {
        auth()->logout(); // ออกจากระบบ
        return redirect('/'); // ส่งผู้ใช้กลับไปที่หน้าแรก
    }
}
