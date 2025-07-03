<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{

    protected $table = 'likes';

    protected $primaryKey = 'likes_id';

    protected $fillable = ['id', 'nail_design_id'];

    public function user() {
        return $this->belongsTo(User::class, 'id');
    }

    public function nailDesign() {
        return $this->belongsTo(Naildesign::class, 'nail_design_id');
    }


}
