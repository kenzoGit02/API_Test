<?php

spl_autoload_register(fn($class) => require __DIR__ . "/src/$class.php");

set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");

header("Content-type: application/json; charset=UTF-8");

require '../../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\KEY;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$jwtSecret = $_ENV['JWT_SECRET'];
// echo $jwtSecret;

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
// print_r($decode);

// Splits the request URI into an array of segments
$url = explode("/", $_SERVER["REQUEST_URI"]);

// Ensure the route index exists to avoid undefined index errors
// $route = isset($url[4]) ? $url[4] : '';

$route = $url[4]; // Assigns the fifth segment of the URL to $route

if ($route != "signup" && $route != "login") { //Restricts route to only login or signup
    http_response_code(404);
    exit;
}

$id = $url[5] ?? null; //Checks if id has value

$pdo = new Database('localhost','jwt_login','root','');

$model = new Model($pdo);

$controller = new Controller($model);

$controller->processRequest($_SERVER['REQUEST_METHOD'], $id);

// print_r($_SERVER['REQUEST_METHOD']);
