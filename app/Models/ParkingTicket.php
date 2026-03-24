<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class ParkingTicket extends Model
{
    //mongodb
    protected $connection = 'mongodb';
    protected $collection = 'parking_tickets';

    protected $casts = [
    'entry_time' => 'datetime',
    'exit_time' => 'datetime',
];
    
    //auth
    protected $guarded = [];
}