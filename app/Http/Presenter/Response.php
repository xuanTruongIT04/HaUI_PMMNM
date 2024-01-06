<?php

namespace App\Http\Presenter;

use App\Util\Pagination;
use Illuminate\Http\JsonResponse;

class Response
{
    public static function BaseResponse(int $statusCode, string $message, mixed $results): JsonResponse
    {
        $response = [
            'status' => strval($statusCode),
            'message' => $message,
            'results' => $results,
        ];

        return response()->json($response, $statusCode);
    }

    public static function responseDoesNotData(int $statusCode, string $message): JsonResponse
    {
        $response = [
            'status' => strval($statusCode),
            'message' => $message,
        ];

        return response()->json($response, $statusCode);
    }

    public static function convertListDataWithPagingPresenter(Pagination $pagination, mixed $data)
    {
        $dataPaging = [
            'count' => $pagination->getRecordCount(),
            'numPages' => ceil($pagination->getRecordCount() / $pagination->getPageSize()),
            'displayRecord' => $pagination->getDisplayRecord(),
            'page' => $pagination->getPage(),
        ];

        return [
            'data' => $data,
            'pagination' => $dataPaging,
        ];
    }

    public static function ResponseWithPagination(int $statusCode, string $message, mixed $results)
    {
        $response = [
            'status' => strval($statusCode),
            'message' => $message,
            'results' => $results['data'],
            'pagination' => $results['pagination'],
        ];
    }

    public static function responseError($message, $code)
    {
        return response()->json([
            'status' => $code,
            'success' => false,
            'message' => $message,
        ]);
    }
}
