<?php

class Model{

    private PDO $conn;

    public function __construct(Database $database)
    {

        $this->conn = $database->getConnection();

    }

    function create(string $username, string $password): string|false
    {
        // $randomBytes = random_bytes(32);
        // Encode the bytes in base64 format
        // $base64Key = base64_encode($randomBytes);

        $sql = "INSERT INTO user (username, password, secret_key)
        VALUES (:username, :password ,:secret_key)";
        
        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(':username', $username ?? " ", PDO::PARAM_STR);
        $stmt->bindValue(':password', $password ?? " ", PDO::PARAM_STR);
        $stmt->bindValue(':secret_key', $key ?? " ", PDO::PARAM_STR);

        $stmt->execute();
        
        $result = $this->conn->lastInsertId();
    
        return $result ;
    }

    function get(array $formData): array
    {
        $sql = "SELECT * FROM user WHERE username = :username AND password = :password ";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(':username', $formData["username"], PDO::PARAM_STR);
        $stmt->bindValue(':password', $formData["password"], PDO::PARAM_STR);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        // $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    function update($formData): int
    {
        $sql = "UPDATE user
                SET username = :username, password = :password
                WHERE id = :id ";
        $stmt = $this->conn->prepare($sql);
        return 1;
    }
}