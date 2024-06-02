<?php

class Model{

    private PDO $conn;

    public function __construct(Database $database)
    {

        $this->conn = $database->getConnection();

    }

    function signup(string $username, string $password): string
    {
        $randomBytes = random_bytes(32);

        // Encode the bytes in base64 format
        $base64Key = base64_encode($randomBytes);

        // $sql = "INSERT INTO user (username, password)
        // VALUES (:username, :password)";
        
        // $stmt = $this->conn->prepare($sql);

        // $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        // $stmt->bindParam(':password', $password, PDO::PARAM_STR);

        // $stmt->execute();
        return $username . $password;
    }

    function login(): string
    {
        return "";
    }
}