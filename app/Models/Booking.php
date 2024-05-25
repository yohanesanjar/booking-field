<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['field_data_id', 'customer_name', 'is_member', 'discount', 'total_subtotal', 'down_payment', 'booking_status'];

    public function bookingDetails()
    {
        return $this->hasMany(BookingDetail::class);
    }

    public function fieldData()
    {
        return $this->belongsTo(FieldData::class, 'field_data_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'booking_id');
    }

    public function scheduleAvailabilities()
    {
        return $this->hasMany(ScheduleAvailability::class, 'booking_id');
    }
}
