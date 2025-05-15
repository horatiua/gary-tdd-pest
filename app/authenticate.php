<?php

// Get Firebase JWT

// Auto-loading
require 'vendor/autoload.php';

// Container
$container = require 'config/services.php';

// Obtain username and password
$username = $argv[1];
$password = $argv[2];

// PDO
$pdo = $container->get(\App\Database\Connection::class)->getPdo();

// Prepare statement
$statement = $pdo->prepare('
    SELECT password, plan
    FROM users
    WHERE username = ?
');

// Execute statement + fetch
$statement->execute([$username]);
$user = $statement->fetch();

// Verify password
$authenticated = password_verify($password, $user['password']);

// Exit if not authenticated
if (!$authenticated) {
    die('Auth failed');
}

// Generate a key (add .env and container at the end of the lesson)
$key = $_ENV['JWT_SECRET_KEY'];

// Create issued at
$issuedAt = time();

// Create payload
$payload = [
    'iss' => '',
    'aud' => '',
    'iat' => $issuedAt,
    'nbf' => $issuedAt,
    'data' => [
        'username' => $username,
        'plan' => $user['plan']
    ]
];

// JWT::encode
// (this will json encode payload then base64urlencoded header + payload and sing using secret key)
$jwt = \Firebase\JWT\JWT::encode($payload, $key, 'HS256');

// Return the JWT to the client
echo $jwt;
