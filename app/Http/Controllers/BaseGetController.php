<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class BaseGetController extends BaseController implements GetController {

    /**
     * @param Request $request
     * @return mixed
     */
    public function getAll(Request $request) {
        $pagination = $this->paginate($request, $this->filterQuery($request, $this->getModel()));

        return response()
            ->json($pagination);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getOne($id) {
        $one = $this->findOne($id);

        return response()
            ->json(
                $this->formatResponse($one)
            );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected abstract function getModel();

    /**
     * for filtering query before getAll
     *
     * @param Request $request
     * @param $model
     * @return mixed
     */
    protected function filterQuery(Request $request) {
        return $this->getModel()::query();
    }

    /**
     * @param $id
     * @return mixed
     */
    protected function findOne($id) {
        $model = $this->getModel();

        try {
            $one = $model::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new NotFoundHttpException($this->getModelName($model) . '@' . $id . ' not found');
        }

        $one = $this->loadOne($one);

        return $one;
    }

    /**
     * given a model instance, load or customize it
     *
     * @param Model $model
     * @return mixed
     */
    protected function loadOne($model) {
        return $model;
    }
}