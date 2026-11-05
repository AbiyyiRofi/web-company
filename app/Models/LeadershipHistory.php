<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadershipHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'period',
        'position',
        'photo',
        'sort_order',
        'duration',
    ];
}
