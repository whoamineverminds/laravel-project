<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangeRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Auth\UsersService;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

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

    public function logout()
    {
        return self::response($this->usersService->logout());
    }

    public function register(RegisterRequest $request)
    {
        return self::response($this->usersService->register($request->validated()));
    }

    public function get()
    {
        return self::response($this->usersService->get());
    }

    public function change(ChangeRequest $request)
    {
        return self::response($this->usersService->change($request->validated(), $request->user()));
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return self::response($this->usersService->verify());
    }

    public function verifyReSend()
    {
        return self::response($this->usersService->verifyReSend());
    }
}
