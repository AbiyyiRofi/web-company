<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    protected $fillable = ['photo', 'name', 'position', 'description', 'type', 'sort_order'];

    public function scopeDireksi($q)
    {
        return $q->where('type', 'direksi');
    }

    public function scopePemilikModal($q)
    {
        return $q->where('type', 'pemilik_modal');
    }
}
