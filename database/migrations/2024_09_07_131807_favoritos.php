<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('favorite', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('book_id');


            $table->foreign('user_id')
                    ->references('id')
                    ->on('users');
            $table->foreign('book_id')
                    ->references('id')
                    ->on('books');
        });    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
