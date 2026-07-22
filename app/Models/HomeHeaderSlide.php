<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeHeaderSlide extends Model
{
    protected $fillable = ['title', 'media_type', 'file_path', 'duration_seconds', 'sort_order', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function scopeActive($q)
    {
        return $q->where('is_active', true)->orderBy('sort_order');
    }
}
