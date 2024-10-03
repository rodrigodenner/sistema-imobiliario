<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'type', 'address', 'bedrooms', 'neighborhood', 'city', 'state', 'usable_area', 'total_area', 'message', 'no_read'];

}
