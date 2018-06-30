<?php

namespace App\Http\Controllers;

use App\Models\AircraftType;

class AircraftTypeController extends BaseGetController {

    protected function getModel() {
        return AircraftType::class;
    }
}
