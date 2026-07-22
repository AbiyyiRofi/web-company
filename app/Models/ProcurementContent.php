<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcurementContent extends Model
{
    protected $fillable = ['header_image', 'header_caption'];

    public static function singleton(): self
    {
        return static::firstOrCreate(['id' => 1]);
    }
}
