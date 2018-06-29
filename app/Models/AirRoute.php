<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AirRoute extends Model {
    protected $table = 'air_routes';

    protected $fillable = [
        'type',
        'airport_departure',
        'airport_arrival',
        'max_slot_reservations'
    ];

    public function departFrom() {
        return $this->belongsTo('App\Airport', 'airport_departure');
    }

    public function arriveTo() {
        return $this->belongsTo('App\Airport', 'airport_arrival');
    }

    public function aircraftTypes() {
        return $this->belongsToMany('App\AircraftType', 'air_routes_types', 'air_route', 'aircraft_type');
    }

    public function slot() {
        return $this->hasMany('App\AirRouteSlot', 'air_route');
    }
}

class AirRouteSlot extends Model {
    protected $table = 'air_routes_slot';

    protected $fillable = [
        'air_route',
        'day',
        'schedule'
    ];

    public function partOf() {
        return $this->belongsTo('App\AirRoute', 'air_route');
    }

    public function reservedBy() {
        return $this->belongsToMany('App\Airline', 'airline_reservations', 'slot', 'airline');
    }
}
