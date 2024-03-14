<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldSchedule extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function bookingDetails()
    {
        return $this->hasMany(BookingDetail::class);
    }

    public function scheduleAvailabilities()
    {
        return $this->hasMany(ScheduleAvailability::class);
    }
}
