<?php

namespace App\Models;

use App\Models\ReferenceableModel;

class AircraftType extends ReferenceableModel {
    protected $table = 'aircraft_types';
    public static $path = 'aircraft-type';

    protected $fillable = [
        'name',
        'code',
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function aircrafts() {
        return $this->hasMany('App\Models\Aircraft', 'type');
    }

    public function airoutes() {
        return $this->belongsToMany('App\Models\AirRoute', 'air_routes_types', 'aircraft_type', 'air_route');
    }
    public function getAirRoutes() {
        $airRoutes = $this->airoutes;

        $result = [];
        foreach ($airRoutes as $airRoute)
            array_push($result, [
                'id' => $airRoute->id
            ]);

        return $result;
    }
}