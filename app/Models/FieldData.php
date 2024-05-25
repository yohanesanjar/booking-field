<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldData extends Model
{
    use HasFactory;

    protected $guarded = ['id']; // $guarded

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function scheduleAvailabilities()
    {
        return $this->hasMany(ScheduleAvailability::class);
    }
}
