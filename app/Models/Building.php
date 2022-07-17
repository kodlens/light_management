<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;

    protected $table = 'buildings';
    protected $primaryKey = 'building_id';

    protected $fillable = ['building_name'];

    public function devices(){
        return $this->hasMany(Room::class, 'building_id', 'building_id')
            ->leftJoin('floors', 'floors.floor_id', 'rooms.floor_id')
            ->leftJoin('devices', 'rooms.room_id', 'devices.room_id')
            ->leftJoin('device_accesses', 'devices.device_id', 'device_accesses.device_id');
    }


}
