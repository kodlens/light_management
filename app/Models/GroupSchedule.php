<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupSchedule extends Model
{
    use HasFactory;

    protected $table = 'group_schedules';
    protected $primaryKey = 'group_schedule_id';

    protected $fillable = ['schedule_name', 'date_time', 'system_action', 'action_type',
        'schedule_on', 'schedule_off', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'
    ];

    public function group_schedule_devices(){
        return $this->hasMany(GroupScheduleDevice::class, 'group_schedule_id', 'group_schedule_id')
            ->with('device');
    }




}
