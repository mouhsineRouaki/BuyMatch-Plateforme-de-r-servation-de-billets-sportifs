<?php
require_once __DIR__ . "/../config/Database.php";

abstract class Utilisateur {

    protected ?int $id = null;
    protected string $nom;
    protected string $prenom;
    protected string $email;
    protected string $password;
    protected ?string $phone;
    protected string $role;
    protected bool $actif = true;

    protected PDO $db;

    public function __construct(
        int $id,
        string $nom,
        string $prenom,
        string $email,
        string $password,
        ?string $phone,
        string $role
    ) {
        $this->db = Database::getInstance()->getConnection();
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->password = $password;
        $this->phone = $phone;
        $this->role = $role;
    }
    public function __get($name){
        return $this->$name;
    }
    public function __set($name, $value){
        $this->$name =  $value;
    }



    public function sinscrire(): array {
        $check = $this->db->prepare("SELECT id_user FROM utilisateur WHERE email = ?");
        $check->execute([$this->email]);
        if ($check->fetch()) {
            return ["success" => false,"message" => "Email déjà utilisé"];
        }

        $stmt = $this->db->prepare("INSERT INTO utilisateur(nom, prenom, email, password, phone, role, actif) VALUES (?, ?, ?, ?, ?, ?, 1)");

        $stmt->execute([$this->nom,$this->prenom,$this->email,$this->password,$this->phone,$this->role]);

        $this->id_user = $this->db->lastInsertId();

        $this->insertIntoRoleTable();

        return [
            "success" => true,
            "message" => "Inscription réussie",
            "id_user" => $this->id_user
        ];
    }

    protected function insertIntoRoleTable(): void {
        if ($this->role === "ACHETEUR") {
            $this->db->prepare("INSERT INTO acheteur (id_user) VALUES (?)")->execute([$this->id_user]);
        }
        if ($this->role === "ORGANISATEUR") {
            $this->db->prepare("INSERT INTO organisateur (id_user) VALUES (?)")->execute([$this->id_user]);
        }
        if ($this->role === "ADMINISTRATEUR") {
            $this->db->prepare("INSERT INTO administrateur (id_user) VALUES (?)")->execute([$this->id_user]);
        }
    }


    public static function login(string $email, string $password): array {

        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare(
            "SELECT * FROM utilisateur WHERE email = ? AND actif = 1"
        );
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user['password'])) {
            return [
                "success" => false,
                "message" => "Email ou mot de passe incorrect"
            ];
        }

        session_start();
        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['role'] = $user['role'];

        return [
            "success" => true,
            "message" => "Connexion réussie",
            "user" => $user
        ];
    }

    public static function getUserConnected(): ?array {

        if (!isset($_SESSION['id_user'])) {
            return null;
        }

        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare(
            "SELECT * FROM utilisateur WHERE id_user = ?"
        );
        $stmt->execute([$_SESSION['id_user']]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function logout(): void {
        session_start();
        session_destroy();
    }
}
