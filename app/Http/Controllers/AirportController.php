<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Illuminate\Http\Request;
use App\Models\Airport;

class AirportController extends BaseCrudController {

    protected function getModel() {
        return Airport::class;
    }
}
