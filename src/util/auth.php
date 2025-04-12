<?php

namespace App\Util;

use DateTimeImmutable;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once 'vendor/autoload.php';

function getJWToken()
{
    $secretKey  = $_ENV['JWT_SECRET_KEY'];
    $issuedAt   = new DateTimeImmutable();
    $expire     = $issuedAt->modify('+60 minutes')->getTimestamp();
    $serverName = $_ENV['SERVER_NAME'];
    $username   = 'admin';

    $data = [
        'iat'  => $issuedAt->getTimestamp(),
        'iss'  => $serverName,
        'nbf'  => $issuedAt->getTimestamp(),
        'exp'  => $expire,
        'userName' => $username,
    ];

    return JWT::encode(
        $data,
        $secretKey,
        'HS512'
    );
}

function validateJWToken($jwt)
{
    $secretKey = $_ENV['JWT_SECRET_KEY'];

    try {
        JWT::decode($jwt, new Key($secretKey, 'HS512'));
        return true;
    } catch (\Exception $e) {
        echo "Token is invalid: " . $e->getMessage();
        return false;
    }
}
