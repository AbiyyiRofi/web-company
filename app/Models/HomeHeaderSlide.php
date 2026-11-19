<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class HomeHeaderSlide extends Model
{
    use LogsActivity;

    protected $fillable = [
        'title',
        'media_type',
        'file_path',
        'youtube_url',
        'youtube_id',
        'duration_seconds',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($q)
    {
        return $q->where('is_active', true)->orderBy('sort_order');
    }

    /**
     * Ekstrak YouTube Video ID dari berbagai format link/URL
     */
    public static function extractYoutubeId(?string $url): ?string
    {
        if (!$url) {
            return null;
        }
        $url = trim($url);

        // Jika user langsung memasukkan 11 karakter video ID
        if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $url)) {
            return $url;
        }

        // Format umum: watch?v=, youtu.be/, embed/, shorts/
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?|shorts)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $url, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * Embed URL untuk iframe header background dengan autoplay & loop
     */
    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        if (!$this->youtube_id) {
            return null;
        }
        // autoplay=1, mute=1 (wajib browser agar autoplay jalan), loop=1&playlist={id}, controls=0, enablejsapi=1
        return "https://www.youtube-nocookie.com/embed/{$this->youtube_id}?autoplay=1&mute=1&loop=1&playlist={$this->youtube_id}&controls=0&showinfo=0&rel=0&enablejsapi=1&playsinline=1&modestbranding=1&iv_load_policy=3";
    }

    /**
     * Thumbnail gambar dari YouTube
     */
    public function getYoutubeThumbnailUrlAttribute(): ?string
    {
        if (!$this->youtube_id) {
            return null;
        }
        return "https://img.youtube.com/vi/{$this->youtube_id}/hqdefault.jpg";
    }
}
