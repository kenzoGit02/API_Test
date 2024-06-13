<?php
// api/router.php
$requestMethod = $_SERVER["REQUEST_METHOD"];

$requestUri = $_SERVER["REQUEST_URI"];

// Simple router logic
switch ($requestUri) {
    case '/jwt-login/src/api/':
        require 'post.php';
        break;
    // Add more routes here
    default:
        http_response_code(404);
        echo json_encode(["message" => "Endpoint not found"]);
        break;
}
?>