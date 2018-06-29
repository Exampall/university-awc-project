<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Airline extends Model {
    protected $table = 'airline';

    protected $fillable = [
        'name',
        'nationality',
        'share_price'
    ];

    public function isFrom() {
        return $this->belongsTo('App\Country', 'nationality');
    }

    public function partners() {
        return $this->belongsToMany('App\Airline', 'airline_partners', 'airline', 'partner');
    }

    public function reservations() {
        return $this->belongsToMany('App\AirRouteSlot', 'airline_reservations', 'airline', 'slot');
    }
}