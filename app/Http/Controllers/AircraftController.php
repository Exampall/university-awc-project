<?php

namespace App\Http\Controllers;

use App\Models\Aircraft;
use Illuminate\Validation\Rule;

class AircraftController extends BaseExtendedCrudController {

    public function __construct() {
        $this->validator = [
            'type' => 'required|integer|min:1|exists:aircraft_types,id',
            'seats' => 'required|integer|min:0',
            'max_speed' => 'required|integer|min:0',
            'wingspan' => 'required|integer|min:0',
            'engine_type' => [
                'required',
                Rule::in(['B', 'D']),
            ],
            'airline' => 'required|integer|min:1|exists:airline,id',
        ];
        $this->validatorMessages = [
            'type.integer' => 'The type must be an integer id > 0',
            'type.min' => 'The type must be an integer id > 0',
            'airline.integer' => 'The airline must be an integer id > 0', 
            'airline.min' => 'The airline must be an integer id > 0', 
            'in' => 'The :attribute must be one of the following types: [:values]',
            'exists' => 'The :attribute :input has not been found'
        ];

        $this->allowedInputs = [
            'type',
            'seats',
            'max_speed',
            'wingspan',
            'engine_type',
            'airline',
        ];
    }

    protected function getModel() {
        return Aircraft::class;
    }

    protected function transformInput($input): array{
        if (array_key_exists('wingspan', $input)) {
            $input['radius'] = floor($input['wingspan'] / 2);
        }

        return $input;
    }
}
