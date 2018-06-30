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
}