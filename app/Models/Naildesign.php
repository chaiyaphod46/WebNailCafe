<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Like;
use App\Models\Timereservs;
use App\Models\Promotion;

class Naildesign extends Model
{
    protected $table = 'naildesigns';
    protected $primaryKey = 'nail_design_id';

    use HasFactory;

    public function likes()
    {
        return $this->hasMany(Like::class, 'nail_design_id');
    }

    public function timereservs()
    {
        return $this->hasMany(Timereservs::class, 'nail');
    }

    public function promotions()
{
    return $this->belongsToMany(Promotion::class, 'promotion_design_type', 'design_type', 'promotion_id');
}

public function detailPromotions()
{
    return $this->hasMany(DetailPromotion::class);
}



}
