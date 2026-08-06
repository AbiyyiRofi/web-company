<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'title',
        'content',
        'sort_order',
    ];
}
