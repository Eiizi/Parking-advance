<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class ParkingTicket extends Model
{
    //mongodb
    protected $connection = 'mongodb';
    protected $collection = 'parking_tickets';
    
    //auth
    protected $guarded = [];
}