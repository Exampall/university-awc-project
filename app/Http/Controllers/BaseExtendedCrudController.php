<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseCrudController;
use App\Http\Controllers\ExtendedCrudController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Request;

abstract class BaseExtendedCrudController extends BaseCrudController implements ExtendedCrudController {

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function putOne(Request $request, $id) {
        $model = $this->findOne($id);

        $input = $this->validateInput($request);

        $model->update($input);

        return response()
            ->json(
                [],
                204
            );
    }

    /**
     * @param Request $id
     * @param $id
     * @return mixed
     */
    public function patchOne(Request $request, $id) {
        $model = $this->findOne($id);

        $input = $this->validatePatchInput($request);

        $model->update($input);

        return response()
            ->json(
                [],
                204
            );
    }

    /**
     * validate input: array of key-values if input is valid
     * should throw BadRequestHttpException if input is not valid, other types of exception for other errors
     *
     * @param Request $request
     * @return array
     */
    protected function validatePatchInput(Request $request): array {
        return $request->input();
    }
}