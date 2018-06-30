<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseGetController;
use App\Http\Controllers\CrudController;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

abstract class BaseCrudController extends BaseGetController implements CrudController {

    public static $validator = [];
    public static $validatorMessages = [];
    public static $allowedInputs = null;

    /**
     * @param Request $request
     * @return mixed
     */
    public function postOne(Request $request) {
        $input = $this->processInput($request, self::$validator, self::$allowedInputs);

        $model = $this->getModel()::create($input);

        $this->afterCreation($request, $model);

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

        $this->afterDeletion($one);

        return response()
            ->json(
                [],
                204
            );
    }

    /**
     * process input by executing validation and transformation on it
     *
     * @param Request $request
     * @return array
     */
    protected function processInput(Request $request, $validator = [], $allowedInputs = null, $transformInput = true): array{

        $this->validateInput($request, $validator);

        $input = $this->filterAllowedInputs($request, $allowedInputs);

        if ($transformInput) {
            $input = $this->transformInput($input);
        }

        return $input;
    }

    /**
     * validate input with lumen validator
     * should throw BadRequestHttpException if input is not valid, other types of exception for other errors
     *
     * @param Request $request
     * @param array $validator
     * @return void
     */
    protected function validateInput(Request $request, $validator) {
        try {
            $this->validate($request, $validator, self::$validatorMessages);
        } catch (ValidationException $e) {
            foreach ($e->getResponse()->getOriginalContent() as $key => $value) {
                throw new BadRequestHttpException($value[0]);
            }
        }
    }

    /**
     * filter inputs to match ones given in the allowedInputs array
     *
     * @param Request $request
     * @return array
     */
    private function filterAllowedInputs(Request $request, $allowedInputs): array{
        if ($allowedInputs != null) {
            return $request->only($allowedInputs);
        }

        return $request->input();
    }

    /**
     * transform input if needed
     *
     * @param array $input
     * @return array
     */
    protected function transformInput($input): array{
        return $input;
    }

    /**
     * after creation callback
     *
     * @param Request $request
     * @param Model $model
     * @return void
     */
    protected function afterCreation($request, $model) {

    }

    /**
     * after deletion callback
     *
     * @param Model $model
     * @return void
     */
    protected function afterDeletion($model) {

    }
}