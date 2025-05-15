<?php

use App\Http\Middleware\JwtAuthenticate;

test('JWT authenticate produces the correct response', function () {
    /* Arrange */
    // Request
    $request = \App\Http\Request::create(
        'GET',
        '/some/path',
        ['HTTP_AUTHORIZATION' => 'Bearer some.fake.token']
    );

    // Middleware
    $jwtAuth = new JwtAuthenticate('some-secret-key');

    // RequestHandlerInterface
    $requestHandler = Mockery::mock(\App\Http\Middleware\RequestHandler::class);

    /* Act */
    // Middleware process()
    $response = $jwtAuth->process($request, $requestHandler);

    /* Assert */
    // Expect 401 response
    // Invalid token header
    expect($response)
        ->toBeInstanceOf(\App\Http\Response::class)
        ->and($response->getStatusCode())
        ->toBe(401)
        ->and($response->getHeaders()['WWW-Authenticate'])
        ->toBe('Bearer error="invalid_token"');
});
