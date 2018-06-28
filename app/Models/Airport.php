<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Airport extends Model {
    protected $table = 'airport';

    protected $fillable = [
        'name',
        'country'
    ];

    public function situated() {
        return $this->belongsTo('App\Country', 'country');
    }
}
