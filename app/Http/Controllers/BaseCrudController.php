<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CrudController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Request;

abstract class BaseCrudController extends BaseGetController implements CrudController {

    /**
     * @param Request $request
     * @return mixed
     */
    public function postOne(Request $request) {
        $input = $this->validateInput($request);

        $this->getModel()::create($input);

        return response()
            ->json(
                [],
                204
            );
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteOne($id) {
        $one = $this->findOne($id);

        $one->delete();

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
    private function validateInput(Request $request): array {
        return $request->input();
    }
}