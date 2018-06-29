<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferenceableModel extends Model {
    public static $path = '';

    protected static function toUrl($id, $params = []): array{
        $reference = [
            '_self' => env('BASE_URL') . '/' . static::$path . '/' . $id,
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