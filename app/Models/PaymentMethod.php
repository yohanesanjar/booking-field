<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public $timestamps = false;

    public function transactionDps()
    {
        return $this->hasMany(Transaction::class, 'payment_method_dp');
    }
    public function transactionsRemainings()
    {
        return $this->hasMany(Transaction::class, 'payment_method_remaining');
    }
}
