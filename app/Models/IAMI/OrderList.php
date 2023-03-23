<?php

namespace App\Models\IAMI;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderList extends Model
{
    use HasFactory;
    
    protected $table = 'iami_order_lists';
    protected $fillable = [
        'part_number',
        'part_name',
        'order_qty',
        'total_kanban',
        'kanban_qty',
        'lp',
    ];

    /**
     * Get the order that owns the OrderList
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Get all of the labels for the OrderList
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function labels(): HasMany
    {
        return $this->hasMany(Label::class, 'order_list_id');
    }
}
