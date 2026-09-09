<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetHandover extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'asset_id', 'user_id', 'jenis_surat', 'peminjam_nama',
        'tujuan_penggunaan', 'lokasi_penggunaan',
        'tanggal_pinjam', 'tanggal_kembalian', 'status',
        'notes', 'file_path', 'foto_sebelum', 'foto_sesudah', 'persetujuan',
    ];

    protected $casts = [
        'tanggal_pinjam'    => 'date',
        'tanggal_kembalian' => 'date',
        'foto_sebelum'      => 'array',
        'foto_sesudah'      => 'array',
        'persetujuan'       => 'boolean',
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