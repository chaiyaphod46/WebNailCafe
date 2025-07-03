<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
// use App\Models\NailDesign;
use App\Models\Naildesign;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ShowLikeController extends Controller
{
    public function viewshowlike(){
        $user = Auth::user();

        $userId = auth()->id();

        $likedDesigns = Like::where('id', $userId)->pluck('nail_design_id')->toArray();
        $nailDesigns = NailDesign::whereIn('nail_design_id', $likedDesigns)->get();

        return view('showlike', compact('nailDesigns','user'));
    }
}
