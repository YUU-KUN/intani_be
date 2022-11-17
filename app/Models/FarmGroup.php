<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class FarmGroup extends Model
{
    use HasFactory, Uuids;
    protected $table = 'farm_groups';
    protected $fillable = ['name', 'photo'];
}
