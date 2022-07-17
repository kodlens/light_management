<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmitService extends Model
{
    use HasFactory;


    protected $table = 'admit_services';
    protected $primaryKey = 'admit_service_id';

    protected $fillable = ['admit_id', 'service_id', 'tooth_id'];


    public function service_inventories(){
        // return $this->hasManyThrough(
        //     Deployment::class,
        //     Environment::class,
        //     'project_id', // Foreign key on the environments table...
        //     'environment_id', // Foreign key on the deployments table...
        //     'id', // Local key on the projects table...
        //     'id' // Local key on the environments table...
        // );
        return $this->hasMany(ServiceInventory::class, 'admit_service_id', 'admit_service_id')
            ->join('items', 'service_inventories.item_id', 'items.item_id');
        //return $this->relation()->with(ServiceInventory::class, 'admit_service_id', 'admit_service_id');
    }

    public function services(){
        return $this->hasOne(Service::class, 'service_id', 'service_id');
    }

    public function teeth(){
        return $this->hasOne(Teeth::class, 'tooth_id', 'tooth_id');
    }

    public function admit(){
        return $this->belongsTo(Admit::class, 'admit_id', 'admit_id');
    }








}
