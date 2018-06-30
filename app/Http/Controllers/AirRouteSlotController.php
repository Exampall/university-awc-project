<?php

namespace App\Http\Controllers;

use App\Models\AirRouteSlot;

class AirRouteSlotController extends BaseGetController {

    protected function getModel() {
        return AirRouteSlot::class;
    }
}
