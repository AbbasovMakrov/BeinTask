<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function jsonResponse(array $response = [], int $statusCode = 200)
    {
        $response['status'] = $statusCode >= 200 && $statusCode <= 299;
        $response['validation_errors'] ??= null;
        $response['data'] ??= null;
        $response['message'] ??= "";
        return response()->json($response,$statusCode);
    }
}
