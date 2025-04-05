<?php

namespace Controleur;

require_once "Config.php";
use DateTime;

class ControleurPageConsulterInfosJoueur
{
    /**
     * Constructeur de la classe.
     */
    public function __construct() {}

    /**
     * Récupère un joueur à partir de son numéro de licence.
     *
     * @param string $n_licence Le numéro de licence du joueur.
     * @return array|null Le joueur correspondant ou null si introuvable.
     */
    public function recupererJoueur($n_licence): ?array
    {
        $url = BACKURL . "joueurs/" . $n_licence;
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result["data"] ?? null;
    }

    /**
     * Récupère tous les commentaires associés à un joueur.
     *
     * @return array|null Un tableau de commentaires ou null.
     */
    public function recupererCommentaires(): ?array
    {
        $n_licence = $_GET['nLicence'];
        $url = BACKURL . "joueurs/" . $n_licence . "/commentaires";
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result["data"] ?? null;
    }

    /**
     * Ajoute un commentaire pour un joueur.
     *
     * @return array|null Le commentaire ajouté ou null en cas d'erreur.
     */
    public function ajouterCommentaire(): ?array
    {
        $n_licence = $_GET['nLicence'];
        $commentaireSaisi = $_POST['commentaire'];
        $date = date('Y-m-d');

        $commentaire = [
            "id_joueur"  => $n_licence,
            "date"       => $date,
            "commentaire"=> $commentaireSaisi
        ];

        $url = BACKURL . "commentaires";
        $response = \Controleur\MethodesCurl::callAPI("POST", $url, $commentaire);
        $result = json_decode($response, true);
        return $result["data"] ?? null;
    }

    /**
     * Met à jour les informations d'un joueur.
     *
     * @return array|null Les informations mises à jour ou null en cas d'échec.
     */
    public function mettreAJourJoueur(): ?array
    {
        $n_licence = (int) $_GET['nLicence'];

        $nom             = $_POST['nom'];
        $prenom          = $_POST['prenom'];
        $statutComplet   = $_POST['statut'];
        $statut          = substr($statutComplet, 0, 3);
        $date_naissance  = $_POST['date_naissance'];
        $taille          = (int) $_POST['taille'];
        $poids           = $_POST['poids'];

        $joueur = [
            "nom"               => $nom,
            "prenom"            => $prenom,
            "date_de_naissance" => $date_naissance,
            "taille"            => $taille,
            "poids"             => $poids,
            "statut"            => $statut
        ];

        $url = BACKURL . "joueurs/" . $n_licence;
        $response = \Controleur\MethodesCurl::callAPI("PUT", $url, $joueur);
        $result = json_decode($response, true);
        return $result["data"] ?? null;
    }

    /**
     * Vérifie si un joueur peut être supprimé.
     *
     * @param string $n_licence Le numéro de licence du joueur.
     * @return bool True si le joueur peut être supprimé, False sinon.
     */
    public function peutEtreSupprime($n_licence): bool
    {
        $url = BACKURL . "joueurs/" . $n_licence . "/supprimable";
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result["data"] ?? false;
    }

    /**
     * Supprime un joueur de la base de données.
     *
     * @param string $n_licence Le numéro de licence du joueur.
     * @return void
     */
    public function supprimerJoueur($n_licence): void
    {
        $url = BACKURL . "joueurs/" . $n_licence;
        \Controleur\MethodesCurl::callAPI("DELETE", $url);
    }

    /**
     * Vérifie si un commentaire existe déjà pour le joueur à la date du jour.
     *
     * @return bool|null True si le commentaire existe, False sinon, null en cas d'erreur.
     */
    public function estCommentaireExistant(): ?bool
    {
        $n_licence = $_GET['nLicence'];
        $date = date('Y-m-d');

        $url = BACKURL . "commentaires/existe/" . $n_licence . "/" . $date;
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result["data"] ?? null;
    }
}
