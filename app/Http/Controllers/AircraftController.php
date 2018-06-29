<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Illuminate\Http\Request;
use App\Models\Aircraft;

class AircraftController extends BaseCrudController {

    protected function getModel() {
        return Aircraft::class;
    }

    protected function validateInput(Request $request): array {
        try {
            $this->validate($request, [
                'type' => 'required',
                'seats' => 'required',
                'max_speed' => 'required',
                'wingspan' => 'required',
                'engine_type' => 'required',
                'airline' => 'required'
            ]);
        } catch (ValidationException $e) {
            throw new BadRequestHttpException(json_encode($e));
        }

        $input = $request->only([
            'type',
            'seats',
            'max_speed',
            'wingspan',
            'engine_type',
            'airline'
        ]);

        if (!is_numeric($input['type']) || !is_numeric($input['airline'])) {
            throw new BadRequestHttpException('Type and airline parameters must be numeric ids');
        }

        if (!is_numeric($input['seats']) || 
            !is_numeric($input['max_speed']) ||
            !is_numeric($input['wingspan']) || 
            $input['seats'] < 0 || 
            $input['max_speed'] < 0 ||
            $input['wingspan'] < 0) {
            throw new BadRequestHttpException('Aircraft properties should be numeric values > 0');
        }

        if (!in_array($input['engine_type'], ['B', 'D'])) {
            throw new BadRequestHttpException('Wrong engine type [\'B\', \'D\']');
        }

        App\Models\AircraftType::findOrFail($input['type']);
        App\Models\Airline::findOrFail($input['airline']);


        return array_merge($input, ['radius' => floor($request->input('wingspan') / 2)]);
    }
}
