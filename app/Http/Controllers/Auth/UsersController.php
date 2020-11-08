<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangeRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Auth\UsersService;

class UsersController extends Controller
{
    private $usersService;

    public function __construct(UsersService $service)
    {
        $this->usersService = $service;
    }

    public function login(LoginRequest $request)
    {
        return self::response($this->usersService->login($request->validated()));
    }

    public function register(RegisterRequest $request)
    {
        return self::response($this->usersService->register($request->validated()));
    }

    public function change(ChangeRequest $request)
    {
        return self::response($this->usersService->change($request->validated(), $request->user()));
    }

    private static function response($response)
    {
        return response()->json($response['message'], $response['code']);
    }
}
