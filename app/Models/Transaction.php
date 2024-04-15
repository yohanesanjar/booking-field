<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable =
    [
        'id',
        'booking_id',
        'user_id',
        'payment_method_dp',
        'account_name_dp',
        'payment_proof_dp',
        'down_payment',
        'payment_method_remaining',
        'account_name_remaining',
        'payment_proof_remaining',
        'remaining_payment',
    ];

    protected $casts = [
        'booking_id' => 'string'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function paymentMethodDP()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_dp');
    }
    public function paymentMethodRemaining()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_remaining');
    }
}
