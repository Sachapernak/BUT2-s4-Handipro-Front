<?php

namespace Controleur;
require_once "Config.php";

class ControleurPageJoueurs
{

     /**
     * Constructeur de la classe. Initialise les DAO nécessaires pour gérer les joueurs et leurs relations.
     */
    public function __construct(){

    }

     /**
     * Récupère tous les joueurs disponibles en base de données.
     *
     * @return array Un tableau contenant les joueurs.
     */
    public function getJoueurs() : ?array {

        $data = "?action=getJoueurs";
        $url = BACKURL."EndPointJoueur.php".$data;
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result == null ? null : $result["data"];

    }

    /**
     * Récupère la note moyenne d'un joueur à partir de son numéro de licence.
     *
     * @param string $n_licence Le numéro de licence du joueur.
     * @return int La note moyenne du joueur.
     */
    public function getNoteMoyenneJoueur($n_licence): int{

        $data = "?action=getMoyenneEval&id=$n_licence";
        $url = BACKURL."EndPointJoueur.php".$data;
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result == null ? 0 : $result["data"];
    }

    /**
     * Génère une chaîne représentant les étoiles correspondant à la note moyenne d'un joueur.
     *
     * ★ pour les étoiles pleines, ☆ pour les étoiles vides.
     *
     * @param string $n_licence Le numéro de licence du joueur.
     * @return string Une chaîne contenant les étoiles.
     */
    public function afficherEtoiles($n_licence) : string {
        $etoile = ""; 
        $nbrEtoilesTotal = 5;
        $note = $this->getNoteMoyenneJoueur($n_licence);
        for ($i = 0; $i < $note; $i++) {
            $etoile.= "★";
        }
        $etoilesVides = $nbrEtoilesTotal - $note;
        for ($i = 0; $i < $etoilesVides; $i++) {
            $etoile.= "☆";
        }

        return $etoile;
    }


     /**
     * Effectue une recherche de joueurs en fonction de critères spécifiques.
     *
     * @param string $recherche Les critères de recherche.
     * @return array Les résultats correspondant aux critères.
     */
    public function resultatRecherche($recherche): ?array{

        $data = "?action=resultatRecherche&attribut=$recherche";
        $url = BACKURL."EndPointJoueur.php".$data;
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result == null ? null : $result["data"];

    }
}

?>