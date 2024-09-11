<?php

namespace App\Services;

use App\Repositories\BookRepository;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use App\Services\favoriteService;
use App\Interfaces\BookRepositoryInterface;
use Illuminate\Support\Facades\DB;

class BookService
{
    protected $favoriteService;

    public function __construct(favoriteService $favoriteService,protected BookRepositoryInterface $bookRepository)
    {
        $this->favoriteService = $favoriteService;
    }

    public function getAllBooks()
    {
        return $this->bookRepository->getAllBooks();
    }

    public function find($id)
    {
        $user = Auth::user();

        return $this->bookRepository->find($id);
    }

    public function create($data)
    {
        $user = Auth::user();
        $data->user_id = $user->id;

        return $this->bookRepository->create($data);
    }

    public function update($id, $data)
    {
        $user = Auth::user();
        $book = $this->find($id);

        // verificação para ver se o usuario é dono do livro que está sendo atualizado
        if($book->user_id !== $user->id)
        {
            return false;
        }

        return $this->bookRepository->update($book, $data);
    }

    public function delete($id)
    {
        // criação do rollback para caso algum dos saves nao funcione , manter a consistência do banco.
        try{
            $user = Auth::user();
            $book = $this->find($id);
            // verificação para ver se o usuario é dono do livro que está sendo deletado
            if($book->user_id !== $user->id)
            {
                return false;
            }

            DB::beginTransaction();

            // delete de todas as agregações que possuem este book_id
            $favorite = DB::table('favorite')
                                ->where('book_id', $book->id)
                                ->get();

            if($favorite)
            {
                foreach($favorite AS $item)
                {
                    $deleteAgregate = $this->favoriteService->delete($book->id);
                }
            }

            if (!$this->bookRepository->delete($book)) 
            {
                throw new \Exception('Erro ao deletar o livro.');
            }

            DB::commit();
            return $book;

        }
        catch(\Exception $e)
        {
            DB::rollBack();
        }

    }
}
