<?php

namespace App\Http\Controllers;

use App\Models\Airport;

class AirportController extends BaseExtendedCrudController {
    public function __construct() {
        self::$validator = [
            'name' => 'required|string|max:255',
            'country' => 'required|integer|min:1|exists:country,id',
        ];
        self::$validatorMessages = [
            'country.integer' => 'The country must be an integer id > 0',
            'country.min' => 'The country must be an integer id > 0',
            'exists' => 'The :attribute :input has not been found',
        ];

        self::$allowedInputs = [
            'name',
            'country',
        ];
    }

    protected function getModel() {
        return Airport::class;
    }
}
