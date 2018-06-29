<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aircraft extends Model {
    protected $table = 'aircraft';

    protected $fillable = [
        'type',
        'seats',
        'max_speed',
        'wingspan',
        'radius',
        'engine_type',
        'airline',
    ];

    public function type() {
        return $this->belongsTo('App\AircraftType', 'type');
    }

    public function partOfAirline() {
        return $this->belongsTo('App\Airline', 'airline');
    }
}