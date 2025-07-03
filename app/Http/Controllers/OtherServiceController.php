<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OtherService;

class OtherServiceController extends Controller
{
    public function index()
    {   
        $otherServices = OtherService::all();
        return view('add_otherservice', compact('otherServices'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_name' => 'required|string|max:255',
            'service_price' => 'required|numeric',
            'service_time' => 'required|numeric',
        ]);

        $otherService = new OtherService();
        $otherService->service_name = $validated['service_name'];
        $otherService->service_price = $validated['service_price'];
        $otherService->service_time = $validated['service_time'];
        $otherService->save();

        session()->flash('success', 'บันทึกสำเร็จ');
        return redirect()->back();
    }

    public function editotherservice($service_id)
{
    $service = OtherService::find($service_id); 

    return view('edit_otherservice', compact('service'));
}
   
    public function saveeditotherservice(Request $request, $service_id)
{
    $service = OtherService::find($service_id);
    $service->service_name = $request->service_name;
    $service->service_price = $request->service_price;
    $service->service_time = $request->service_time;
    $service->save();

    session()->flash('success', 'แก้ไขบริการเสริมสำเร็จ');
    return redirect()->back();
}

public function deletotherservice($service_id)
    {
        $service = OtherService::find($service_id);
        $service ->delete();

        session()->flash('success', 'ลบสำเร็จ');
        return redirect()->back();

    }
   

    
}
