<?php

require '../../vendor/autoload.php';

use Firebase\JWT\JWT;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$jwtSecret = $_ENV['JWT_SECRET'];
echo $jwtSecret;

$payload = array(
    'iss' => 'sharmacoder',
    'iat' => time(),
    'exp' => strtotime("+1 hour"),
    'email' => "sharma@gmail.com"
);

$jwt = JWT::encode($payload, $jwtSecret, 'HS256');

echo $jwt;

$url = explode("/",$_SERVER["REQUEST_URI"]);
// foreach ($url as $k){
//     echo $k;
// }
// var_dump($url);


