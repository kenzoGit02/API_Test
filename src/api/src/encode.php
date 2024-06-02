<?php

require '../../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\KEY;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$jwtSecret = $_ENV['JWT_SECRET'];

$payload = array(
    'iss' => 'localhost', //issuer(who created and signed this token)
    'aud' => 'localhost', //issuer(who created and signed this token)
    'iat' => time(),//issued at
    'exp' => strtotime("+1 hour"),//expiration time
    'email' => "test@gmail.com",
    'array' => array(
        'test1' => "dummy data1",
        'test2' => "dummy data2",
        'test3' => "dummy data3"
    )
);

$encode = JWT::encode($payload, $jwtSecret, 'HS256');


// echo $encode;