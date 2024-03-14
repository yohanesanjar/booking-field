<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleAvailability extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function fieldData()
    {
        return $this->belongsTo(FieldData::class, 'field_data_id');
    }

    public function fieldSchedule()
    {
        return $this->belongsTo(FieldSchedule::class, 'field_schedule_id');
    }
}
