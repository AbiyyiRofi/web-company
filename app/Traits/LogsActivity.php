<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait LogsActivity
{
    public static function bootLogsActivity(): void
    {
        static::created(function ($model) {
            $model->logActivity('create', 'Membuat ' . $model->getModelLogLabel() . ' baru: "' . $model->getModelLogTitle() . '"');
        });

        static::updated(function ($model) {
            $changes = $model->getChanges();
            // Ignore updated_at column changes if it's the only changed column
            unset($changes['updated_at']);
            if (empty($changes)) {
                return;
            }

            $model->logActivity('update', 'Memperbarui ' . $model->getModelLogLabel() . ': "' . $model->getModelLogTitle() . '"', [
                'changes' => $changes,
            ]);
        });

        static::deleted(function ($model) {
            $model->logActivity('delete', 'Menghapus ' . $model->getModelLogLabel() . ': "' . $model->getModelLogTitle() . '"');
        });
    }

    protected function logActivity(string $action, string $description, ?array $properties = null): void
    {
        if (auth()->check()) {
            ActivityLog::record($action, $this->getModelLogModule(), $description, $properties);
        }
    }

    protected function getModelLogModule(): string
    {
        return class_basename($this);
    }

    protected function getModelLogLabel(): string
    {
        $className = class_basename($this);
        $labels = [
            'News'              => 'berita',
            'Announcement'      => 'pengumuman',
            'Gallery'           => 'galeri',
            'GalleryPhoto'      => 'foto galeri',
            'Document'          => 'dokumen/publikasi',
            'Procurement'       => 'pengadaan',
            'Branch'            => 'data cabang/IPA',
            'KarirPoster'       => 'poster karir',
            'Director'          => 'jajaran direksi',
            'HistoryItem'       => 'sejarah',
            'LeadershipHistory' => 'sejarah kepemimpinan',
            'HomeHeaderSlide'   => 'poster header',
            'Highlight'         => 'highlight beranda',
            'SiteSetting'       => 'pengaturan logo/situs',
            'User'              => 'pengguna admin',
        ];

        return $labels[$className] ?? strtolower($className);
    }

    protected function getModelLogTitle(): string
    {
        return $this->title ?? $this->name ?? $this->heading ?? $this->name_of_director ?? ('#' . $this->id);
    }
}
