<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function bookingDetails()
    {
        return $this->hasMany(BookingDetail::class);
    }

    public function fieldData()
    {
        return $this->belongsTo(FieldData::class, 'field_data_id');
    }
}