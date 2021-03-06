<?php

namespace App\Services\Auth;

use App\Models\Auth\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\QueryException;

class UsersService
{
    public function login(array $request)
    {
        $user = User::where('username', '=', $request['username'])->first();
        if (isset($user)) {
            if (\Hash::check($request['password'], $user->password)) {
                return [
                    'message' => array_merge(
                        $user->toarray(),
                        ['token' => $user->createToken($request['username'])->plainTextToken]),
                    'code' => 200
                ];
            }

            return [
                'message' => 'Password is incorrect',
                'code' => 400
            ];
        }

        return [
            'message' => "User doesn't exist",
            'code' => 404
        ];
    }

    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();

        return [
            'message' => null,
            'code' => 200
        ];
    }

    public function register(array $request)
    {
        try {
            $request['password'] = \Hash::make($request['password']);
            $user = User::create($request);
            event(new Registered($user));
            return [
                'message' => array_merge(
                    $user->toarray(),
                    ['token' => $user->createToken($request['username'])->plainTextToken]),
                'code' => 201
            ];
        } catch (QueryException $exception) {
            return [
                'message' => 'User already exists',
                'code' => 400
            ];
        }
    }

    public function change(array $request, User $user)
    {
        if (isset($request['email'])) {
            $user->email = $request['email'];
            $user->email_verified_at = null;
            $user->sendEmailVerificationNotification();
        }

        if (isset($request['password'])) {
            $user->password = \Hash::make($request['password']);
        }

        $user->save();

        return [
            'message' => $user,
            'code' => 200
        ];
    }

    public function get()
    {
        return [
            'message' => auth()->user(),
            'code' => 200
        ];
    }

    public function verify()
    {
        return [
            'message' => 'Verification is successful complete',
            'code' => 200
        ];
    }

    public function verifyReSend()
    {
        auth()->user()->sendEmailVerificationNotification();

        return [
            'message' => 'Verification email has been sent on your email',
            'code' => 200
        ];
    }
}
