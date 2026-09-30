<?php

namespace App\Models;

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
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'estimated_hours' => 'integer',
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
}
