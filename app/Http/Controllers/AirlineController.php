<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class AirlineController extends BaseExtendedCrudController {
    public function __construct() {

        self::$validator = [
            'name' => 'required|string|max:255',
            'nationality' => 'required|integer|min:1|exists:country,id',
            'share_price' => 'required|numeric',
        ];

        self::$validatorMessages = [
            'nationality.integer' => 'The nationality must be an integer id > 0',
            'nationality.min' => 'The nationality must be an integer id > 0',
            'exists' => 'The :attribute :input has not been found',
        ];

        self::$allowedInputs = [
            'name',
            'nationality',
            'share_price',
        ];
    }

    protected function getModel() {
        return Airline::class;
    }

    public function getPartners(Request $request, $airline) {
        $model = $this->findOne($airline);

        $partners = $model->getPartners();

        return response()
            ->json(
                $this->formatResponse($partners)
            );
    }

    public function postPartner(Request $request, $airline) {
        $model = $this->findOne($airline);

        $input = $this->processInput(
            $request,
            [
                'partner' => 'required|integer|min:1|exists:airline,id',
            ],
            [
                'partner',
            ],
            false
        );

        $partner = $input['partner'];

        if ($partner == $model->id) {
            throw new BadRequestHttpException('Can\'t associate same airline as partner');
        }

        $exists = $model->partners->contains($partner);
        if ($exists) {
            throw new BadRequestHttpException('Airline ' . $partner . ' already partner with airline ' . $airline);
        }

        $model->partners()->attach(['partner' => $partner]);

        return response()
            ->json(
                [],
                204
            );
    }

    public function deletePartner(Request $request, $airline, $id) {
        $model = $this->findOne($airline);

        $exists = $model->partners->contains($id);
        if (!$exists) {
            throw new BadRequestHttpException('Airline ' . $id . ' is not partner with airline ' . $airline);
        }

        $model->partners()->detach(['partner' => $id]);

        return response()
            ->json(
                [],
                204
            );
    }
}
