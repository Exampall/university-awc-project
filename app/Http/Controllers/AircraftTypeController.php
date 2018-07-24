<?php

namespace App\Http\Controllers;

use App\Models\AircraftType;

class AircraftTypeController extends BaseGetController {

    protected function getModel() {
        return AircraftType::class;
    }

    public function getAirRoutes(Request $request, $aircraftType) {
        $model = $this->findOne($aircraftType);

        $airRoutes = $model->getAirRoutes();

        return response()
            ->json(
                $this->formatResponse($airRoutes)
            );
    }
}
