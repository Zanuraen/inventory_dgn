<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'maintenance_id',
        'file_path',
        'original_name',
        'file_type',
        'file_size',
    ];

    public function maintenance(): BelongsTo
    {
        return $this->belongsTo(Maintenance::class);
    }
}