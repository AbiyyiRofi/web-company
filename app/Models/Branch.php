<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'address', 'phone', 'whatsapp',
        'latitude', 'longitude', 'operational_hours', 'is_head_office',
    ];

    protected $casts = [
        'is_head_office' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    // nomor buat tombol "Chat Sekarang" -> wa.me, dibersihin dari karakter non-digit
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
