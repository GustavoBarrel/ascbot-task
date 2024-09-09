<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Book;
use App\Models\Favorite;
use App\Models\User;
use App\Jobs\SendBookCreatedEmail;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookCreatedMail;
use Illuminate\Support\Facades\Auth;
use App\Services\BookService;
use App\Services\favoriteService;

class BookController
{

    protected $bookService;
    protected $favoriteService;

    public function __construct(BookService $bookService,FavoriteService $favoriteService)
    {
        $this->bookService = $bookService;
        $this->favoriteService = $favoriteService;

    }


    public function index()
    {
        $books = $this->bookService->getAllBooks();

        return response()->json($books);
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        
        $validatedData = $request->only(['title', 'description']);

        $validator = Validator::make($validatedData, 
        [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ],
        [
            'title.required' => 'O campo title e obrigatório.',
            'title.string' => 'O campo title deve ser uma string.',
            'title.max' => 'O campo title não pode ter mais de 255 caracteres.',
            'description.required' => 'O campo description e obrigatório.',
            'description.string' => 'O campo description deve ser uma string.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errorList' => $validator->errors()
            ], 417);
        }

        (object)$book = $this->bookService->create((object)$validatedData);

        if(!$book)
        {
            return response()->json(['errorList' => 'Falha ao criar livro'], 400);
        }

        $user = User::find($book->user_id);

        Mail::to($user->email)->send(new BookCreatedMail($book));
    

        return response()->json(['message' => 'Livro criado com sucesso'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = $this->bookService->find($id);

        if (!$book) {
            return response()->json(['errorList' => 'Livro não encontrado'], 404);
        }

        return response()->json($book);
    }


    public function update(Request $request, string $id)
    {
        $validatedData = $request->only(['title', 'description','user_id']);

        $validator = Validator::make($validatedData, 
        [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ],
        [
            'title.required' => 'O campo title e obrigatório.',
            'title.string' => 'O campo title deve ser uma string.',
            'title.max' => 'O campo title não pode ter mais de 255 caracteres.',
            'description.required' => 'O campo description e obrigatório.',
            'description.string' => 'O campo description deve ser uma string.',
        ]);

        if ($validator->fails()) 
        {
            return response()->json([
                'message' => $validator->errors()
            ], 417);
        }

        $book = $this->bookService->find($id);

        if (!$book) {
            return response()->json(['message' => 'Livro não encontrado'], 403);
        }

        $book = $this->bookService->update($id,(object)$validatedData);

        if(!$book)
        {
            return response()->json(['message' => 'Não é possivel atualizar um livro de outro usuario.'], 404);
        }

        return response()->json(['message' => 'Livro atualizado com sucesso'],200);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = $this->bookService->find($id);

        if (!$book) 
        {
            return response()->json(['message' => 'Livro não encontrado'], 404);
        }

        $deletedBook = $this->bookService->delete($id);

        if(!$deletedBook)
        {
            return response()->json(['message' => 'Falha ao excluir livro',404]);
        }

        return response()->json(['message' => 'Livro excluído com sucesso'],200);

    }
    
    public function favorite(Request $request)
    {
        $validatedData = $request->only(['book_id']);

        $validator = Validator::make($validatedData, 
        [
            'book_id' => 'required|integer|exists:books,id',
        ],
        [
            'book_id.required' => 'O campo book_id é obrigatório.',
            'book_id.integer' => 'O campo book_id deve ser um inteiro.',
            'book_id.exists' => 'O ID do livro fornecido não existe na tabela de livros.',
        ]);

        if ($validator->fails()) 
        {
            return response()->json(['message' => $validator->errors()], 417);
        }


        $favorite = $this->favoriteService->find($validatedData['book_id']);

        if($favorite) 
        {
            $favorite = $this->favoriteService->delete($validatedData['book_id']);

            return response()->json(['message' => 'Livro removido dos favoritos com sucesso']);
        } 

        $favoriteCreate = $this->favoriteService->create($validatedData['book_id']);

        if($favoriteCreate)
        {
            return response()->json(['message' => 'Livro adicionado aos favoritos com sucesso'], 201);
        }
        // so nao salva se der erro no servidor.
        return response()->json(['message' => 'Falha ao registrar favorito.'], 400);
        
    }
}
