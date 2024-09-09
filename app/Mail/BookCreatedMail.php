<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $book;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($book)
    {
        $this->book = $book;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.book_created')
                    ->subject('Livro Criado Com Sucesso')
                    ->with([
                        'bookTitle' => $this->book->title,
                        'bookDescription' => $this->book->description,
                    ]);
    }
}
