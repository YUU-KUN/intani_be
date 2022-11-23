<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class UserBank extends Model
{
    use HasFactory, Uuids;
    protected $table = 'user_banks';
    protected $fillable = ['user_id', 'bank_id', 'account_name', 'account_number'];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    public function getUserAttribute()
    {
        return $this->User()->get();
    }
}
