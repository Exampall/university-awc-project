<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CrudController;
use Illuminate\Http\Request;

interface ExtendedCrudController extends CrudController {
    public function putOne(Request $request, $id);
    public function patchOne(Request $request, $id);
}