<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\ClosedDate;
use App\Models\Timereservs;


class OpeningHourController extends Controller
{

public function showOpeningHours()
{
    $closedDates = ClosedDate::pluck('closed_date')->toArray();
    $bookedEvents = Timereservs::select('reservs_start as start', 'reservs_end as end')->get();
    return view('opening_hours', compact('closedDates', 'bookedEvents'));
}

public function saveClosedDate(Request $request)
{
    $request->validate([
        'closed_date' => 'required|date',
    ]);

    ClosedDate::create([
        'closed_date' => $request->closed_date,
    ]);

    return response()->json(['success' => true]);
}

public function getClosedDates()
    {
        $closedDates = ClosedDate::pluck('closed_date')->toArray();
        return response()->json(['closedDates' => $closedDates]);
    }


public function deleteClosedDate(Request $request)
{
    $request->validate([
        'closed_date' => 'required|date',
    ]);

    ClosedDate::where('closed_date', $request->closed_date)->delete();

    return response()->json(['success' => true]);
}


    
}
