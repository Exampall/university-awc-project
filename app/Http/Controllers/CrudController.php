<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

interface CrudController extends GetController {
    public function postOne(Request $request);
    public function deleteOne($id);
}