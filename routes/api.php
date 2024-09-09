    <?php
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\BookController;
    use App\Jobs\SendBookCreatedEmail;
    use App\Mail\BookCreatedMail;

    use App\Models\Book;

    Route::post('/user', [UserController::class,'create']);
    Route::post('/login', [UserController::class, 'login']);

    Route::middleware('auth:api')->group(function () 
    {
        Route::resource('/book', BookController::class);
        Route::post('/favorite', [BookController::class, 'favorite']);
    });