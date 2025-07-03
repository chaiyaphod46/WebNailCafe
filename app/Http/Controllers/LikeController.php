<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use App\Models\Naildesign;



class LikeController extends Controller
{
    public function toggleLike(Request $request) {
        $userId = Auth::id();
        $nailDesignId = $request->nail_design_id;

        $existingLike = Like::where('id', $userId)->where('nail_design_id', $nailDesignId)->first();

        if ($existingLike) {
            //  unlike
            $existingLike->delete();
            return response()->json(['success' => true, 'liked' => false]);
        } else {
            //  like
            Like::create([
                'id' => $userId,
                'nail_design_id' => $nailDesignId
            ]);
            return response()->json(['success' => true, 'liked' => true]);
        }

    }

    public function getLikedDesigns() {
        $userLikes = Like::where('id', Auth::id())->pluck('nail_design_id')->toArray();
        return response()->json(['likedDesigns' => $userLikes]);
    }
}
