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
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function model() {
        return $this->belongsTo('App\Models\AircraftType', 'type');
    }

    public function partOfAirline() {
        return $this->belongsTo('App\Models\Airline', 'airline');
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'type' => $this->model,
            'seats' => $this->seats,
            'maxSpeed' => $this->max_speed,
            'wingspan' => $this->wingspan,
            'radius' => $this->radius,
            'engineType' => $this->engine_type,
            'airline' => Airline::toUrl($this->partOfAirline->id)
        ];
    }
}