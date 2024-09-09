<?php

namespace App\Interfaces;

interface FavoriteRepositoryInterface
{
    public function create(object $book);

    public function delete(int $book_id,int $user_id);
    
    public function find(int $book_id,int $user_id);

}
