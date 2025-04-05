<?php

namespace Controleur;
require_once 'Config.php';

class ControleurPageSaisieNote
{
    /**
     * Constructeur de la classe ControleurPageSaisieNote.
     */
    public function __construct() {}

    /**
     * Modifie la note d'un joueur pour un match donné.
     *
     * @param int $idMatch L'identifiant du match.
     * @param int $n_licence Le numéro de licence du joueur.
     * @return array|null Résultat de l'opération ou null en cas d'échec.
     */
    public function modifierJouer(int $idMatch, int $n_licence): ?array
    {
        $note = $_POST["note"];

        $scoreArray = [
            "note" => $note,
        ];

        $url = BACKURL . "participations/$n_licence/$idMatch/modifier-note";
        $response = \Controleur\MethodesCurl::callAPI("PATCH", $url, $scoreArray);
        $result = json_decode($response, true);

        header('Location: Matchs.php');
        return $result;
    }

    /**
     * Récupère les informations d'un joueur pour un match donné.
     *
     * @param int $idMatch L'identifiant du match.
     * @param int $n_licence Le numéro de licence du joueur.
     * @return array|null Données de participation ou null si non trouvées.
     */
    public function recupererInfosJouer(int $idMatch, int $n_licence): ?array
    {
        $url = BACKURL . "participations/$n_licence/$idMatch";
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result["data"] ?? null;
    }

    /**
     * Récupère les informations d'un joueur via son numéro de licence.
     *
     * @param int $n_licence Le numéro de licence du joueur.
     * @return array|null Données du joueur ou null si non trouvées.
     */
    public function recupererInfosJoueur(int $n_licence): ?array
    {
        $url = BACKURL . "joueurs/" . $n_licence;
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result["data"] ?? null;
    }
}
