<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

interface GetController {
    public function getAll(Request $request);
    public function getOne($id);
}