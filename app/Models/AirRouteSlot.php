<?php

namespace App\Models;

use App\Models\ReferenceableModel;

class AirRouteSlot extends ReferenceableModel {
    protected $table = 'air_routes_slot';
    public static $path = 'air-route-slot';

    protected $fillable = [
        'air_route',
        'day',
        'schedule',
        'max_reservations'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function partOf() {
        return $this->belongsTo('App\Models\AirRoute', 'air_route');
    }

    public function reservedBy() {
        return $this->belongsToMany('App\Models\Airline', 'airline_reservations', 'slot', 'airline');
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'air_route' => AirRoute::toUrl($this->air_route),
            'day' => $this->day,
            'schedule' => $this->schedule,
            'max_reservations' => $this->max_reservations,
        ];
    }
}
