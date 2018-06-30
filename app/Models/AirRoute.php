<?php

namespace App\Models;

use App\Models\ReferenceableModel;

class AirRoute extends ReferenceableModel {
    protected $table = 'air_routes';
    public static $path = 'air-route';

    protected $fillable = [
        'type',
        'airport_departure',
        'airport_arrival',
        'max_slot_reservations',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
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

    public function toArray() {
        $aircraftTypeUrls = [];
        foreach ($this->aircraftTypes as $aircraftType) {
            $aircraftTypeUrls[] = AircraftType::toUrl($aircraftType->id);
        }

        $slotUrls = [];
        foreach ($this->slot as $slot) {
            $slotUrls[] = AirRouteSlot::toUrl($slot->id);
        }

        return [
            'id' => $this->id,
            'type' => $this->type,
            'airportDeparture' => Airport::toUrl($this->departFrom->id),
            'airportArrival' => Airport::toUrl($this->arriveTo->id),
            'maxSlotReservations' => $this->max_slot_reservations,
            'aircraftTypes' => $aircraftTypeUrls,
            'slot' => $slotUrls,
        ];
    }
}