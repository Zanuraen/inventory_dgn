<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetHandover extends Model
{
    protected $fillable = [
        'asset_id',
        'user_id',
        'tujuan_penggunaan',
        'tanggal_pinjam',
        'tanggal_kembalian',
        'notes',
        'file_path',
    ];

    protected $casts = [
        'tanggal_pinjam'    => 'date',
        'tanggal_kembalian' => 'date',
    ];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}