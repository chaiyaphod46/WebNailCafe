<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount', 'reservs_id', 'payment_date', 'session_id', 'status', 'order_id'
    ];
    
    public function timereserv()
{
    return $this->belongsTo(Timereservs::class, 'reservs_id');
}
}
