<?php

namespace Controleur;

require_once 'Config.php';

class ControleurPageStatistiques
{
    /**
     * Constructeur de la classe.
     */
    public function __construct() {}

    /**
     * Récupère le nombre total de victoires.
     *
     * @return int
     */
    public function getTotalVictoires(): int
    {
        $url = BACKURL . "statistiques/victoires";
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result["data"] ?? 0;
    }

    /**
     * Récupère le nombre total de défaites.
     *
     * @return int
     */
    public function getTotalDefaites(): int
    {
        $url = BACKURL . "statistiques/defaites";
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result["data"] ?? 0;
    }

    /**
     * Récupère le nombre total de matchs nuls.
     *
     * @return int
     */
    public function getTotalNuls(): int
    {
        $url = BACKURL . "statistiques/nuls";
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result["data"] ?? 0;
    }

    /**
     * Calcule le pourcentage de victoires global.
     *
     * @return float
     */
    public function getPourcentVictoires(): float
    {
        $url = BACKURL . "statistiques/pourcentage/victoires";
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result["data"] ?? 0;
    }

    /**
     * Calcule le pourcentage de défaites global.
     *
     * @return float
     */
    public function getPourcentDefaites(): float
    {
        $url = BACKURL . "statistiques/pourcentage/defaites";
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result["data"] ?? 0;
    }

    /**
     * Calcule le pourcentage de matchs nuls global.
     *
     * @return float
     */
    public function getPourcentNuls(): float
    {
        $url = BACKURL . "statistiques/pourcentage/nuls";
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result["data"] ?? 0;
    }

    /**
     * Récupère le poste favori du joueur.
     *
     * @param int $n_licence
     * @return string
     */
    public function getPosteFavoris(int $n_licence): string
    {
        $url = BACKURL . "joueurs/$n_licence/favoris";
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result["data"] ?? "Aucun";
    }

    /**
     * Récupère le nombre de titularisations du joueur.
     *
     * @param int $n_licence
     * @return int
     */
    public function getTitularisations(int $n_licence): int
    {
        $url = BACKURL . "joueurs/$n_licence/titularisations";
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result["data"] ?? 0;
    }

    /**
     * Récupère le nombre de remplacements du joueur.
     *
     * @param int $n_licence
     * @return int
     */
    public function getRemplacements(int $n_licence): int
    {
        $url = BACKURL . "joueurs/$n_licence/remplacements";
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result["data"] ?? 0;
    }

    /**
     * Récupère la moyenne d'évaluation du joueur.
     *
     * @param int $n_licence
     * @return float
     */
    public function getMoyenneEval(int $n_licence): float
    {
        $url = BACKURL . "joueurs/$n_licence/moyenne-note";
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result["data"] ?? 0;
    }

    /**
     * Récupère le nombre de matchs consécutifs joués par le joueur.
     *
     * @param int $n_licence
     * @return int
     */
    public function getMatchsConsecutifs(int $n_licence): int
    {
        $url = BACKURL . "joueurs/$n_licence/matchs-consecutifs";
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result["data"] ?? 0;
    }

    /**
     * Calcule le pourcentage de victoires du joueur.
     *
     * @param int $n_licence
     * @return float
     */
    public function getPourcentVictoiresJoueur(int $n_licence): float
    {
        $url = BACKURL . "joueurs/$n_licence/pourcent-victoire";
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result["data"] ?? 0;
    }
}
