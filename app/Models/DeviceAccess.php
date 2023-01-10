<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceAccess extends Model
{
    use HasFactory;


    protected $table = 'device_accesses';
    protected $primaryKey = 'device_access_id';

    protected $fillable = ['device_id', 'group_role_id'];



    public function device(){
        return $this->belongsTo(Device::class, 'device_id', 'device_id')
            ->leftJoin('rooms', 'rooms.room_id', 'devices.room_id')
            ->leftJoin('buildings', 'rooms.building_id', 'buildings.building_id')
            ->leftJoin('floors', 'rooms.floor_id', 'floors.floor_id');
    }

    public function group_role(){
        return $this->belongsTo(GroupRole::class, 'group_role_id', 'group_role_id');
    }

}
