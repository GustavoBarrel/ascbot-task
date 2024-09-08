<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Book;
use App\Models\Favorite;
use App\Jobs\SendBookCreatedEmail;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookCreatedMail;
use App\Models\User;

class BookController
{

    public function index()
    {
        $books = Book::all();
        return response()->json($books);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        $validatedData = $request->only(['title', 'description','user_id']);


        $validator = Validator::make($validatedData, 
        [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'user_id' => 'required|integer|exists:users,id',
        ],
        [
            'title.required' => 'O campo title é obrigatório.',
            'title.string' => 'O campo title deve ser uma string.',
            'title.max' => 'O campo title não pode ter mais de 255 caracteres.',
            'description.required' => 'O campo description é obrigatório.',
            'description.string' => 'O campo description deve ser uma string.',
            'user_id.required' => 'O campo user_id é obrigatório.',
            'user_id.integer' => 'O campo user_id deve ser um número inteiro.',
            'user_id.exists' => 'O user_id fornecido não existe na tabela de usuários.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $book = Book::create($validatedData);
        $user = User::find($book->user_id);

        Mail::to($user->email)->send(new BookCreatedMail($book));

        return response()->json(['message' => 'Livro criado com sucesso'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Livro não encontrado'], 404);
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
            'user_id' => 'required|integer|exists:users,id',
        ],
        [
            'title.required' => 'O campo title é obrigatório.',
            'title.string' => 'O campo title deve ser uma string.',
            'title.max' => 'O campo title não pode ter mais de 255 caracteres.',
            'description.required' => 'O campo description é obrigatório.',
            'description.string' => 'O campo description deve ser uma string.',
            'user_id.required' => 'O campo user_id é obrigatório.',
            'user_id.integer' => 'O campo user_id deve ser um número inteiro.',
            'user_id.exists' => 'O user_id fornecido não existe na tabela de usuários.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Livro não encontrado'], 404);
        }

        $book->update($request->all());

        return response()->json(['message' => 'Livro atualizado com sucesso']);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Livro não encontrado'], 404);
        }

        $book->delete();

        return response()->json(['message' => 'Livro excluído com sucesso']);
    }
    
    public function favorite(Request $request)
    {
        $validatedData = $request->only(['user_id', 'book_id']);

        $validator = Validator::make($validatedData, 
        [
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
        ],
        [
            'book_id.required' => 'O campo book_id é obrigatório.',
            'book_id.exists' => 'O ID do livro fornecido não existe na tabela de livros.',
            'user_id.required' => 'O campo user_id é obrigatório.',
            'user_id.exists' => 'O ID do usuario fornecido nao existe na tabela de usuários.',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        $favorite = Favorite::where('user_id', $request->user_id)
                            ->where('book_id', $request->book_id)
                            ->first();
        if ($favorite) 
        {
            $favorite->delete();
            return response()->json(['message' => 'Livro removido dos favoritos com sucesso']);
        } 
        else 
        {
            Favorite::create([
                'user_id' => $request->input('user_id'),
                'book_id' => $request->input('book_id'),
            ]);
            return response()->json(['message' => 'Livro adicionado aos favoritos com sucesso'], 201);
        }
    }
}
