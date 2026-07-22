<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KarirPoster extends Model
{
    use SoftDeletes;

    protected $fillable = ['image', 'start_date', 'end_date'];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // Dipakai di halaman PUBLIK: hanya poster yang jadwalnya berlaku HARI INI
    public function scopeActive($query)
    {
        $today = now()->toDateString();
        return $query
            ->where(fn ($q) => $q->whereNull('start_date')->orWhere('start_date', '<=', $today))
            ->where(fn ($q) => $q->whereNull('end_date')->orWhere('end_date', '>=', $today));
    }

    public function getStatusAttribute(): string
    {
        if ($this->trashed()) return 'Dihapus';
        $today = now()->toDateString();
        if ($this->start_date && $this->start_date->toDateString() > $today) return 'Terjadwal';
        if ($this->end_date && $this->end_date->toDateString() < $today) return 'Kadaluarsa';
        return 'Aktif';
    }
}