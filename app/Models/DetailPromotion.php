<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPromotion extends Model
{
    use HasFactory;

    // กำหนดชื่อของตาราง
    protected $table = 'detail_promotions';

    // กำหนดคอลัมน์ที่อนุญาตให้กรอกข้อมูลได้
    protected $fillable = [
        'promotion_id',
        'nail_design_id',
        'design_type',
    ];

    // ความสัมพันธ์กับ Promotion (One-to-Many)
    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'promotion_id');
    }

    // ความสัมพันธ์กับ NailDesign (One-to-Many)
    public function nailDesign()
    {
        return $this->belongsTo(Naildesign::class, 'nail_design_id');
    }
}
