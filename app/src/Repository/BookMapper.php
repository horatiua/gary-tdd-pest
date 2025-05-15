<?php

declare(strict_types=1);

namespace App\Repository;

use App\Database\Connection;
use App\Entity\Book;

class BookMapper
{
    public function __construct(private Connection $connection)
    {
    }

    public function save(Book $book): void
    {
        // Prepare the statement
        $statement = $this->connection->getPdo()->prepare('
            INSERT INTO books (id, title, year_published, author_id)
            VALUES (:id, :title, :year_published, :author_id)
        ');

        // Bind the value
        $statement->bindValue(':id', $book->getId());
        $statement->bindValue(':title', $book->title);
        $statement->bindValue(':year_published', $book->yearPublished);
        $statement->bindValue(':author_id', $book->author->getId());

        // Execute
        $statement->execute();

        // Set the book id
        $lastInsertedId = (int)$this->connection->getPdo()->lastInsertId();

        $book->setId($lastInsertedId);
    }
}