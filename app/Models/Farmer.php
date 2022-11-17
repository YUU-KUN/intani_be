<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Farmer extends Model
{
    use HasFactory, Uuids;
    protected $table = 'farmers';
    protected $fillable = [
        'user_id', 
        'farm_group_id',
        'name',
        'phone',
        'nik', 
        'address',
        'verified_ktp',
    ];
}
