<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaduanOnlineContent extends Model
{
    protected $fillable = ['header_image', 'header_caption', 'poster_image'];

    public static function singleton(): self
    {
        return static::firstOrCreate(['id' => 1]);
    }
}
