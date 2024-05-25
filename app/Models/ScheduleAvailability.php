<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleAvailability extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = [
        'booking_id' => 'string'
    ];

    public function fieldData()
    {
        return $this->belongsTo(FieldData::class, 'field_data_id');
    }

    public function fieldSchedule()
    {
        return $this->belongsTo(FieldSchedule::class, 'field_schedule_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
}
