<?php

use App\Entity\Author;
use App\Entity\Book;
use App\Repository\AuthorMapper;
use App\Repository\BookMapper;

uses(\App\Tests\ApiTestCase::class);

beforeEach(function () {
    $this->migrateTestDatabase();
});

it('saves a Book to the database', function () {
    // Arrange
    $author = Author::create(
        id: null,
        name: 'Alan Turing',
        bio: 'A math genius'
    );
    $authorMapper = new AuthorMapper($this->connection);
    $authorMapper->save($author);

    $book = Book::create(
        id: null,
        title: 'Test book',
        yearPublished: 1999,
        author: $author
    );
    $bookMapper = new BookMapper($this->connection);

    // Act
    $bookMapper->save($book);

    // Assert
    // Assert that it is in the database
    $this->assertDatabaseHas('books', [
        'title' => 'Test book',
        'year_published' => 1999,
        'author_id' => $author->getId()
    ]);
})->group('integration');