<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpeningHour extends Model
{
    use HasFactory;
    
    protected $fillable = ['day', 'opening_time', 'closing_time', 'is_open'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
