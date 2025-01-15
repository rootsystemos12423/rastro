<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrier extends Model
{
    use HasFactory;

    protected $table = 'carriers';

    protected $fillable = [
        'name',
        'tracking_code',
        'taxacao',
        'taxacao_payment_link',
    ];

    /**
     * Relacionamento com o histórico de rastreamento dos pedidos.
     */
    public function trackingHistories()
    {
        return $this->hasMany(OrderTrackingHistory::class);
    }
}
