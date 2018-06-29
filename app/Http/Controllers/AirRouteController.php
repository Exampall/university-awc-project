<?php

namespace App\Http\Controllers;

use App\Models\AirRoute;
use Illuminate\Http\Request;

class AirRouteController extends BaseCrudController {

    protected function getModel() {
        return AirRoute::class;
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
