<?php
require_once "../config/Database.php";
require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
    public function demanderResetMotDePasse(string $email): bool{
    $stmt = $this->db->prepare("SELECT id_user FROM utilisateur WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        return false; 
    }
    $token = bin2hex(random_bytes(32));
    $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
    $stmt = $this->db->prepare("UPDATE utilisateur 
        SET reset_token = ?, reset_expires = ? 
        WHERE id_user = ?
    ");
    $stmt->execute([$token, $expires, $user['id_user']]);

    $resetLink = "https://buymatch.ma/reset-password.php?token=" . urlencode($token);
    $subject = "BuyMatch - Réinitialisation de votre mot de passe";
    $body = "
        <h2>Bonjour,</h2>
        <p>Vous avez demandé à réinitialiser votre mot de passe sur BuyMatch.</p>
        <p>Cliquez sur le lien ci-dessous pour définir un nouveau mot de passe :</p>
        <p><a href='$resetLink' style='background:#10b981;color:white;padding:12px 24px;border-radius:8px;text-decoration:none;'>Réinitialiser mon mot de passe</a></p>
        <p>Ce lien expire dans 1 heure.</p>
        <p>Si vous n'avez pas demandé cette réinitialisation, ignorez cet e-mail.</p>
        <p>Cordialement,<br>L'équipe BuyMatch</p>
    ";

    return $this->sendEmail($email, $subject, $body);
}
public function resetMotDePasse(string $token, string $newPassword): bool
{
    $stmt = $this->db->prepare("
        SELECT id_user 
        FROM utilisateur 
        WHERE reset_token = ? 
          AND reset_expires > NOW()
    ");
    $stmt->execute([$token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        return false;
    }
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt = $this->db->prepare("
        UPDATE utilisateur 
        SET password = ?, 
            reset_token = NULL, 
            reset_expires = NULL 
        WHERE id_user = ?
    ");
    return $stmt->execute([$hashedPassword, $user['id_user']]);
}
private function sendEmail(string $to, string $subject, string $body): bool{

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username = 'houtm27@gmail.com';
        $mail->Password = 'ytoqpktwipwkesdy';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('houtm27@gmail.com', 'BuyMatch');

        $mail->addAddress("rkmohsin66@gmail.com");
        $mail->addAddress($this->email);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        return $mail->send();
    } catch (Exception $e) {
        error_log("Erreur envoi email reset : " . $mail->ErrorInfo);
        return false;
    }
}
}
