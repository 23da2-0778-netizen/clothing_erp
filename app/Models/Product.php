<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_name',
        'category',
        'price',
        'quantity',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'quantity' => 'integer',
        ];
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'product_id', 'product_id');
    }

    public function isLowStock(int $threshold = 5): bool
    {
        return $this->quantity <= $threshold;
    }
}
