<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class InvestorInvestment extends Model
{
    use HasFactory, Uuids;
    protected $table = 'investor_investments';
    protected $fillable = [
        'investor_id', 
        'investment_id',
        'amount',
    ];

    public function Investor()
    {
        return $this->belongsTo(Investor::class, 'investor_id');
    }

    public function Investment()
    {
        return $this->belongsTo(Investment::class, 'investment_id');
    }
}
