<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $table = 'packages';

    protected $fillable = [
        'name',
        'description',
        'price',
        'estimated_hours',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'estimated_hours' => 'integer',
        ];
    }

    public function items()
    {
        return $this->hasMany(PackageItem::class, 'package_id');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'package_items', 'package_id', 'service_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'package_id');
    }
}
