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
        'saldo',
        'verified_ktp'
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function InvestorInvestment()
    {
        return $this->hasMany(InvestorInvestment::class);
    }

    public function Investment()
    {
        return $this->belongsToMany(Investment::class, 'investor_investments', 'investor_id', 'investment_id');
    }

    // public function getInvestorInvestmentsAttribute()
    // {
    //     return $this->investorInvestments()->get();
    // }

    // public function getInvestmentsAttribute()
    // {
    //     return $this->investments()->get();
    // }

    
}
