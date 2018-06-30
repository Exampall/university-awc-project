<?php

namespace App\Http\Controllers;

use App\Models\Airline;

class AirlineController extends BaseExtendedCrudController {
    public function __construct() {
        $this->validator = [
            'name' => 'required|string|max:255',
            'nationality' => 'required|integer|min:1|exists:country,id',
            'share_price' => 'required|numeric',
            'partners' => 'present|array',
            'partners.*' => 'distinct|integer|min:1|exists:airline,id',
        ];
        $this->validatorMessages = [
            'nationality.integer' => 'The nationality must be an integer id > 0',
            'nationality.min' => 'The nationality must be an integer id > 0',
            'exists' => 'The :attribute :input has not been found',
        ];

        $this->allowedInputs = [
            'name',
            'nationality',
            'share_price',
        ];
    }

    protected function getModel() {
        return Airline::class;
    }

    private function syncAirlinePartners($request, $model) {
        $partners = $request->input('partners');
        $model->partners()->sync($partners);
    }

    protected function afterCreation($request, $model) {
        $this->syncAirlinePartners($request, $model);
    }

    protected function afterUpdate($request, $model) {
        $this->syncAirlinePartners($request, $model);
    }

    protected function afterPatch($request, $model) {
        if ($request->has('partners')) {
            $this->syncAirlinePartners($request, $model);
        }
    }
}
