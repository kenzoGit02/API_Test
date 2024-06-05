<?php







spl_autoload_register(fn($class) => require __DIR__ . "/src/$class.php");

set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST , DELETE, PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-type: application/json; charset=UTF-8");



use Firebase\JWT\JWT;


$payload = [
    'iss' => 'localhost', //issuer(who created and signed this token)
    'iat' => time(),//issued at
    'exp' => strtotime("+1 hour"),//expiration time
];

$encode = JWT::encode($payload, "CI6IkpXVCJ9", 'HS256');

$response = ["response" => "$encode"];

echo json_encode($response);

return;



// Splits the request URI into an array of segments
$url = explode("/", $_SERVER["REQUEST_URI"]);

// Ensure the route index exists to avoid undefined index errors
// $route = isset($url[4]) ? $url[4] : '';

$route = $url[4]; // Assigns the fifth segment of the URL to $route

if ($route != "user") { //Restricts route to only login or signup
    http_response_code(404);
    exit;
}


$id = $url[5] ?? null; //Checks if id has value

$pdo = new Database('localhost','jwt_login','root','');

$model = new Model($pdo);

$controller = new Controller($model);

$controller->processRequest($_SERVER['REQUEST_METHOD'], $id);

// print_r($_SERVER['REQUEST_METHOD']);
