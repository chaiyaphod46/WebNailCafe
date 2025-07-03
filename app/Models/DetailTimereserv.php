<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTimereserv extends Model
{
    use HasFactory;

    protected $table = 'detail_timereservs';

    protected $fillable = [
        'C_id',
        'reservs_id',
        'nail',
        'additional_services'
    ];

    // สร้างความสัมพันธ์กับตารางต่างๆ
    public function user()
    {
        return $this->belongsTo(User::class, 'C_id');
    }

    public function timereserv()
    {
        return $this->belongsTo(Timereservs::class, 'reservs_id');
    }

    public function nailDesign()
    {
        return $this->belongsTo(Naildesign::class, 'nail', 'nail_design_id');
    }

    public function additionalServices()
    {
        return $this->belongsTo(OtherService::class, 'additional_services', 'service_id'); 
    }
}
