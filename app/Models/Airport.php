<?php

namespace App\Models;

use App\Models\ReferenceableModel;

class Airport extends ReferenceableModel {
    protected $table = 'airport';
    public static $path = 'airport';

    protected $fillable = [
        'name',
        'country'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function situated() {
        return $this->belongsTo('App\Models\Country', 'country');
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'country' => $this->situated
        ];
    }
}
