<?php

namespace App\Services;

use App\Repositories\FavoriteRepository;
use App\Interfaces\FavoriteRepositoryInterface;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FavoriteService
{
    // protected $favoriteRepository;

    public function __construct(protected FavoriteRepositoryInterface $favoriteRepository)
    {
        // $this->favoriteRepository = $favoriteRepository;
    }

    
    public function create($book_id)
    {
        return $this->favoriteRepository->create($book_id);
    }
    
    public function find($book_id)
    {
        $user = Auth::user();

        return $this->favoriteRepository->find($book_id,$user->id);
    }

    public function delete($book_id)
    {
        $user = Auth::user();

        $favorite = DB::table('favorite')
                        ->where('book_id', $book_id)
                        ->where('user_id', $user->id)
                        ->first();

        if (!$favorite) 
        {
            return false;
        }

        return $this->favoriteRepository->delete($book_id,$user->id);
    }
}
