<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timereservs;
use App\Models\ClosedDate;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class ShowTimeavailableController extends Controller
{
    
    private function getBookedEvents()
    {
        return Timereservs::select('reservs_start as start', 'reservs_end as end')->get();
    }

    private function getClosedDates()
    {
        return ClosedDate::pluck('closed_date')->toArray();
    }

    public function index()
    {
        $user = Auth::user();
        $bookedEvents = $this->getBookedEvents();
        $closedDates = $this->getClosedDates();

        return view('showtimeavailable', compact('bookedEvents', 'closedDates','user'));
    }
    
}
