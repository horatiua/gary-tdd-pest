<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Http\Request;
use App\Http\Response;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class RequestHandler implements RequestHandlerInterface
{
    private array $middleware = [
        JwtAuthenticate::class,
        RouterDispatch::class
    ];

    public function __construct(
        private ContainerInterface $container
    )
    {
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function handle(Request $request): Response
    {
        // Check we have middleware
        if (empty($this->middleware)) {
            return new Response('A response cannot be sent.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // Retrieve next middleware in the array
        $middlewareClass = array_shift($this->middleware);

        // Instantiate Middleware class
        $middleware = $this->container->get($middlewareClass);

        // Call process on the middleware to obtain a response
        $response = $middleware->process($request, $this);

        // Return the response
        return $response;
    }

    public function setMiddleware(array $middleware): void
    {
        $this->middleware = $middleware;
    }
}