<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Illuminate\Http\Request;
use App\Models\Application;

class ApplicationsController extends BaseGetController {

    protected function getModel() {
        return Application::class;
    }

    protected function validateInput(Request $request): array {
        try {
            $this->validate($request, [
                'name' => 'required'
            ]);
        } catch (ValidationException $e) {
            throw new BadRequestHttpException('Needed parameters not found: [name]');
        }

        return [
            'name' => $request->input('name')
        ];
    }
}
