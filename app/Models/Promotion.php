<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;
    protected $primaryKey = 'promotion_id';

    protected $fillable = [
        'promotion_name',
        'promotion_code',
        'discount_type',
        'discount_value',
        'status',
        'start_time',
        'end_time',

    ];

    public function detailPromotions()
{
    return $this->hasMany(DetailPromotion::class, 'promotion_id');
}
public function naildesigns()
{
    return $this->belongsToMany(Naildesign::class, 'promotion_naildesign', 'promotion_id', 'nail_design_id');
}
}
