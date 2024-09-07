<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\BookCreatedMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendBookCreatedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $book;

    /**
     * Create a new job instance.
     */
    public function __construct($book)
    {
        $this->book = $book;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $user = User::find($this->book->user_id);
        Mail::to($user->email)->send(new BookCreatedMail($this->book));
    }
}
