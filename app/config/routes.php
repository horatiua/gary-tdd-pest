<?php

use App\Controller\BooksController;

$routes = [
    [
        'GET',
        '/books/{id:\d+}',
        [BooksController::class, 'show']
    ]
];

return $routes;