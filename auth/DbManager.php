<?php
namespace auth;

use Exception;
use PDO;
use PDOException;

require_once './lib/vendor/autoload.php';
require_once "Users.php";

class DbManager
{
    private PDO $db;

    // Constructeur : initialise la connexion à la base de données
    public function __construct()
    {
        // Charge la configuration de la base de données depuis un fichier .ini
        $config = parse_ini_file('config' . DIRECTORY_SEPARATOR . 'db.ini', true);
        $dsn = $config['dsn'];
        $username = $config['username'];
        $password = $config['password'];

        // Crée une instance PDO pour gérer les interactions avec la base de données
        $this->db = new \PDO($dsn, $username, $password);
    }

    // Crée la table "utilisateurs" si elle n'existe pas déjà
    public function creeTableUtilisateur(): bool
    {
        $sql = <<<COMMANDE_SQL
            CREATE TABLE IF NOT EXISTS utilisateurs (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nom VARCHAR(120) NOT NULL,
                prenom VARCHAR(120) NOT NULL,
                email VARCHAR(120) NOT NULL,
                noTel VARCHAR(20) NOT NULL,
                password VARCHAR(900) NOT NULL, 
                token VARCHAR(255) DEFAULT NULL,
                is_verified BOOLEAN DEFAULT FALSE
            );
COMMANDE_SQL;

        try {
            // Exécute la requête SQL
            $this->db->exec($sql);
            $ok = true;
        } catch (PDOException $e) {
            // Affiche l'erreur en cas de problème
            echo $e->getMessage();
            $ok = false;
        }
        return $ok;
    }

    // Ajoute un utilisateur à la base de données
    public function ajouteUtilisateur(Users $utilisateur): bool
    {
        $userHasBeenAdded = false;

        // Vérifie si l'email est déjà pris
        if (!$this->emailIsTaken($utilisateur->getEmail())) {
            // Génère un token pour l'utilisateur
            $token = bin2hex(random_bytes(16));
            require_once(__DIR__ . '/../mail.php');

            // Prépare les données de l'utilisateur
            $datas = [
                'nom' => $utilisateur->getNom(),
                'prenom' => $utilisateur->getPrenom(),
                'email' => $utilisateur->getEmail(),
                'noTel' => $utilisateur->getNoTel(),
                'password' => $utilisateur->getMdp(),
                'token' => $token
            ];

            $sql = "INSERT INTO utilisateurs (nom, prenom, email, noTel, password, token, is_verified) VALUES "
                . "(:nom, :prenom, :email, :noTel, :password, :token, :is_verified);";

            try {
                // Insère l'utilisateur dans la base de données
                $this->db->prepare($sql)->execute($datas);
                $userHasBeenAdded = true;
            } catch (\PDOException $e) {
                // Affiche l'erreur en cas de problème
                echo $e->getMessage();
            }
        }
        return $userHasBeenAdded;
    }

    // Récupère les utilisateurs avec un nom spécifique
    public function rendUtilisateur(string $nom): array
    {
        $sql = "SELECT * FROM utilisateurs WHERE nom = :nom;";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam('nom', $nom, \PDO::PARAM_STR);
        $stmt->execute();
        $donnees = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $tabUtilisateurs = [];

        if ($donnees) {
            foreach ($donnees as $donneesUtilisateur) {
                // Crée une instance de la classe Users pour chaque utilisateur trouvé
                $p = new Users(
                    $donneesUtilisateur["prenom"],
                    $donneesUtilisateur["nom"],
                    $donneesUtilisateur["email"],
                    $donneesUtilisateur["noTel"],
                    $donneesUtilisateur["password"],
                );
                $tabUtilisateurs[] = $p;
            }
        }
        return $tabUtilisateurs;
    }

    // Supprime un utilisateur à partir de son ID
    public function supprimeUtilisateur(int $id): bool
    {
        $sql = "DELETE FROM utilisateurs WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam('id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    // Vérifie le mot de passe et si l'email est vérifié
    public function checkPasswordAndMailVerification(string $password, string $email): bool
    {
        $bool = false;

        if ($email && $password) {
            $sql = "SELECT * FROM utilisateurs WHERE email = :email";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':email', $email);

            if ($stmt->execute()) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                // Vérifie le mot de passe et si l'utilisateur a vérifié son email
                if ($result && password_verify($password, $result['password']) && $result['is_verified']) {
                    $bool = true;
                } else if (!$result['is_verified']) {
                    echo "Votre mail n'est pas vérifié";
                } else {
                    echo "Mot de passe ou nom d'utilisateur incorrect";
                }
            }
        }
        return $bool;
    }

    // Vérifie si un email existe déjà dans la base
    public function emailIsTaken(string $email): bool
    {
        $sql = "SELECT COUNT(*) FROM utilisateurs WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    }

    // Vérifie un token et met à jour le statut de vérification
    public function checkToken(string $token): bool
    {
        $bool = false;

        $sql = "SELECT * FROM utilisateurs WHERE token = :token";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':token', $token, \PDO::PARAM_STR);
        $stmt->execute();
        $verifiedUser = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($verifiedUser) {
            $sql2 = "UPDATE utilisateurs SET is_verified = 1 WHERE id = :id";
            $stmt = $this->db->prepare($sql2);
            $stmt->bindParam(':id', $verifiedUser['id'], PDO::PARAM_INT);

            if ($stmt->execute()) {
                $bool = true;
            }
        }
        return $bool;
    }
}