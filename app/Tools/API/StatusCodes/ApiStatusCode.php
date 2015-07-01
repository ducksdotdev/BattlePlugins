<?php

namespace App\Tools\API\StatusCodes;

use Illuminate\Http\Response;

class ApiStatusCode extends StatusCode {

    public function respondCreated($message = 'Object Created.') {
        return StatusCode::respondWithSuccess($message, Response::HTTP_CREATED);
    }

}