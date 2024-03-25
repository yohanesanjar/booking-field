<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public $timestamps = false;

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
