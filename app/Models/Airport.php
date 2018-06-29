<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Airport extends Model {
    protected $table = 'airport';

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
