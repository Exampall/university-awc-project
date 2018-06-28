<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CrudController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Request;

abstract class BaseGetController extends Controller implements GetController {

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
    protected function filterQuery(Request $request, $model) {
        return $model::query();
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
            throw new NotFoundHttpException(substr($model, strrpos($model, '\\') + 1) . '@' . $id . ' not found');
        }

        return $one;
    }
}