<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aircraft extends Model {
    protected $table = 'aircraft_types';

    protected $fillable = [
        'type',
        'seats',
        'max_speed',
        'wingspan',
        'radius',
        'engine_type'
    ];

    public function type() {
        return $this->belongsTo('App\AircraftType', 'type');
    }
}