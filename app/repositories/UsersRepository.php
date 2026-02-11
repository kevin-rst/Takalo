<?php

namespace app\repositories;

use PDO;

class UsersRepository
{
    private $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function emailExists($email)
    {
        $query = "SELECT 1 FROM takalo_users WHERE email = ? LIMIT 1";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([(string)$email]);

        return (bool)$stmt->fetchColumn();
    }

    public function create($nom, $email, $hash, $role)
    {
        $query = "INSERT INTO takalo_users (username, email, password_hash, id_role) VALUES (?, ?, ?, ?)";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$nom, $email, $hash, $role]);
        
        return $this->pdo->lastInsertId();
    }

    public function getUser($nom)
    {
        $query = "SELECT * FROM takalo_users WHERE username = ? LIMIT 1";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([(string)$nom]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
