<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserv extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'reservs_date',
        'reservs_time',
        'price',
        'statusdetail',
        'nail',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
