<?php

namespace App\Http\Controllers;

use App\Models\AirRoute;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class AirRouteController extends BaseExtendedCrudController {
    public function __construct() {

        self::$validator = [
            'type' => [
                'required',
                Rule::in(['I', 'N']),
            ],
            'airport_departure' => 'required|integer|min:1|exists:airport,id|different:airport_arrival',
            'airport_arrival' => 'required|integer|min:1|exists:airport,id|different:airport_departure',
        ];

        self::$validatorMessages = [
            'airport_departure.integer' => 'The departure airport must be an integer id > 0',
            'airport_departure.min' => 'The departure airport must be an integer id > 0',
            'airport_arrival.integer' => 'The arrival airport must be an integer id > 0',
            'airport_arrival.min' => 'The arrival airport must be an integer id > 0',
            'different' => 'The airports must be different',
            'exists' => 'The :attribute :input has not been found',
            'in' => 'The :attribute must be one of the following types: [:values]',
        ];

        self::$allowedInputs = [
            'type',
            'airport_departure',
            'airport_arrival',
        ];
    }

    protected function getModel() {
        return AirRoute::class;
    }

    protected function filterQuery(Request $request) {
        if ($request->filled('aircraft_type')) {
            $aircraft_types = explode(',', $request->input('aircraft_type'));
            $aircraft_types = array_filter($aircraft_types, function ($item) {
                return is_numeric($item) && is_int((int) $item) && (int) $item >= 1;
            });
            return AirRoute::whereHas('aircraftTypes', function ($query) use ($aircraft_types) {
                $query->whereIn('id', $aircraft_types);
            });
        } else {
            return AirRoute::query();
        }
    }

    public function getAircraftTypes(Request $request, $airRoute) {
        $model = $this->findOne($airRoute);

        $aircraftTypes = $model->getAircraftTypes();

        return response()
            ->json(
                $this->formatResponse($aircraftTypes)
            );
    }

    public function postAircraftType(Request $request, $airRoute) {
        $model = $this->findOne($airRoute);

        $input = $this->processInput(
            $request,
            [
                'aircraft_type' => 'required|integer|min:1|exists:aircraft_types,id',
            ],
            [
                'aircraft_type',
            ],
            false
        );

        $aircraftType = $input['aircraft_type'];

        $exists = $model->aircraftTypes->contains($aircraftType);
        if ($exists) {
            throw new BadRequestHttpException('Aircraft type ' . $aircraftType . ' already associated with air route ' . $airRoute);
        }
        
        $model->aircraftTypes()->attach(['aircraft_type' => $aircraftType]);

        return response()
            ->json(
                [],
                204
            );
    }

    public function deleteAircraftType(Request $request, $airRoute, $id) {
        $model = $this->findOne($airRoute);

        $exists = $model->aircraftTypes->contains($id);
        if (!$exists) {
            throw new BadRequestHttpException('Aircraft type ' . $id . ' is not associated with air route ' . $airRoute);
        }

        $model->aircraftTypes()->detach(['aircraft_type' => $id]);

        return response()
            ->json(
                [],
                204
            );
    }
}
