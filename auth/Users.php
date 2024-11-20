<?php
namespace auth;
use Exception;

/**
 * Permet de simuler une personne ayant :
 *  - un nom
 *  - un prénom
 *  - un email
 *  - un numéro de téléphone
 *  - un mot de passe
 */
class Users {

    private $nom;
    private $prenom;
    private $email;
    private $noTel;
    private $mdp;

    private $token;

    /**
     * Construit une nouvelle personne avec les paramètres spécifiés
     * @param string $prenom Prénom
     * @param string $nom Nom
     * @param string $email Email
     * @param string $noTel Numéro de téléphone
     * @param string $mdp Mot de passe
     * @throws Exception Lance une exception si un des paramètres n'est pas spécifié
     */
    public function __construct(string $prenom, string $nom, string $email, string $noTel, string $mdp) {
        if (empty($prenom)) {
            throw new Exception('Il faut un prénom');
        }
        if (empty($nom)) {
            throw new Exception('Il faut un nom');
        }
        if (empty($email)) {
            throw new Exception('Il faut un email');
        }
        if (empty($noTel)) {
            throw new Exception('Il faut un numéro de téléphone');
        }
        if (empty($mdp)) {
            throw new Exception('Il faut un mot de passe');
        }


        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->email = $email;
        $this->noTel = $noTel;
        $this->mdp = $mdp;
    }

    // Getters et setters pour le prénom
    /**
     * Retourne le prénom de la personne.
     * @return string Le prénom.
     */
    public function getPrenom(): string {
        return $this->prenom;
    }

    /**
     * Définit le prénom de la personne.
     * @param string $prenom Le nouveau prénom.
     */
    public function setPrenom(string $prenom): void {
        if (!empty($prenom)) {
            $this->prenom = $prenom;
        }
    }

    // Getters et setters pour le nom
    /**
     * Retourne le nom de la personne.
     * @return string Le nom.
     */
    public function getNom(): string {
        return $this->nom;
    }

    /**
     * Définit le nom de la personne.
     * @param string $nom Le nouveau nom.
     */
    public function setNom(string $nom): void {
        if (!empty($nom)) {
            $this->nom = $nom;
        }
    }

    // Getters et setters pour l'email
    /**
     * Retourne l'email de la personne.
     * @return string L'email.
     */
    public function getEmail(): string {
        return $this->email;
    }

    /**
     * Définit l'email de la personne.
     * @param string $email Le nouvel email.
     */
    public function setEmail(string $email): void {
        if (!empty($email)) {
            $this->email = $email;
        }
    }

    // Getters et setters pour le numéro de téléphone
    /**
     * Retourne le numéro de téléphone de la personne.
     * @return string Le numéro de téléphone.
     */
    public function getNoTel(): string {
        return $this->noTel;
    }

    /**
     * Définit le numéro de téléphone de la personne.
     * @param string $noTel Le nouveau numéro de téléphone.
     */
    public function setNoTel(string $noTel): void {
        if (!empty($noTel)) {
            $this->noTel = $noTel;
        }
    }

    // Getters et setters pour le mot de passe
    /**
     * Retourne le mot de passe de la personne.
     * @return string Le mot de passe.
     */
    public function getMdp(): string {
        return $this->mdp;
    }

    /**
     * Définit le mot de passe de la personne.
     * @param string $mdp Le nouveau mot de passe.
     */
    public function setMdp(string $mdp): void {
        if (!empty($mdp)) {
            $this->mdp = $mdp;
        }
    }

    // Méthode toString pour afficher une description complète de la personne
    /**
     * Retourne une description complète de la personne.
     * @return string Description complète.
     */
    public function __toString(): string {
        return $this->prenom . " " .
            $this->nom . " " .
            $this->email . " " .
            $this->noTel . " " .
            $this->mdp . '<br>';
    }
}