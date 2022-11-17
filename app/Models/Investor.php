<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Investor extends Model
{
    use HasFactory, Uuids;
    protected $table = 'investors';
    protected $fillable = [
        'user_id', 
        'name', 
        'phone', 
        'nik', 
        'address',
        'verified_ktp'
    ];
}
