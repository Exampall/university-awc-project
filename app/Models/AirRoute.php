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
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function departFrom() {
        return $this->belongsTo('App\Models\Airport', 'airport_departure');
    }

    public function arriveTo() {
        return $this->belongsTo('App\Models\Airport', 'airport_arrival');
    }

    public function aircraftTypes() {
        return $this->belongsToMany('App\Models\AircraftType', 'air_routes_types', 'air_route', 'aircraft_type');
    }

    public function slot() {
        return $this->hasMany('App\Models\AirRouteSlot', 'air_route');
    }
}

class AirRouteSlot extends Model {
    protected $table = 'air_routes_slot';

    protected $fillable = [
        'air_route',
        'day',
        'schedule'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function partOf() {
        return $this->belongsTo('App\Models\AirRoute', 'air_route');
    }

    public function reservedBy() {
        return $this->belongsToMany('App\Models\Airline', 'airline_reservations', 'slot', 'airline');
    }
}
