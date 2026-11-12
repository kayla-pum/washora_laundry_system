<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'servies';

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'unit',
        'estimated_hours',
        'service_type',
        'status',
        'is_featured',
        'featured_order',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'estimated_hours' => 'integer',
            'is_featured' => 'boolean',
            'featured_order' => 'integer',
        ];
    }

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'category_id');
    }

    public function packageItems()
    {
        return $this->hasMany(PackageItem::class, 'service_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'service_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('status', 'active')
            ->where('is_featured', true)
            ->orderBy('featured_order', 'asc')
            ->orderBy('id', 'asc');
    }

    public function getOrderTypeAttribute(): string
    {
        return $this->unit === 'kg' ? 'kiloan' : 'satuan';
    }

    public function getOrderTypeLabelAttribute(): string
    {
        return $this->unit === 'kg' ? 'Kiloan' : 'Satuan';
    }

    public function getUnitLabelAttribute(): string
    {
        return match ($this->unit) {
            'kg' => 'Kg (Kilogram)',
            'pcs' => 'Pcs (Satuan Buah)',
            'pair' => 'Pasang',
            default => strtoupper($this->unit),
        };
    }
}
