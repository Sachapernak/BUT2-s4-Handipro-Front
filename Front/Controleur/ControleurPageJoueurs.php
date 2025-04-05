<?php

namespace Controleur;
require_once "Config.php";

class ControleurPageJoueurs
{
    /**
     * Constructeur de la classe.
     */
    public function __construct() {}

    /**
     * Récupère tous les joueurs disponibles en base de données.
     *
     * @return array|null Un tableau contenant les joueurs ou null en cas d'erreur.
     */
    public function getJoueurs(): ?array
    {
        $url = BACKURL . "joueurs";
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result["data"] ?? null;
    }

    /**
     * Récupère la note moyenne d'un joueur à partir de son numéro de licence.
     *
     * @param string $n_licence Le numéro de licence du joueur.
     * @return int La note moyenne du joueur, ou 0 en cas d'erreur.
     */
    public function getNoteMoyenneJoueur($n_licence): int
    {
        $url = BACKURL . "joueurs/$n_licence/moyenne-note";
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return (int) $result["data"] ?? 0;
    }

    /**
     * Génère une chaîne représentant les étoiles correspondant à la note moyenne d'un joueur.
     *
     * @param string $n_licence Le numéro de licence du joueur.
     * @return string Une chaîne contenant les étoiles.
     */
    public function afficherEtoiles($n_licence): string
    {
        $etoile = "";
        $nbrEtoilesTotal = 5;
        $note = $this->getNoteMoyenneJoueur($n_licence);

        $etoile .= str_repeat("★", $note);
        $etoile .= str_repeat("☆", $nbrEtoilesTotal - $note);

        return $etoile;
    }

    /**
     * Effectue une recherche de joueurs en fonction de critères spécifiques.
     *
     * @param string $recherche Les critères de recherche.
     * @return array|null Les résultats correspondant aux critères ou null si aucun.
     */
    public function resultatRecherche($recherche): ?array
    {
        $url = BACKURL . "joueurs/recherche/" . urlencode($recherche);
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result["data"] ?? null;
    }
}
