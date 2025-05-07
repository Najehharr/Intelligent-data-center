<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $table = 'status'; // link to your actual table

    protected $fillable = ['temperature', 'humidete', 'niveauco2', 'datetimes'];

    public $timestamps = false; 
}

