<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupScheduleDevice extends Model
{
    use HasFactory;


    protected $table = 'group_schedule_devices';
    protected $primaryKey = 'group_schedule_device_id';

    protected $fillable = [ 'group_schedule_id',
        'device_id'
    ];

    public function device(){
        return $this->hasOne(Device::class, 'device_id', 'device_id');
    }

}
