<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ShowUserController extends Controller
{
    public function index()
    {
        // ดึงข้อมูลลูกค้าที่ไม่ใช่แอดมินจาก table users
        $users = User::where('is_admin', false)->get();
        return view('showuser', compact('users'));
    }
}
