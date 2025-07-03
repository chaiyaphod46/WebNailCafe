<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionDesignType extends Model
{
    use HasFactory;

    protected $table = 'promotion_design_type';

    protected $fillable = [
        'promotion_id',
        'design_type'
    ];

    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'promotion_id', 'promotion_id');
    }
}
