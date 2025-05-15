<?php

use App\Http\Request;

it('creates a correctly formatted GET Request object', function () {
    // Arrange
    $request = Request::create(
        'GET',
        '/some/path?black=white&day=night',
        [
            'CONTENT_TYPE' => 'application/json',
            'Accept' => 'application/json'
        ],
        ''
    );

    // Act

    // Assert
    expect($request->getQueryParams())
        ->toMatchArray(['black' => 'white', 'day' => 'night'])
        ->and($request->getPath())
        ->toBe('/some/path')
        ->and($request->getMethod())
        ->toBe('GET');
});