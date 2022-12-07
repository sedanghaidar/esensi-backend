<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private function responseJson($success, $statusCode, $message, $result)
    {
        $data =  array(
            'success' => $success,
            'code' => $statusCode,
            'message' => $message,
            'result' => $result
        );

        return response()->json($data, $statusCode);
    }

    public function success($message, $data)
    {
        return $this->responseJson(true, 200, $message, $data);
    }

    public function error($message)
    {
        return $this->responseJson(false, 400, $message, null);
    }

    public function unauthorized($message)
    {
        return $this->responseJson(false, 401, $message, null);
    }

    public function invalidation($message)
    {
        return $this->responseJson(false, 400, $message, null);
    }
}
