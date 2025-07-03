<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class ProfileController extends Controller
{
    public function edit()
{
    $user = Auth::user();
    return view('edit_profile', compact('user'));
}

public function update(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'phon' => 'required|string|max:10',
    ]);

    $user = Auth::user();
    $user->update([
        'name' => $request->input('name'),
        'phon' => $request->input('phon'),
    ]);

    return back()->with('success', 'แก้ไขข้อมูลส่วนตัวเรียบร้อยแล้ว');
}
}
