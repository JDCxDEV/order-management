<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\Product;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * @Fillables
     */

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity'
    ];

    /**
     * @Relationships
     */

    public function order() 
    {
        return $this->belongsTo(Order::class);
    }

    public function product() {
        return $this->belongsTo(Product::class)->withTrashed();
    }
}
