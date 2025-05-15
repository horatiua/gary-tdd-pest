<?php

use App\Entity\Author;
use App\Entity\Book;
use App\Http\JsonResponse;
use App\Repository\AuthorMapper;
use App\Repository\BookMapper;

beforeEach(function () {
    $this->migrateTestDatabase();
});

it(
    'retrieve the correct book data from the books API',
    function (string $uri, array $bookData, array $authorData) {
        // Arrange
        $key = $this->container->get('jwtSecretKey');

        $issuedAt = time();
        $payload = [
            'iss' => '',
            'aud' => '',
            'iat' => $issuedAt,
            'nbf' => $issuedAt,
            'exp' => $issuedAt + (60 * 60),
            'data' => [
                'username' => 'user',
                'plan' => 'paid'
            ]
        ];
        $jwt = \Firebase\JWT\JWT::encode($payload, $key, 'HS256');

        // Data fixtures
        // Create Author object
        $author = Author::create(
            id: $authorData['id'],
            name: $authorData['name'],
            bio: $authorData['bio']
        );

        // AuthorMapper
        $authorMapper = new AuthorMapper($this->connection);

        // Save Author
        $authorMapper->save($author);

        // Create Book object
        $book = Book::create(
            id: $bookData['id'],
            title: $bookData['title'],
            yearPublished: $bookData['yearPublished'],
            author: $author
        );

        // BookMapper
        $bookMapper = new BookMapper($this->connection);

        // Save Book
        $bookMapper->save($book);

        // Act
        $response = $this->json(method: 'GET', uri: $uri, headers: ['HTTP_AUTHORIZATION' => $jwt]);

        // Assert
        expect($response->getStatusCode())
            ->toBeInt()
            ->toBe(200)
            ->and($response->getBody())
            ->toMatchJson([
                'id' => $bookData['id'],
                'title' => $bookData['title'],
                'yearPublished' => $bookData['yearPublished'],
                'author' => $authorData
            ])
            ->and($response)
            ->toBeInstanceOf(JsonResponse::class)
            ->and($response->getHeaders())
            ->toMatchArray([
                'Content-Type' => 'application/json'
            ]);
    }
)->with([
    'book 1' => [
        '/books/1',
        [
            'id' => 1,
            'title' => 'Clean Code: A Handbook of Agile Software Craftsmanship',
            'yearPublished' => 2008
        ],
        [
            'id' => 1,
            'name' => 'Robert C. Martin',
            'bio' => 'This is an author'
        ]
    ],
    'book 2' => [
        '/books/2',
        [
            'id' => 2,
            'title' => 'Refactoring: Improving the Design of Existing Code',
            'yearPublished' => 1999
        ],
        [
            'id' => 2,
            'name' => 'Martin Fowler',
            'bio' => 'Martin\'s bio'
        ]
    ]
])->group('integration');
