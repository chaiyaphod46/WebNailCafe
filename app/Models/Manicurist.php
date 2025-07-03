<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manicurist extends Model
{
    protected $table = 'manicurists';
    protected $primaryKey = 'manicurist_id';
    use HasFactory;
}
