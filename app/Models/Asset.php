<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Asset extends Model 
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'code_asset',
        'serial_number',
        'spesifikasi',
        'condition_status',
        'qty',
        'pengguna',
        'location',
        'tanggal_beli',
        'harga_beli',
        'image',
        'description',
    ];

    protected $casts = [
        'tanggal_beli' => 'date',
        'harga_beli'   => 'decimal:0',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function handovers(): HasMany
    {
        return $this->hasMany(AssetHandover::class);
    }

    public function maintenances(): HasMany
    {
        return $this->hasMany(Maintenance::class);
    }

}