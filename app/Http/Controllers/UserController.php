<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Services\UserService;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    public function create(Request $request)
    {
        $validatedData = $request->only(['name', 'email','password']);

        $validator = Validator::make($validatedData, 
        [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ],
        [
            'name.required' => 'O campo name e obrigatório.',
            'email.required' => 'O campo email e obrigatório.',
            'email.email' => 'Por favor, insira um endereço de email válido.',
            'email.unique' => 'Este email já está em uso.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errorList' => $validator->errors()
            ], 417);
        }

        $user = $this->userService->create((object)$validatedData);

        if($user)
        {
            return response()->json(['message' => 'Usuario criado com sucesso'], 201);
        }
        return response()->json(['errorList' => 'Falha ao criar usuario'], 400);

    }

    public function login(Request $request)
    {
        $validatedData = $request->only('email', 'password');

        $validator = Validator::make($validatedData, 
        [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ],
        [
            'email.required' => 'O campo email e obrigatório.',
            'email.email' => 'Por favor, insira um endereço de email válido.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres.',
        ]);

        if ($validator->fails()) 
        {
            return response()->json([
                'errorList' => $validator->errors()
            ], 417);
        }

        $user = $this->userService->checkUserCredentials($validatedData['email'],$validatedData['password']);

        if(!$user)
        {
            return response()->json(['error' => 'Credenciais Invalidas'], 417);
        }

        $token = JWTAuth::fromUser($user);

        return response()->json(['token' => $token],200);
    }

}