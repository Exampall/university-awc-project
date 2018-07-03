<?php

namespace App\Http\Controllers;

use App\Models\AirRouteSlot;
use Illuminate\Http\Request;

class AirRouteSlotController extends BaseExtendedCrudController {

    public function __construct() {

        self::$validator = [
            'air_route' => 'required|integer|min:1|exists:air_routes,id',
            'day' => 'required|integer|min:1|max:7',
            'schedule' => 'required|date_format:H:i',
            'max_reservations' => 'required|integer|min:1',
        ];

        self::$validatorMessages = [
            'air_route.integer' => 'The departure airport must be an integer id > 0',
            'air_route.min' => 'The departure airport must be an integer id > 0',
            'exists' => 'The :attribute :input has not been found',
        ];

        self::$allowedInputs = [
            'air_route',
            'day',
            'schedule',
            'max_reservations'
        ];
    }

    protected function getModel() {
        return AirRouteSlot::class;
    }

    protected function filterQuery(Request $request) {
        if ($request->filled('air_route')) {
            $air_routes = explode(',', $request->input('air_route'));
            $air_routes = array_filter($air_routes, function ($item) {
                return is_numeric($item) && is_int( (int) $item) && (int) $item >= 1;
            });
            return AirRouteSlot::whereIn('air_route', $air_routes);
        } else {
            return AirRouteSlot::query();
        }
    }
}
