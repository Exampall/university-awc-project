<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseCrudController;
use App\Http\Controllers\ExtendedCrudController;
use Illuminate\Http\Request;

abstract class BaseExtendedCrudController extends BaseCrudController implements ExtendedCrudController {

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function putOne(Request $request, $id) {
        $model = $this->findOne($id);

        $input = $this->processInput($request, self::$validator, self::$allowedInputs);

        $model->update($input);

        $this->afterUpdate($request, $model);

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

        $validator = $this->patchValidator();
        $input = $this->processInput($request, $validator, self::$allowedInputs);

        $model->update($input);

        $this->afterPatch($request, $model);

        return response()
            ->json(
                [],
                204
            );
    }

    /**
     * transform lumen input validator in a patch validator (no fields required)
     *
     * @return array
     */
    private function patchValidator(): array {
        $validator = self::$validator;
        foreach ($validator as $key => $value) {
            if (is_array($validator[$key])) {
                array_push($validator[$key], 'sometimes');
            } else {
                $validator[$key] = $validator[$key] . '|sometimes';
            }
        }
        return $validator;
    }

    /**
     * after update callback
     *
     * @param Request $request
     * @param Model $model
     * @return void
     */
    protected function afterUpdate($request, $model) {

    }

    /**
     * after patch callback
     *
     * @param Request $request
     * @param Model $model
     * @return void
     */
    protected function afterPatch($request, $model) {

    }
}