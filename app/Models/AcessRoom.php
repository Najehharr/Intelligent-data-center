<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcessRoom extends Model
{
    use HasFactory;
    protected $table = 'acessroom';

    public $timestamps = false;

    protected $fillable = ['Numcart', 'date', 'access', 'traite'];
}
