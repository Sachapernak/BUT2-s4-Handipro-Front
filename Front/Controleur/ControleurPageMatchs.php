<?php

namespace Controleur;
require_once 'Config.php';


use DateTime;

class ControleurPageMatchs
{


    /**
     * Constructeur de la classe ControleurPageMatchs.
     * Initialise les DAO nécessaires pour gérer les joueurs, les matchs et les participations.
     */
    public function __construct()
    {

    }

    /**
     * Récupère les joueurs participants à un match donné.
     *
     * @param int $id_match L'identifiant du match.
     * @return array Un tableau d'array Joueur représentant les joueurs participants.
     */
    public function getJoueursParticipants($id_match)
    {
        $data = "?action=getJoueursParticipants&id=$id_match";
        $url = BACKURL."EndPointMatch.php".$data;
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result == null ? null : $result["data"];
    }

    /**
     * Récupère les informations de participation d'un joueur pour un match donné.
     *
     * @param int $id_match L'identifiant du match.
     * @param string $id_joueur Le numéro de licence du joueur.
     * @return array | null Les informations de participation du joueur au match.
     */
    public function getInfosParticipants($id_match, $id_joueur): ?array
    {
        $data = "?action=getInfosParticipation&idM=$id_match&idJ=$id_joueur";
        $url = BACKURL."EndPointParticipation.php".$data;
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result == null ? null : $result["data"];

    }


    /**
     * Récupère les matchs à venir par rapport à la date actuelle.
     *
     * @return array | null La liste des matchs à venir.
     */
    public function getMatchsAVenir(): ?array
    {
        $data = "?action=getMatchsAVenir";
        $url = BACKURL."EndPointMatch.php".$data;
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result == null ? null : $result["data"];
    }


    /**
     * Récupère les matchs passés par rapport à la date actuelle.
     *
     * @return array | null La liste des matchs passés.
     */
    public function getMatchsPasses(): ?array
    {
        $data = "?action=getMatchsPasses";
        $url = BACKURL."EndPointMatch.php".$data;
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result == null ? null : $result["data"];
    }

    /**
     * Affiche une chaîne d'étoiles en fonction de la note donnée.
     *
     * @param $note int La note du joueur.
     * @return string La représentation des étoiles.
     */
    public function afficherEtoiles($note): string
    {
        if($note == null){
            return "☆☆☆☆☆";
        }
        $etoile = "";
        $nbrEtoilesTotal = 5;
        for ($i = 0; $i < $note; $i++) {
            $etoile .= "★";
        }
        $etoilesVides = $nbrEtoilesTotal - $note;
        for ($i = 0; $i < $etoilesVides; $i++) {
            $etoile .= "☆";
        }

        return $etoile;
    }

    /**
     * Affiche le statut d'un joueur (titulaire ou remplaçant).
     *
     * @param int $estRemplacant 1 pour remplaçant, 0 pour titulaire.
     * @return string Le statut du joueur.
     */
    public function afficherRemplacement(int $estRemplacant): string
    {
        $resultat = "";
        switch ($estRemplacant) {
            case 1:
                $resultat = "Remplacant";
                break;
            case 0:
                $resultat = "Titulaire";
                break;
        }
        return $resultat;
    }

    /**
     * Supprime un match donné de la base de données.
     *
     * @param int $idMatch L'identifiant du match à supprimer.
     */
    public function supprimerMatch($idMatch): void
    {
        $data = "?action=supprimerMatch&id=$idMatch";
        $url = BACKURL."EndPointMatch.php".$data;
        $response = \Controleur\MethodesCurl::callAPI("DELETE", $url);
        $result = json_decode($response, true);
    }

    /**
     * Affiche le résultat d'un match basé sur un code (V, D, N).
     *
     * @param string $score Le code du score (V = victoire, D = défaite, N = match nul).
     * @return string Le résultat sous forme de texte.
     */
    public function afficherResultat($score){
        switch ($score) {
            case "V":
                $resultat = "Victoire";
                break;
            case "D":
                $resultat = "Défaite";
                break;
            case "N":
                $resultat = "Match nul";
                break;
            default: 
                $resultat = "$score";
                break;
        }
        return $resultat;
    }

    /**
     * Affiche le lieu du match basé sur un code (dom ou ext).
     *
     * @param string $lieu Le code du lieu (dom = domicile, ext = extérieur).
     * @return string Le lieu sous forme de texte.
     */
    public function afficherLieu($lieu){
        switch ($lieu) {
            case "ext":
                $resultat = "Extérieur";
                break;
            case "dom":
                $resultat = "A domicile";
                break;
            default: 
                $resultat = "$lieu";
                break;
        }
        return $resultat;
    }

     /**
     * Formate la date et l'heure d'un match.
     * 
     * @param array $match L'objet match contenant la date et l'heure.
     * @return string La date et l'heure formatées (Y-m-d H:i).
     */
    public function afficherDateHeure($match){
        $dateTimeObj = new DateTime($match["date_et_heure"]);
        $date_heure = $dateTimeObj->format('Y-m-d H:i'); 
        return $date_heure;
    }

}

?>