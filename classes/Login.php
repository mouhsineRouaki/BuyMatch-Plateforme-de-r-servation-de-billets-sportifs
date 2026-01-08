<?php
require_once "../config/Database.php";

class Login {
    private $db;
    private $email;
    private $password;

    public function __construct($email, $password) {
        $this->db = Database::getInstance()->getConnection();
        $this->email = $email;
        $this->password = $password;
    }

    public function connecter() {
        $stmt = $this->db->prepare("
            SELECT * FROM utilisateur 
            WHERE email = ? AND actif = 1
        ");
        $stmt->execute([$this->email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return ["success" => false, "message" => "Email incorrect"];
        }
        if(!password_verify($this->password , $user["password"])){
             return ["success" => false, "message" => "mot de pass  incorrect"];
        }

       

        session_start();
        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['nom'] = $user['nom'];

        return [
            "success" => true,
            "message" => "Connexion réussie",
            "role" => $user['role']
        ];
    }
}
