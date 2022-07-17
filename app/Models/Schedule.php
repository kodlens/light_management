<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedules';
    protected $primaryKey = 'schedule_id';

    protected $fillable = ['device_id', 
        'schedule_name', 'date_time', 'system_action', 'action_type',
        'schedule_on', 'schedule_off',
        'mon', 'tue', 'wed', 'thur', 'fri', 'sat', 'sun',
        'ntuser'];


    public function device(){
        return $this->hasOne(Device::class, 'device_id', 'device_id');
    }


}
