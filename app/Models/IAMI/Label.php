<?php

namespace App\Models\IAMI;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    use HasFactory;

    protected $table = 'iami_labels';
    protected $fillable = [
        'kanban_number',
        'msi_label_number',
        'kanban_scan_at',
        'kanban_scan_by',
        'msi_label_scan_at',
        'msi_label_scan_by',
        'data',
        'serie_number',
    ];

    /**
     * Get the order that owns the Label
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Get the orderlist that owns the Label
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function orderlist(): BelongsTo
    {
        return $this->belongsTo(OrderList::class, 'order_list_id');
    }
}
