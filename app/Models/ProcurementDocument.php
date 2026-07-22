<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcurementDocument extends Model
{
    protected $fillable = ['procurement_id', 'title', 'file_path', 'file_type'];

    public function procurement()
    {
        return $this->belongsTo(Procurement::class);
    }
}
