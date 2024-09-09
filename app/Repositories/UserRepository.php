<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{

    public function create($user_data)
    {
        $user = new User;
        $user->name = $user_data->name;
        $user->email = $user_data->email;
        $user->password = Hash::make($user_data->password);

        if($user->save())
        {
            return $user;
        }
        
        return false;
    }

    public function checkUserCredentials($email,$password)
    {
        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) 
        {
            // return response()->json(['error' => 'Credenciais Invalidas'], 417);
            return false;
        }
        return $user;
    }

}
