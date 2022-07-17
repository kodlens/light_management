<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthDeclaration extends Model
{
    use HasFactory;

    protected $table = 'health_declarations';
    protected $primaryKey = 'health_declaration_id';


    protected $fillable = ['hquestion_id', 'question', 'ans'];



}
