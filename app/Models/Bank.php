<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Bank extends Model
{
    use HasFactory, Uuids;
    protected $table = 'banks';
    protected $fillable = ['bank_name', 'bank_code'];
}
