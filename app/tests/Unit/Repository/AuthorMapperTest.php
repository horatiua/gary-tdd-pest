<?php


use App\Entity\Author;
use App\Repository\AuthorMapper;

uses(\App\Tests\ApiTestCase::class);

beforeEach(function () {
    $this->migrateTestDatabase();
});

it('saves an Author to the database', function () {
    // Arrange
    // Create Author and AuthorMapper objects
    $author = Author::create(
        id: null,
        name: 'Alan Turing',
        bio: 'A math genius'
    );
    $authorMapper = new AuthorMapper($this->connection);

    // Act
    // Save the authors
    $authorMapper->save($author);

    // Assert
    // Assert that it is in the database
    $this->assertDatabaseHas('authors', [
        'name' => 'Alan Turing',
        'bio' => 'A math genius'
    ]);
})->group('integration');