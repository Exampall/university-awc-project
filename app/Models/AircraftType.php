<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AircraftType extends Model {
    protected $table = 'aircraft_types';

    protected $fillable = [
        'name',
        'code'
    ];

    public function aircrafts() {
        return $this->hasMany('App\Aircraft', 'type');
    }
}