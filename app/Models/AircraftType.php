<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AircraftType extends Model {
    protected $table = 'aircraft_types';

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