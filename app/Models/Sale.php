<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $primaryKey = 'sale_id';

    protected $fillable = [
        'product_id',
        'customer_id',
        'quantity',
        'unit_price',
        'total_amount',
        'discount',
        'sale_date',
        'cashier_id',
    ];

    protected function casts(): array
    {
        return [
            'sale_date' => 'date',
            'unit_price' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'discount' => 'decimal:2',
        ];
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class, 'sale_id', 'sale_id');
    }
}
