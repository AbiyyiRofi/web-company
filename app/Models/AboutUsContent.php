<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUsContent extends Model
{
    protected $fillable = [
        'header_image', 'header_caption', 'sekilas_text',
        'sejarah_text', 'sejarah_bg_image', 'visi_text', 'misi_text',
        'struktur_text', 'struktur_image',
    ];

    public static function singleton(): self
    {
        return static::firstOrCreate(['id' => 1]);
    }
}
