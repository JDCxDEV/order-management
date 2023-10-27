<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Order;

class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @Fillables
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'address',
        'created_by',
    ];


    /**
     * @Renders
     */
    public function name() 
    {
        return "{$this->firstname} {$this->lastname}";
    }

    /**
     * @Relationships
     */

    public function orders() 
    {
        return $this->hasMany(Order::class)->withTrashed();
    }
    
}
