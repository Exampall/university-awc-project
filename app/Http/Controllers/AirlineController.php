<?php

namespace App\Http\Controllers;

use App\Models\Airline;

class AirlineController extends BaseExtendedCrudController {
    public function __construct() {
        $this->validator = [
            'name' => 'required|string|max:255',
            'nationality' => 'required|integer|min:1|exists:country,id',
            'share_price' => 'required|numeric',
        ];
        $this->validatorMessages = [
            'nationality.integer' => 'The nationality must be an integer id > 0',
            'nationality.min' => 'The nationality must be an integer id > 0',
            'exists' => 'The :attribute :input has not been found',
        ];

        $this->allowedInputs = [
            'name',
            'nationality',
            'share_price',
        ];
    }

    protected function getModel() {
        return Airline::class;
    }
}
