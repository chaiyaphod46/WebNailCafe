<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherService extends Model
{
    use HasFactory;
    protected $table = 'other_services';
    protected $primaryKey = 'service_id';
    protected $fillable = [
        'service_name',
        'service_time',
        'service_price',
    ];
}
