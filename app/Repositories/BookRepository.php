<?php

namespace App\Repositories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Interfaces\BookRepositoryInterface;


class BookRepository implements BookRepositoryInterface
{

    public function getAllBooks()
    {
        return Book::all();
    }

    public function find($id)
    {
        return Book::find($id);
    }

    public function create($book_data)
    {
        return Book::create((array) $book_data);
    }

    public function update($book, $book_data)
    {
        return $book->update((array) $book_data);
    }

    public function delete($book)
    {
        
        return $book->delete();
    }
}
