<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'service_type',
        'sender_msisdn_id',
        'transaction_amount',
        'commission_paid',
        'transfert_datetime',
        'sender_user_type',
        'rewarded'
    ];

    protected $casts = [
        'transfert_datetime' => 'datetime',
        'rewarded' => 'boolean'
    ];

    public function sender() {
        return $this->belongsTo(Client::class, 'sender_msisdn_id');
    }
}
