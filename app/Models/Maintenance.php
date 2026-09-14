<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'maintenance_date',
        'description',
        'jenis_pemeliharaan',
        'jatuh_tempo',
        'cost',
        'vendor',
        'kontak_vendor',
        'status',
        'priority',
        'recurrence',
        'next_maintenance_id',
    ];

    protected $casts = [
        'maintenance_date' => 'date',
        'jatuh_tempo' => 'date',
    ];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(MaintenanceDocument::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(MaintenancePhoto::class);
    }

    // method status otomatis
    protected function status(): Attribute
    {
        return Attribute::make(
            get: function (string $value) {
                if ($value === 'selesai') {
                    return 'selesai';
                }

                return $this->jatuh_tempo->isPast() ? 'terlambat' : 'terjadwal';
            },
        );
    }

    public function nextMaintenance(): BelongsTo
    {
        return $this->belongsTo(Maintenance::class, 'next_maintenance_id');
    }
}