<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(Request $request): JsonResponse
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            return $this->success('Login realizado com sucesso!', 200, [
                'token' => Auth::user()->createToken('invoice', [
                    'invoice-store', 'invoice-update', 'invoice-destroy'
                ])->plainTextToken
            ]);
        }
        return $this->error('Email ou senha inválidos!', 401);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return $this->success('Logout realizado com sucesso!', 200);
    }
}
