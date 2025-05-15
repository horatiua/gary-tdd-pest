<?php

use App\Http\Middleware\RequestHandler;
use App\Http\Request;
use App\Http\Response;
use App\Tests\Unit\Http\Middleware\SuccessMiddleware;

uses(\App\Tests\ApiTestCase::class);

it('RequestHandler returns a correct Response', function () {
    // Arrange
    $request = Request::create('GET', '/some/uri');
    $requestHandler = new RequestHandler($this->container);
    $requestHandler->setMiddleware([SuccessMiddleware::class]);

    // Act
    $response = $requestHandler->handle($request);

    // Assert
    expect($response)
        ->toBeInstanceOf(Response::class)
        ->and($response->getStatusCode())
        ->toBe(Response::HTTP_OK);
});
