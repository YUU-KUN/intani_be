<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use App\Models\Investment;
use App\Models\User;
use App\Models\farmGroup;

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
        'rating',
        'saldo',
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function FarmGroup()
    {
        return $this->belongsTo(FarmGroup::class, 'farm_group_id');
    }

    public function Investment()
    {
        return $this->hasMany(Investment::class);
    }
}
