<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Timereservs extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'reservs_id'; 
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'reservs_id',
        'id',
        'reservs_start',
        'reservs_end', 
        'statusdetail'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function detailTimereservs()
    {
        return $this->hasMany(DetailTimereserv::class, 'reservs_id', 'reservs_id');
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'promotion_id');
    }
    public function payments()
{
    return $this->hasOne(Payment::class, 'reservs_id');
}
   
}
