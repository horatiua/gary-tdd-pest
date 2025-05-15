<?php

use App\Http\JsonResponse;
use App\Http\Response;

test('a Response object can be created', function() {
    // Arrange

    // Act
    $response = new Response('{"foo":"bar"}', 200);

    // Assert
    expect($response->getStatusCode())
        ->toBeInt()
        ->toBe(200)
        ->and($response->getBody())
        ->toMatchJson(['foo' => 'bar']);
});

test('a JsonResponse can be created from an object or and array', function ($body) {
    // Arrange
    $response = new JsonResponse($body, Response::HTTP_OK);

    // Act

    // Assert
    expect($response->getHeaders())
        ->toMatchArray([
            'Content-Type' => 'application/json'
        ])
        ->and($response->getBody())
        ->toMatchJson(['foo' => 'bar']);
})->with([
    'object' => [
        new class {
            public string $foo = 'bar';
        }
    ],
    'array' => [
        ['foo' => 'bar']
    ]
]);
