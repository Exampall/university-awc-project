<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class ReferenceableModel extends Model {
    public static $path = '';

    protected static function toUrl($id, $params = []): array{
        $reference = [
            '_self' => URL::to('/') . '/' . static::$path . '/' . $id,
        ];
        if (count($params)) {
            $reference['params'] = [];
            foreach ($params as $key => $value) {
                $reference['params'][] = [
                    $key => $value,
                ];
            }
        }

        return $reference;
    }
}