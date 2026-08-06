<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = ['user_id', 'title', 'category'];

    const CATEGORIES = [
        'direksi' => 'Foto Kegiatan Direksi',
        'cabang_unit' => 'Foto Kegiatan Cabang Unit',
        'ipa' => 'Foto Kegiatan IPA',
        'hari_besar' => 'Foto Kegiatan Hari Besar',
        'pemeliharaan' => 'Foto Kegiatan Pemeliharaan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photos()
    {
        return $this->hasMany(GalleryPhoto::class)->orderBy('sort_order');
    }

    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORIES[$this->category] ?? $this->category;
    }
}