<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

trait APIResponseTrait
{

    /**
     * @param array|Collection|null $attributes
     * @param string|null $message
     * @return JsonResponse
     */
    public function responseSuccess(array|Collection|null $attributes = null, string $message = null): JsonResponse
    {
        return $this->response(Response::HTTP_OK, $attributes, $message ?? "Successfully Done");
    }

    /**
     * @param array|Collection|null $attributes
     * @param string|null $message
     * @return JsonResponse
     */
    public function responseStore(array|Collection $attributes = null, string $message = null): JsonResponse
    {
        return $this->response(Response::HTTP_OK, $attributes, $message ?? "Successfully Saved");
    }

    /**
     * @param array|Collection|null $attributes
     * @param string|null $message
     * @return JsonResponse
     */
    public function responseUpdate(array|Collection|null $attributes = null, string $message = null): JsonResponse
    {
        return $this->response(Response::HTTP_OK, $attributes, $message ?? "Successfully Updated");
    }

    /**
     * @param array|Collection|null $attributes
     * @param string|null $message
     * @return JsonResponse
     */
    public function responseDestroy(array|Collection|null $attributes = null, string $message = null): JsonResponse
    {
        return $this->response(Response::HTTP_OK, $attributes, $message ?? "Successfully Deleted");
    }

    /**
     * @param array|Collection|null $attributes
     * @param string|null $message
     * @return JsonResponse
     */
    public function responseRestore(array|Collection|null $attributes = null, string $message = null): JsonResponse
    {
        return $this->response(Response::HTTP_OK, $attributes, $message ?? "Successfully Restored");
    }

    /**
     * @param array|Collection|null $attributes
     * @param string|null $message
     * @return JsonResponse
     */
    public function responseBadRequest(array|Collection|null $attributes = null, string $message = null): JsonResponse
    {
        return $this->response(Response::HTTP_BAD_REQUEST, $attributes, $message ?? "Bad Request");
    }

    /**
     * @param array|Collection|null $attributes
     * @param string|null $message
     * @return JsonResponse
     */
    public function responseUnauthorized(array|Collection|null $attributes = null, string $message = null): JsonResponse
    {
        return $this->response(Response::HTTP_UNAUTHORIZED, $attributes, $message ?? "Unauthorized");
    }

    /**
     * @param array|Collection|null $attributes
     * @param string|null $message
     * @return JsonResponse
     */
    public function responseNotFound(array|Collection|null $attributes = null, string $message = null): JsonResponse
    {
        return $this->response(Response::HTTP_NOT_FOUND, $attributes, $message ?? "Not Found");
    }

    /**
     * @param array|Collection|null $attributes
     * @param string|null $message
     * @return JsonResponse
     */
    public function responseInternalServerError(array|Collection|null $attributes = null, string $message = null): JsonResponse
    {
        return $this->response(Response::HTTP_INTERNAL_SERVER_ERROR, $attributes, $message ?? "Internal Server Error");
    }

    /**
     * @param int $statusCode
     * @param array|Collection|null $attributes
     * @param string $message
     * @return JsonResponse
     */
    public function response(int $statusCode, array|Collection|null $attributes, string $message): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $attributes
        ], $statusCode);
    }
}
