<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageHeader extends Model
{
    protected $fillable = ['key', 'header_image', 'header_caption'];

    public static function get(string $key): self
    {
        return static::firstOrCreate(['key' => $key]);
    }
}
