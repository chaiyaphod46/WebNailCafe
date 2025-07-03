<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UseCode extends Model
{
    use HasFactory;

    protected $table = 'use_code';

    protected $fillable = [
        'user_id',
        'promotion_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'promotion_id', 'promotion_id');
    }
}
