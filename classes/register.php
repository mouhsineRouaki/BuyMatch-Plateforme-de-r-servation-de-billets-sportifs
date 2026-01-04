<?php
require_once "Utilisateur.php";

class Register extends Utilisateur {

    public function inscrire() {
        $check = $this->db->prepare("SELECT id_user FROM utilisateur WHERE email = ?");
        $check->execute([$this->email]);
        if ($check->fetch()) {
            return ["success" => false, "message" => "Email déjà utilisé"];
        }
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO utilisateur (nom, prenom, email, password, phone, role, actif) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $this->nom,
            $this->prenom,
            $this->email,
            $hashedPassword,
            $this->phone,
            $this->role,
            $this->actif
        ]);

        $idUser = $this->db->lastInsertId();

        if ($this->role === "achteur") {
            $this->db->prepare("INSERT INTO acheteur (id_user) VALUES (?)")->execute([$idUser]);
        } elseif ($this->role === "organisateur") {
            $this->db->prepare("INSERT INTO organisateur (id_user) VALUES (?)")->execute([$idUser]);
        } elseif ($this->role === "administrateur") {
            $this->db->prepare("INSERT INTO administrateur (id_user) VALUES (?)")->execute([$idUser]);
        }
        return [
            "success" => true,
            "message" => "Inscription réussie",
            "id_user" => $idUser
        ];
    }
}
