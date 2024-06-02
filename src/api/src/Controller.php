<?php

class Controller {
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

    function processResource(): void
    {

    }

    function processCollection(string $method): void
    {
        switch($method){

            case "GET":
                echo "GET";
                break;

            case "POST":
                $formData = (array)json_decode(file_get_contents("php://input"), true);
                $result = $this->Model->signup($formData['username'],$formData['password']);
                echo $result;
                http_response_code(200);
                break;
                
            default:
                http_response_code(405);
                header("Allow: GET, POST");
        }
    }

    function validation(): void
    {

    }
}