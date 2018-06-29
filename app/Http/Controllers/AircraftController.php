<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Illuminate\Http\Request;
use App\Models\Aircraft;

class AircraftController extends BaseGetController {

    protected function getModel() {
        return Aircraft::class;
    }
}
