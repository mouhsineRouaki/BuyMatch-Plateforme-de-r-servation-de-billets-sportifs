<?php
require_once "Utilisateur.php";
require_once '../../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Register extends Utilisateur {
    
    public function __construct(?int $id, string $nom, string $prenom, string $email, string $password, ?string $phone , $role)
    {
        parent::__construct($id, $nom, $prenom, $email, $password, $phone, $role);
    }

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
public static function envoyerLienReset(string $email): bool
{
    $db = Database::getInstance()->getConnection();
    $stmt = $db->prepare("SELECT id_user FROM utilisateur WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        return false;
    }

    $token = bin2hex(random_bytes(50));
    $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
    $stmt = $db->prepare("UPDATE utilisateur SET reset_token = ?, reset_expires = ? WHERE id_user = ?");
    $stmt->execute([$token, $expires, $user['id_user']]);

    $resetLink = "http://localhost/buyMatch/pages/reset_password.php?token=" . urlencode($token);
    $subject = "BuyMatch - Réinitialisez votre mot de passe";
    $message = "
    <html>
    <body style='font-family: Arial, sans-serif; background:#f4f4f4; padding:20px;'>
        <div style='max-width:600px; margin:auto; background:white; padding:30px; border-radius:12px; box-shadow:0 4px 20px rgba(0,0,0,0.1);'>
            <h2 style='color:#10b981; text-align:center;'>🎫 BuyMatch</h2>
            <h3 style='text-align:center;'>Réinitialisation de mot de passe</h3>
            <p>Bonjour,</p>
            <p>Vous avez demandé à réinitialiser votre mot de passe. Cliquez sur le bouton ci-dessous pour définir un nouveau mot de passe :</p>
            <div style='text-align:center; margin:30px 0;'>
                <a href='$resetLink' style='background:#10b981; color:white; padding:14px 28px; text-decoration:none; border-radius:8px; font-weight:bold; font-size:16px;'>Changer mon mot de passe</a>
            </div>
            <p><small>Ce lien expire dans 1 heure.</small></p>
            <p>Si vous n'êtes pas à l'origine de cette demande, ignorez cet e-mail.</p>
            <hr>
            <p style='text-align:center; color:#888; font-size:12px;'>© 2026 BuyMatch - Tous droits réservés</p>
        </div>
    </body>
    </html>
    ";

    return self::envoyerEmail($email, $subject, $message);
}

public static function reinitialiserMotDePasse(string $token, string $nouveauMotDePasse): bool
{
    $db = Database::getInstance()->getConnection();

    $stmt = $db->prepare("
        SELECT id_user FROM utilisateur 
        WHERE reset_token = ? AND reset_expires > NOW()
    ");
    $stmt->execute([$token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        return false;
    }
    $hashed = password_hash($nouveauMotDePasse, PASSWORD_DEFAULT);

    $stmt = $db->prepare("
        UPDATE utilisateur 
        SET password = ?, reset_token = NULL, reset_expires = NULL 
        WHERE id_user = ?
    ");
    return $stmt->execute([$hashed, $user['id_user']]);
}

private static function envoyerEmail(string $to, string $subject, string $body): bool
{

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'houtm27@gmail.com';
        $mail->Password   = 'ton-mot-de-passe-app'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        $mail->setFrom('houtm27@gmail.com', 'BuyMatch');
        $mail->addAddress("rkmohsin66@gmail.com");
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Erreur envoi email : " . $mail->ErrorInfo);
        return false;
    }
}
    public function logout(): void{
        session_destroy();
    }
}
