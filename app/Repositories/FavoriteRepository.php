<?php

namespace App\Repositories;

use App\Models\Favorite;
use Illuminate\Database\Eloquent\Collection;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Interfaces\FavoriteRepositoryInterface;


class FavoriteRepository implements FavoriteRepositoryInterface
{

    public function create($book_id)
    {

        $user = Auth::user();

        $favorite = new Favorite();
        $favorite->user_id = $user->id;
        $favorite->book_id = $book_id;

        if($favorite->save())
        {
            return $favorite;
        }
        return false;

    }

    public function find($book_id,$user_id)
    {
        // nesta regra de negocio nao tem como existir mais de 1 favorite por isso nao usei o get.
        // so retorna livros que são vinculados ao proprio usuario
        return $favorite = DB::table('favorite')
                               ->where('book_id', $book_id)
                               ->where('user_id', $user_id)
                               ->first();
    }

    public function delete($book_id,$user_id)
    {
    return DB::table('favorite')
                            ->where('book_id', $book_id)
                            ->where('user_id', $user_id)
                            ->delete();
    }

}
