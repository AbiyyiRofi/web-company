<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\LogsActivity;

class News extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'news';

    protected $fillable = ['user_id', 'title', 'slug', 'cover_image', 'content', 'published_at'];

    protected $casts = ['published_at' => 'datetime'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(NewsImage::class)->orderBy('sort_order');
    }
}
