<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    ];

    protected $casts = [
        'maintenance_date' => 'date',
        'jatuh_tempo'      => 'date',
    ];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }
}