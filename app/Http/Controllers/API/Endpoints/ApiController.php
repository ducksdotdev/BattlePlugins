<?php

namespace App\Http\Controllers\API\Endpoints;

use App\Http\Controllers\Controller;
use Auth;

/**
 * Class ApiController
 * @package App\Http\Controllers
 */
abstract class ApiController extends Controller {

    /**
     * @param $item
     * @param $data
     * @return mixed
     */
    public function returnWithPagination($item, $data) {
        $data = array_merge($data, [
            'paginator' => [
                'total_count' => $item->total(),
                'total_pages' => ceil($item->total() / $item->perPage()),
                'current_page' => $item->currentPage(),
                'limit' => $item->perPage()

            ]
        ]);

        return $this->statusCode->respond($data);
    }

}