<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController {
    /**
     * @param string $data
     * @param array $meta_data
     * @return String
     */
    protected function formatResponse($data = 'OK', $meta_data = []) {

        $data = ['data' => $data];
        $response = array_merge($data, $meta_data);

        return $response;
    }

    /**
     *
     * @param string $url
     * @param number $page
     * @param number $batch
     * @return string
     */
    private function buildPaginationUrl($url, $page, $batch){
        $url .= 'page=' . $page;
        $url .= '&batch=' . $batch;
        return $url;
    }

    /**
     * paginate query and add meta information about pagination
     * if no page or batch is set, then defaults are used (1 and 50)
     *
     * @param Request $request
     * @param [type] $query
     * @return mixed
     */
    protected function paginate(Request $request, $query) {
        $url = env('BASE_URL') . '/' . $request->path();
        $additionalQueryParams = $request->except(['page', 'batch']);
        $url .= '?';
        foreach ($additionalQueryParams as $param => $value) {
            $url .= $param . '=' . $value . '&';
        }

        if ($request->filled('page') || $request->filled('batch')) {
            $page = $request->filled('page') && is_numeric($request->input('page')) && $request->input('page') >= 1 ? $request->input('page') : 1;
            $batch = $request->filled('batch') && is_numeric($request->input('batch')) && $request->input('batch') >= 0 ? (int) $request->input('batch') : 50;

            $raw = $query->paginate($batch, ['*'], 'page', $page)->toArray();
            $data = $raw['data'];
            $meta = [
                'size' => count($data),
                'page' => $raw['current_page'],
                'pages' => $raw['last_page'],
                'total' => $raw['total'],
                'first' => $this->buildPaginationUrl($url, 1, $batch),
                'last' => $this->buildPaginationUrl($url, $raw['last_page'], $batch),
            ];

            if ($raw['current_page'] >= 1 && $raw['current_page'] < $raw['last_page']) {
                $meta['next'] = $this->buildPaginationUrl($url, $raw['current_page'] + 1, $batch);
            }

            if ($raw['current_page'] > 1 && $raw['current_page'] <= $raw['last_page']) {
                $meta['prev'] = $this->buildPaginationUrl($url, $raw['current_page'] - 1, $batch);
            }


        } else {
            $data = $query->get();
            $meta = [
                'size' => count($data),
            ];
        }
        
        return $this->formatResponse($data, $meta);
    }
}