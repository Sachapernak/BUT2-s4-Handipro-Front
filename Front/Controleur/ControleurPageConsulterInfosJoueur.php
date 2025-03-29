<?php

namespace Controleur;
require_once "Config.php";
class ControleurPageConsulterInfosJoueur 
{

    /**
     * Constructeur de la classe. Initialise les DAO nécessaires.
     */
    public function __construct()
    {
    }

    /**
     * Récupère un joueur à partir de son numéro de licence.
     *
     * @param string $n_licence Le numéro de licence du joueur.
     * @return array Le joueur correspondant.
     */
    public function recupererJoueur($n_licence): ?array {

        $data = "?action=recupererJoueur&id=$n_licence";
        $url = BACKURL."EndPointJoueur.php".$data;
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result == null ? null : $result["data"];

    }

    /**
     * Récupère tous les commentaires associés à un joueur.
     *
     * @return array Un tableau de commentaires pour le joueur.
     */
    public function recupererCommentaires() {
        $n_licence = $_GET['nLicence'];

        $data = "?action=getCommentaireJoueur&id=$n_licence";

        $url = BACKURL."EndPointJoueur.php".$data;
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result == null ? null : $result["data"];
    }

    /**
     * Ajoute un commentaire pour un joueur.
     *
     * @return void
     */
    public function ajouterCommentaire(){
        $n_licence = $_GET['nLicence'];
        $commentaireSaisi = $_POST['commentaire'];
        $date = date('Y-m-d'); 


        $commentaire = array(
            "id_joueur" => $n_licence,
            "date" => $date,
            "commentaire" => $commentaireSaisi
        );

        $data = "?action=recupererJoueurs&id=$n_licence";
        $url = BACKURL."EndPointCommentaire.php".$data;
        $response = \Controleur\MethodesCurl::callAPI("POST", $url, $commentaire);
        $result = json_decode($response, true);
        return $result == null ? null : $result["data"];
    }


     /**
     * Met à jour les informations d'un joueur.
     *
     * @return array les informations de mise a jour.
     */
    public function mettreAJourJoueur(): ?array
    {
        $n_licence = (int) $_GET['nLicence'];

        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $statutComplet = $_POST['statut'];
        $statut = substr($statutComplet, 0, 3);
        $date_naissance = $_POST['date_naissance'];
        $taille = (int) $_POST['taille'];
        $poids = $_POST['poids'];

        $joueur = [
            "nom"               => $nom,
            "prenom"            => $prenom,
            "date_de_naissance" => $date_naissance,
            "taille"            => $taille,
            "poids"             => $poids,
            "statut"            => $statut
        ];

        $url = BACKURL . "EndPointJoueur.php?id=" . $n_licence;

        $response = \Controleur\MethodesCurl::callAPI("PUT", $url, $joueur);
        $result = json_decode($response, true);

        return $result["data"];
    }


    /**
     * Vérifie si un joueur peut être supprimé (possible s'il n'a jamais participé à un match).
     *
     * @param string $n_licence Le numéro de licence du joueur.
     * @return bool True si le joueur peut être supprimé, False sinon.
     */
    public function peutEtreSupprime($n_licence){
        $data = "?action=peutEtreSupprime&id=$n_licence";

        $url = BACKURL."EndPointJoueur.php".$data;
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result == null ? false : $result["data"];
    }

     /**
     * Supprime un joueur de la base de données.
     *
     * @param string $n_licence Le numéro de licence du joueur.
     * @return void
     */
    public function supprimerJoueur($n_licence) {
        $data = "?id=$n_licence";
        $url = BACKURL."EndPointJoueur.php".$data;
        $response = \Controleur\MethodesCurl::callAPI("DELETE", $url);

    }

    public function estCommentaireExistant(): ?bool {
        $n_licence = $_GET['nLicence'];
        $date = date('Y-m-d'); 

        $data = "?action=estCommentaireExistant&idJoueur=$n_licence&date=$date";

        $url = BACKURL."EndPointCommentaire.php".$data;
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result["data"];
    }

}


?>