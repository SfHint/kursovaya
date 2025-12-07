<?php
class Admin {
    private $pdo;
    public function __construct($pdo){ $this->pdo = $pdo; }

    public function findByUsername($username){
        $stmt = $this->pdo->prepare("SELECT * FROM admin WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
