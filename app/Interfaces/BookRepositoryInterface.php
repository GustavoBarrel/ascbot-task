<?php

namespace App\Interfaces;

interface BookRepositoryInterface
{
    public function create(object $book);

    public function delete(int $id);

    public function find(int $id);

    public function getAllBooks();

    public function update(object $book,object $data);
}
