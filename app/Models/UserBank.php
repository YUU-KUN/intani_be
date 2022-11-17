<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class UserBank extends Model
{
    use HasFactory, Uuids;
    protected $table = 'user_banks';
    protected $fillable = ['user_id', 'bank_id', 'account_name', 'bank_number'];
}
