<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name',
        'user_email',
        'action',
        'module',
        'description',
        'ip_address',
        'user_agent',
        'properties',
    ];

    protected $casts = [
        'properties' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Helper to record an activity log entry
     */
    public static function record(string $action, string $module, string $description, ?array $properties = null, ?User $user = null): self
    {
        $currentUser = $user ?? auth()->user();

        return self::create([
            'user_id'     => $currentUser?->id,
            'user_name'   => $currentUser?->name ?? 'System/Guest',
            'user_email'  => $currentUser?->email,
            'action'      => strtolower($action),
            'module'      => $module,
            'description' => $description,
            'ip_address'  => request()->ip(),
            'user_agent'  => request()->userAgent(),
            'properties'  => $properties,
        ]);
    }
}
