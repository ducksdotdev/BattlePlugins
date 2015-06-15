<?php

namespace App\Tools\API\StatusCodes;
use Illuminate\Http\Response;

/**
 * Class StatusCode
 * @package App\Tools\StatusCodes
 */
class StatusCode {

	/**
	 * @param string $message
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function respondNotFound($message = 'Not Found!'){
		return $this->respondWithError($message, Response::HTTP_NOT_FOUND);
	}

	/**
	 * @param string $message
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function respondInternalError($message = 'Internal Error.'){
		return $this->respondWithError($message, Response::HTTP_INTERNAL_SERVER_ERROR);
	}

	/**
	 * @param string $message
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function respondValidationFailed ($message = 'Failed to validate request.'){
		return $this->respondWithError($message, Response::HTTP_UNPROCESSABLE_ENTITY);
	}

	/**
	 * @param $data
	 * @param int $statusCode
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function respond($data, $statusCode = Response::HTTP_OK){
		return response()->json($data, $statusCode);
	}

	/**
	 * @param $message
	 * @param int $statusCode
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function respondWithError ($message, $statusCode = Response::HTTP_OK){
		return $this->respond([
			'error' => [
				'message' => $message,
				'status_code' => $statusCode
			]
		], $statusCode);
	}

	/**
	 * @param $message
	 * @param int $statusCode
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function respondWithSuccess ($message, $statusCode = Response::HTTP_OK){
		return $this->respond([
			'success' => [
				'message' => $message,
				'status_code' => $statusCode
			]
		], $statusCode);
	}

}