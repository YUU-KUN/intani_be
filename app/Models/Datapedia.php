<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Datapedia extends Model
{
    use HasFactory, Uuids;
    protected $table = 'datapedias';
    protected $fillable = ['title', 'image', 'content'];
}
