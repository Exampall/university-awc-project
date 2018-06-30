<?php

namespace App\Http\Controllers;

use App\Models\AirRoute;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AirRouteController extends BaseExtendedCrudController {
    public function __construct() {
        $this->validator = [
            'type' => [
                'required',
                Rule::in(['I', 'N']),
            ],
            'airport_departure' => 'required|integer|min:1|exists:airport,id|different:airport_arrival',
            'airport_arrival' => 'required|integer|min:1|exists:airport,id|different:airport_departure',
            'max_slot_reservations' => 'required|integer|min:1|',
            'aircraft_types' => 'present|array',
            'aircraft_types.*' => 'distinct|integer|min:1|exists:aircraft_types,id',
        ];
        $this->validatorMessages = [
            'airport_departure.integer' => 'The departure airport must be an integer id > 0',
            'airport_departure.min' => 'The departure airport must be an integer id > 0',
            'airport_arrival.integer' => 'The arrival airport must be an integer id > 0',
            'airport_arrival.min' => 'The arrival airport must be an integer id > 0',
            'different' => 'The airports must be different',
            'exists' => 'The :attribute :input has not been found',
            'in' => 'The :attribute must be one of the following types: [:values]',
        ];

        $this->allowedInputs = [
            'type',
            'airport_departure',
            'airport_arrival',
            'max_slot_reservations',
        ];
    }

    protected function getModel() {
        return AirRoute::class;
    }

    private function syncAircraftTypes($request, $model) {
        $aircraft_types = $request->input('aircraft_types');
        $model->aircraftTypes()->sync($aircraft_types);
    }

    protected function afterCreation($request, $model) {
        $this->syncAircraftTypes($request, $model);
    }

    protected function afterUpdate($request, $model) {
        $this->syncAircraftTypes($request, $model);
    }

    protected function afterPatch($request, $model) {
        if ($request->has('aircraft_types')) {
            $this->syncAircraftTypes($request, $model);
        }
    }

    protected function filterQuery(Request $request) {
        if ($request->filled('aircraft_type')) {
            $aircraft_types = explode(',', $request->input('aircraft_type'));
            $aircraft_types = array_filter($aircraft_types, function ($item) {
                return is_numeric($item);
            });
            return AirRoute::whereHas('aircraftTypes', function ($query) use ($aircraft_types) {
                $query->whereIn('id', $aircraft_types);
            });
        } else {
            return AirRoute::query();
        }
    }
}
