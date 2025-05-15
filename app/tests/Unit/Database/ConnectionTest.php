<?php

use App\Database\Connection;
uses(\App\Tests\ApiTestCase::class);

it('returns a valid PDO instance', function () {
    // Arrange
    $connection = new Connection(
        "mysql:host=db;dbname={$_ENV['MYSQL_DATABASE']};charset=utf8mb4",
        $_ENV['MYSQL_USER'],
        $_ENV['MYSQL_PASSWORD']
    );

    // Act
    $pdo = $connection->getPdo();

    // Assert
    expect($pdo)->toBeInstanceOf(PDO::class);
});
