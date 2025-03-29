<?php

namespace Controleur;

require_once 'Config.php';


class ControleurPageStatistiques
{


    /**
     * Constructeur de la classe ControleurPageStatistiques.
     * Initialise les objets DAO utilisés pour interagir avec les données des joueurs, des matchs et des participations.
     */
    public function __construct()
    {

    }

     /**
     * Récupère le total des victoires.
     *
     * @return int Retourne le nombre total de victoires.
     */
    public function getTotalVictoires(): int
    {
        $data = "?action=getNbTotalVictoires";
        $url = BACKURL."EndPointStatistiques.php".$data;
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result["data"];

    }

     /**
     * Récupère le total des défaites.
     *
     * @return int Retourne le nombre total de défaites.
     */
    public function getTotalDefaites(): int
    {
        $data = "?action=getNbTotalDefaites";
        $url = BACKURL."EndPointStatistiques.php".$data;
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result["data"];
    }

     /**
     * Récupère le total des matchs nuls.
     *
     * @return int Retourne le nombre total de matchs nuls.
     */
    public function getTotalNuls(): int
    {
        $data = "?action=getNbTotalNuls";
        $url = BACKURL."EndPointStatistiques.php".$data;
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result["data"];
    }

     /**
     * Calcule le pourcentage de victoires.
     *
     * @return float Retourne le pourcentage de victoires arrondi à deux décimales.
     */
    public function getPourcentVictoires(): float
    {
        $data = "?action=getPourcentageVictoires";
        $url = BACKURL."EndPointStatistiques.php".$data;
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result["data"];

    }

    /**
     * Calcule le pourcentage de défaites.
     *
     * @return float Retourne le pourcentage de défaites arrondi à deux décimales.
     */
    public function getPourcentDefaites(): float
    {
        $data = "?action=getPourcentageDefaites";
        $url = BACKURL."EndPointStatistiques.php".$data;
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result["data"];

    }

     /**
     * Calcule le pourcentage de matchs nuls.
     *
     * @return float Retourne le pourcentage de matchs nuls arrondi à deux décimales.
     */
    public function getPourcentNuls(): float
    {
        $data = "?action=getPourcentageNuls";
        $url = BACKURL."EndPointStatistiques.php".$data;
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result["data"];
    }

      /**
     * Récupère le poste favori d'un joueur (le poste le plus joué par le joueur).
     *
     * @param $n_licence int numero de licence du joueur
     * @return string Retourne le poste favori du joueur.
     */
    public function getPosteFavoris($n_licence){
        $data = "?action=getPostFavoris&id=$n_licence";
        $url = BACKURL."EndPointJoueur.php".$data;
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result["data"];
    }

    /**
     * Récupère le nombre de titularisations d'un joueur.
     *
     * @param $n_licence int numero de licence du joueur
     * @return int Retourne le nombre de titularisations du joueur.
     */
    public function getTitularisations(int $n_licence){
        $data = "?action=getNbTitularisations&id=$n_licence";
        $url = BACKURL."EndPointJoueur.php".$data;
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result["data"];
    }

      /**
     * Récupère le nombre de remplacements d'un joueur.
     *
     * @param $n_licence int numero de licence du joueur
     * @return int Retourne le nombre de remplacements du joueur.
     */
    public function getRemplacements(int $n_licence){
        $data = "?action=getNbRemplacements&id=$n_licence";
        $url = BACKURL."EndPointJoueur.php".$data;
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result["data"];
    }

    /**
     * Récupère la moyenne des évaluations d'un joueur.
     *
     * @param $n_licence int numero de licence du joueur
     * @return float Retourne la moyenne des évaluations du joueur, arrondie à deux décimales.
     */
    public function getMoyenneEval(int $n_licence){
        $data = "?action=getMoyenneEval&id=$n_licence";
        $url = BACKURL."EndPointJoueur.php".$data;
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result["data"];
    }

    /**
     * Récupère le nombre de matchs consécutifs joués par un joueur.
     *
     * @param $n_licence int numero de licence du joueur
     * @return int Retourne le nombre de matchs consécutifs joués par le joueur.
     */
    public function getMatchsConsecutifs(int $n_licence){
        $data = "?action=getNbMatchConsecutif&id=$n_licence";
        $url = BACKURL."EndPointJoueur.php".$data;
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result["data"];
    }

      /**
     * Calcule le pourcentage de victoires pour un joueur spécifique.
     *
     * @param $n_licence int numero de licence du joueur
     * @return float Retourne le pourcentage de victoires du joueur, arrondi à deux décimales.
     */
    public function getPourcentVictoiresJoueur(int $n_licence)
    {
        $data = "?action=getPourcentVictoireJoueur&id=$n_licence";
        $url = BACKURL . "EndPointJoueur.php" . $data;
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result["data"];

    }
}

?>