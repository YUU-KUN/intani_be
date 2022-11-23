<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Investment extends Model
{
    use HasFactory, Uuids;
    protected $table = 'investments';

    protected $fillable = [
        'commodity', 
        'duration',
        'address',
        'status',
        'farmer_id',
        'farm_group_id',
    ];

    public function Farmer()
    {
        return $this->belongsTo(Farmer::class, 'farmer_id');
    }

    public function FarmGroup()
    {
        return $this->belongsTo(FarmGroup::class, 'farm_group_id');
    }

    public function InvestorInvestments()
    {
        return $this->hasMany(InvestorInvestment::class);
    }

    public function Investor()
    {
        return $this->belongsToMany(Investor::class, 'investor_investments', 'investment_id', 'investor_id');
    }

}
