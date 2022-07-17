<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms';
    protected $primaryKey = 'room_id';

    protected $fillable = ['building_id', 'floor_id', 'room'];

    public function building(){
        return $this->hasOne(Building::class, 'building_id', 'building_id');
    }

    public function floor(){
        return $this->hasOne(Floor::class, 'floor_id', 'floor_id');
    }

    //['building', 'floor']
}
