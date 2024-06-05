<?php

require '../../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\KEY;
use Firebase\JWT\ExpiredException;

class Controller {
    
    private $key = "CI6IkpXVCJ9";

    function __construct(private Model $Model)
    {
        
    }
    function processRequest(string $method, ?string $id): void
    {
        if($id){
            $this->processResource($method, $id);
        } else {
            $this->processCollection($method);
        }
    }

    function processResource($method, $id): void
    {
        switch($method){
            case "PUT":
                $key = "CI6IkpXVCJ9";

                $header = apache_request_headers();

                if($header["Authorization"]){
                    $bearerToken = $header['Authorization'];

                    $parts = explode(' ', $bearerToken);

                    // Select the second part, which represents the token
                    $token = $parts[1];

                    try{
                        $decoded = JWT::decode($token, new Key($key,'HS256'));

                        // If decoding is successful and no exception is thrown, the token is valid
                        echo json_encode(["message" => "Token is still valid."]);
                        
                        // Print the decoded payload for debugging
                        print_r($decoded);
                    } catch (ExpiredException $e) {
                        // Handle token expiration specifically
                        echo json_encode(["Token has expired" => $e->getMessage()]);
                    } catch (Exception $e) {
                        // Handle other decoding errors
                        echo json_encode(["Caught exception" => $e->getMessage()]);
                    }
                }

                break;

            default:
                http_response_code(405);
                header("Allow: PUT");
        }
    }

    function processCollection(string $method): void
    {
        switch($method){

            case "POST":
                $formData = (array)json_decode(file_get_contents("php://input"), true);

                $result = $this->Model->get($formData);
                
                $response = [];

                if(!$result){
                    $response = ["hasRow" => false];
                    echo json_encode($response);
                    break;
                }

                $response = ["hasRow" => true];

                $id = $result["id"];
                
                $payload = [
                    'iss' => 'kenzo', //issuer(who created and signed this token)
                    'iat' => time(),//issued at
                    'exp' => strtotime("+1 hour"),//expiration time
                    'id' => $id
                ];

                $encode = JWT::encode($payload, $this->key, 'HS256');

                $response["data"] = $result;
                $response["key"] = $encode;

                echo json_encode($response);
                // echo json_encode(["response" => $_SERVER['HTTP_ORIGIN']]);

                http_response_code(200);

                break;

            case "GET":
                $formData = (array)json_decode(file_get_contents("php://input"), true);
                    
                $result = $this->Model->create($formData['username'],$formData['password']);

                $payload = [
                    'iss' => 'localhost', //issuer(who created and signed this token)
                    'iat' => time(),//issued at
                    'exp' => strtotime("+1 hour"),//expiration time
                    'id' => $result
                ];
                
                $encode = JWT::encode($payload, $this->key, 'HS256');

                $response = ["response" => "$encode"];

                echo json_encode($response);

                http_response_code(200);

                break;
            default:
                http_response_code(405);
                header("Allow: GET, POST, PUT");
        }
    }

    function validation(): void
    {

    }
    function renewToken(){

    }
}