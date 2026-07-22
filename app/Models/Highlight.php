<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Highlight extends Model
{
    protected $fillable = ['value', 'label', 'sort_order'];

    public static function ordered()
    {
        return static::orderBy('sort_order')->get();
    }
}
