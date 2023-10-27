<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\OrderItem;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @Fillables
     */

    protected $fillable = [
        'customer_id',
        'created_by'
    ];

    /**
     * @Renders
     */

    public function readable_created_at()
    {
        return $this->created_at->format('j M Y, g:i A');        
    }

    public function totalItems() 
    {
        $total = 0;
        foreach($this->order_items as $item) {
            $total += $item->quantity;
        }
        return $total;
    }

    /**
     * @Relationships
     */
    
    public function customer() 
    {
        return $this->belongsTo(Customer::class)->withTrashed();
    }
    
    public function transacted_by() 
    {
        return $this->belongsTo(User::class, 'created_by')->withTrashed();
    }

    public function order_items() 
    {
        return $this->hasMany(OrderItem::class);
    }
}
