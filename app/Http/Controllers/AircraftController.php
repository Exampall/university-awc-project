<?php

namespace App\Http\Controllers;

use App\Models\Aircraft;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AircraftController extends BaseExtendedCrudController {

    protected function getModel() {
        return Aircraft::class;
    }

    private function fillInput($input) {
        if (array_key_exists('wingspan', $input)) {
            $input['radius'] = floor($input['wingspan'] / 2);
        }

        return $input;
    }

    private function validateValue($key, $value) {
        // type and airline
        if (in_array($key, ['type', 'airline'])) {
            if (!is_numeric($value) || $value <= 0 ||
                !is_numeric($value) || $value <= 0) {
                throw new BadRequestHttpException('Type and airline parameters must be numeric ids >= 0');
            }
            try {
                \App\Models\AircraftType::findOrFail($value);
                \App\Models\Airline::findOrFail($value);
            } catch (ModelNotFoundException $e) {
                throw new NotFoundHttpException(substr($e->getModel(), strrpos($e->getModel(), '\\') + 1) . '@' . implode(',', $e->getIds()) . ' not found');
            }
        } else if (in_array($key, ['seats', 'max_speed', 'wingspan'])) {
            if (!is_numeric($value) ||
                $value < 0) {
                throw new BadRequestHttpException('Aircraft properties should be numeric values > 0');
            }
        } else if ($key == 'engine_type') {
            if (!in_array($value, ['B', 'D'])) {
                throw new BadRequestHttpException('Wrong engine type [\'B\', \'D\'], "' . $value . '" given');
            }
        }
    }

    protected function validateInput(Request $request): array{
        try {
            $this->validate($request, [
                'type' => 'required',
                'seats' => 'required',
                'max_speed' => 'required',
                'wingspan' => 'required',
                'engine_type' => 'required',
                'airline' => 'required',
            ]);
        } catch (ValidationException $e) {
            foreach ($e->getResponse()->getOriginalContent() as $key => $value) {
                throw new BadRequestHttpException($value[0]);
            }
        }

        return $this->validatePatchInput($request);
    }

    protected function validatePatchInput(Request $request): array{
        $input = $request->only([
            'type',
            'seats',
            'max_speed',
            'wingspan',
            'engine_type',
            'airline',
        ]);

        foreach ($input as $key => $value) {
            $this->validateValue($key, $value);
        }

        return $this->fillInput($input);
    }
}
