<?php

use App\Entity\Author;
use App\Entity\Book;
use App\Repository\AuthorMapper;
use App\Repository\BookMapper;
use App\Repository\BookRepository;
uses(\App\Tests\ApiTestCase::class);

beforeEach(function () {
    $this->migrateTestDatabase();
});

it('returns the correct book data by ID', function () {
    // Arrange

    // Create an Author object
    $author = Author::create(
        id: null,
        name: 'A. N. Author',
        bio: 'This is an author'
    );

    // Instantiate an AuthorMapper
    $authorMapper = new AuthorMapper($this->connection);

    // Persist the $author
    $authorMapper->save($author);

    // Create a Book object
    $book = Book::create(
        id: null,
        title: 'A Test Book',
        yearPublished: 1999,
        author: $author
    );

    // Instantiate a BookMapper
    $bookMapper = new BookMapper($this->connection);

    // Persist the Book
    $bookMapper->save($book);

    $bookRepository = new BookRepository($this->connection);

    // Act
    $book = $bookRepository->findById($book->getId());

    // Assert
    expect($book)
        ->toMatchObject([
            'title' => 'A Test Book',
            'yearPublished' => 1999
        ])
        ->and($book->author)->toMatchObject([
            'name' => 'A. N. Author',
            'bio' => 'This is an author'
        ]);
})->group('integration');
