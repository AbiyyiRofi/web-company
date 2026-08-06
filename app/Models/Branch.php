<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'type', 'address', 'phone', 'whatsapp',
        'latitude', 'longitude', 'operational_hours', 'is_head_office',
        'kapasitas_terpasang_text', 'kapasitas_produksi', 'idle_capacity',
    ];

    protected $casts = [
        'is_head_office' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function scopeCabang($query)
    {
        return $query->where('type', 'cabang');
    }

    public function scopeIpa($query)
    {
        return $query->where('type', 'ipa');
    }

    public function getWhatsappLinkAttribute(): ?string
    {
        $number = $this->whatsapp ?: $this->phone;
        if (!$number) return null;

        $digits = preg_replace('/\D/', '', $number);
        if (str_starts_with($digits, '0')) {
            $digits = '62' . substr($digits, 1);
        }
        return "https://wa.me/{$digits}";
    }
}