<?php
// api/post.php
require 'Database.php';

switch ($requestMethod) {
    case 'GET':
        getPosts();
        break;
    case 'POST':
        createPost();
        break;
    case 'PUT':
        updatePost();
        break;
    case 'DELETE':
        deletePost();
        break;
    default:
        http_response_code(405);
        echo json_encode(["message" => "Method not allowed"]);
        break;
}

function getPosts() {
    // Fetch posts from database or data source
    $pdo = new Database('localhost','jwt_login','root','');

    $conn = $pdo->getConnection();

    $sql = "SELECT * FROM user";

    $stmt = $conn->prepare($sql);

    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($results);
}

function createPost() {
    $data = json_decode(file_get_contents("php://input"), true);
    if (isset($data["username"]) && isset($data["password"])) {
        
        $pdo = new Database('localhost','jwt_login','root','');
        $conn = $pdo->getConnection();

        $sql = "INSERT INTO user(username, password, secret_key) VALUES(:username, :password, :secret_key)";
        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':username', $data["username"] ?? " ", PDO::PARAM_STR);
        $stmt->bindValue(':password', $data["password"] ?? " ", PDO::PARAM_STR);
        $stmt->bindValue(':secret_key', $data["key"] ?? " ", PDO::PARAM_STR);
        $stmt->execute();

        if($conn->lastInsertId()){
            echo json_encode(["message" => "Post created", "data" => $data]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Invalid input"]);
    }
}

function updatePost() {
    $data = json_decode(file_get_contents("php://input"), true);
    // echo json_encode($data);
    // return;
    try{
        if (isset($data["id"]) && isset($data["username"]) && isset($data["password"])) {

            $pdo = new Database('localhost','jwt_login','root','');
            $conn = $pdo->getConnection();
    
            $sql = "UPDATE user
                    SET username = :username, password = :password
                    WHERE id = :id ";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':id', $data["id"] ?? " ", PDO::PARAM_INT);
            $stmt->bindValue(':username', $data["username"] ?? " ", PDO::PARAM_STR);
            $stmt->bindValue(':password', $data["password"] ?? " ", PDO::PARAM_STR);
            
            $stmt->execute();
    
            if($stmt->rowCount()){
                echo json_encode(["message" => "Post updated", "data" => $data]);
            } else {
                echo json_encode(["message" => "No rows were affected", "id" => $data["id"]]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Invalid input"]);
        }
    } catch(Error $e){
        echo json_encode(["Error" => $e]);
    }
}

function deletePost() {
    $data = json_decode(file_get_contents("php://input"), true);
    try{
        if (isset($data["id"])) {
            $pdo = new Database('localhost','jwt_login','root','');
            $conn = $pdo->getConnection();
    
            $sql = "DELETE FROM user WHERE id = :id";
            $stmt = $conn->prepare($sql);
    
            $stmt->bindValue(':id', $data["id"] ?? " ", PDO::PARAM_STR);
            $stmt->execute();
            if($stmt->rowCount()){
                echo json_encode(["message" => "Post deleted", "id" => $data["id"]]);
            }else{
                echo json_encode(["message" => "No rows were affected", "id" => $data["id"]]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Invalid input id"]);
        }
    }catch(Error $e){
        echo json_encode(["Error" => $e]);
    }
}
?>