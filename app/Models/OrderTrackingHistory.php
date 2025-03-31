<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTrackingHistory extends Model
{
    use HasFactory;

    protected $table = 'order_tracking_history';

    protected $fillable = [
        'carrier_id',
        'status',
        'description',
        'location',
        'type',
        'created_at',
        'email_sent_at',
    ];

    /**
     * Relacionamento com a transportadora.
     */
    public function carrier()
    {
        return $this->belongsTo(Carrier::class);
    }
}
