<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseGetController;
use App\Http\Controllers\CrudController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class BaseCrudController extends BaseGetController implements CrudController {

    protected $validator = [];
    protected $validatorMessages = [];
    protected $allowedInputs = null;

    /**
     * @param Request $request
     * @return mixed
     */
    public function postOne(Request $request) {
        $input = $this->processInput($request);

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
     * process input by executing validation and transformation on it
     *
     * @param Request $request
     * @return array
     */
    protected function processInput(Request $request): array{
        $input = $this->validateInput($request);

        $input = $this->transformInput($input);

        return $input;
    }

    /**
     * validate input: array of key-values if input is valid
     * should throw BadRequestHttpException if input is not valid, other types of exception for other errors
     *
     * @param Request $request
     * @param array $validator
     * @return array
     */
    protected function validateInput(Request $request, $validator): array{
        $this->validateWithValidator($request, $validator);

        $input = $this->filterAllowedInputs($request);

        return $input;
    }

    /**
     * validate input with lumen validator, with the given validator array
     *
     * @param Request $request
     * @param array $validator
     * @return void
     */
    private function validateWithValidator(Request $request, $validator) {
        try {
            $this->validate($request, $validator, $this->validatorMessages);
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
    private function filterAllowedInputs(Request $request): array{
        if ($this->allowedInputs != null) {
            return $request->only($this->allowedInputs);
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
}