<?php

namespace App\Models;

use App\Models\ReferenceableModel;

class Airline extends ReferenceableModel {
    protected $table = 'airline';
    public static $path = 'airline';

    protected $fillable = [
        'name',
        'nationality',
        'share_price'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function isFrom() {
        return $this->belongsTo('App\Models\Country', 'nationality');
    }

    public function partners() {
        return $this->belongsToMany('App\Models\Airline', 'airline_partners', 'airline', 'partner');
    }

    public function reservations() {
        return $this->belongsToMany('App\Models\AirRouteSlot', 'airline_reservations', 'airline', 'slot');
    }

    public function toArray()
    {
        $airlineypeUrls = [];
        foreach ($this->partners as $partner) {
            $airlineypeUrls[] = Airline::toUrl($partner->id);
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'nationality' => $this->isFrom,
            'sharePrice' => $this->share_price,
            'partners' => $airlineypeUrls
        ];
    }
}