<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'user_id', 'title', 'type', 'category', 'description',
        'file_path', 'file_type', 'download_count',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeDokumenPublik($q)
    {
        return $q->where('type', 'dokumen_publik');
    }

    public function scopeCompanyProfile($q)
    {
        return $q->where('type', 'company_profile');
    }
}
