<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $table = 'devices';
    protected $primaryKey = 'device_id';

    protected $fillable = [
        //'building_id', 'floor_id', 
        'room_id',
        'device_name', 
        'device_ip', 
        'device_token_on', 
        'device_token_off', 
        'ntuser'
    ];


    // public function building(){
    //     return $this->hasOne(Building::class, 'building_id', 'building_id');
    // }

    // public function floor(){
    //     return $this->hasOne(Floor::class, 'floor_id', 'floor_id');
    // }


    public function room(){
        return $this->hasOne(Room::class, 'room_id', 'room_id')
            ->leftJoin('buildings', 'rooms.building_id', 'buildings.building_id')
            ->leftJoin('floors', 'rooms.floor_id', 'floors.floor_id');
    }

}
