<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait BaseResponse
{
    /**
     * Core of response
     *
     * @param string        $message
     * @param array|object  $data
     * @param string        $paginate
     * @param integer       $statusCode
     * @param boolean       $isSuccess
     */
    public function coreResponse($message, $data, $paginate, $statusCode, $isSuccess = true)
    {
        if ($isSuccess) {
            if ($statusCode == Response::HTTP_OK && $paginate == '1') {
                return response()->json([
                    'data' => $data->items(),
                    'meta' => [
                        'current_page' => $data->currentPage(),
                        'from' => $data->firstItem(),
                        'last_page' => $data->lastPage(),
                        'path' => $data->path(),
                        'per_page' => $data->perPage(),
                        'to' => $data->lastItem(),
                        'total' => $data->total(),
                    ],
                    'links' => [
                        'first' => $data->url(1),
                        'last' => $data->url($data->lastPage()),
                        'prev' => $data->previousPageUrl(),
                        'next' => $data->nextPageUrl(),
                    ],
                ], $statusCode);
            }
            if ($statusCode == Response::HTTP_OK) {
                return response()->json([
                    'data' => $data
                ], $statusCode);
            }
            if ($statusCode == Response::HTTP_CREATED) {
                return response()->json([
                    'data' => $data
                ], $statusCode);
            }
            if ($statusCode == Response::HTTP_NO_CONTENT) {
                return response()->json([], $statusCode);
            }
        } else {
            if ($statusCode == Response::HTTP_UNPROCESSABLE_ENTITY) {
                return response()->json([
                    'message' => $message
                ], $statusCode);
            }
            if ($statusCode == Response::HTTP_UNAUTHORIZED) {
                return response()->json([
                    'message' => $message
                ], $statusCode);
            }
            if ($statusCode == Response::HTTP_BAD_REQUEST) {
                return response()->json([
                    'message' => $message
                ], $statusCode);
            }
            if ($statusCode == Response::HTTP_NOT_FOUND) {
                return response()->json([
                    'message' => $message
                ], $statusCode);
            }
            return response()->json([
                'message' => $message
            ], $statusCode);
        }
    }

    /**
     * Send any success response
     *
     * @param string        $message
     * @param array|object  $data
     * @param string        $paginate
     * @param interger      $statusCode
     */
    public function success($message, $data, $paginate = '0', $statusCode = 200)
    {
        return $this->coreResponse($message, $data, $paginate, $statusCode);
    }

    /**
     * Send any error response
     *
     * @param string        $message
     * @param integer       $statusCode
     */
    public function error($message, $statusCode = 500)
    {
        return $this->coreResponse($message, null, '0', $statusCode, false);
    }
}
