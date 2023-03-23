<?php

namespace App\Models\IAMI;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'iami_orders';
    protected $guarded = [];
    protected $fillable = [
        'number',
        'order_number',
        'purchase_order_number',
        'order_date',
        'order_time',
        'delivery_cycle',
        'created_by',
    ];

    /**
     * Get all of the orderLists for the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderLists(): HasMany
    {
        return $this->hasMany(OrderList::class, 'order_id');
    }
    
    /**
     * Get all of the labels for the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function labels(): HasMany
    {
        return $this->hasMany(Label::class, 'order_id');
    }
}
