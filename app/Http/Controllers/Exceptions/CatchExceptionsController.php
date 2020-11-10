<?php

namespace App\Http\Controllers\Exceptions;

use App\Http\Controllers\Controller;

class CatchExceptionsController extends Controller
{
    public function catchException()
    {
        switch (\Route::currentRouteName())
        {
            case 'login':
                return self::response([
                    'message' => "User isn't authorized",
                    'code' => 401
                ]);
            case 'verification.notice':
                return self::response([
                    'message' => "Email isn't verificated",
                    'code' => 403
                ]);
            case 'unverification.notice':
                return self::response([
                    'message' => "Email isn't verificated",
                    'code' => 403
                ]);
            case 'verification.verify':
                return self::response([
                    'message' => null,
                    'code' => 200
                ]);
        }
    }
}
