<?php

namespace Controleur;
require_once 'Config.php';

use DateTime;

class ControleurPageMatchs
{
    /**
     * Constructeur de la classe ControleurPageMatchs.
     */
    public function __construct() {}

    /**
     * Récupère les joueurs participants à un match donné.
     *
     * @param int $id_match L'identifiant du match.
     * @return array|null Un tableau des joueurs participants ou null.
     */
    public function getJoueursParticipants($id_match): ?array
    {
        $url = BACKURL . "matchs/$id_match/joueurs-participants";
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result["data"] ?? null;
    }

    /**
     * Récupère les informations de participation d'un joueur à un match.
     *
     * @param int $id_match L'identifiant du match.
     * @param string $id_joueur Le numéro de licence du joueur.
     * @return array|null Informations de participation ou null.
     */
    public function getInfosParticipants($id_match, $id_joueur): ?array
    {
        $url = BACKURL . "participations/$id_joueur/$id_match";
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result["data"] ?? null;
    }

    /**
     * Récupère les matchs à venir.
     *
     * @return array|null La liste des matchs ou null.
     */
    public function getMatchsAVenir(): ?array
    {
        $url = BACKURL . "matchs/avenir";
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result["data"] ?? null;
    }

    /**
     * Récupère les matchs passés.
     *
     * @return array|null La liste des matchs ou null.
     */
    public function getMatchsPasses(): ?array
    {
        $url = BACKURL . "matchs/passes";
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result["data"] ?? null;
    }

    /**
     * Génère une chaîne d'étoiles à partir d'une note.
     *
     * @param int|null $note La note du joueur.
     * @return string Chaîne d'étoiles.
     */
    public function afficherEtoiles($note): string
    {
        if ($note === null) return "☆☆☆☆☆";

        return str_repeat("★", $note) . str_repeat("☆", 5 - $note);
    }

    /**
     * Affiche le statut d'un joueur.
     *
     * @param int $estRemplacant 1 = remplaçant, 0 = titulaire.
     * @return string Statut du joueur.
     */
    public function afficherRemplacement(int $estRemplacant): string
    {
        return $estRemplacant === 1 ? "Remplacant" : "Titulaire";
    }

    /**
     * Supprime un match donné.
     *
     * @param int $idMatch Identifiant du match.
     * @return void
     */
    public function supprimerMatch($idMatch): void
    {
        $url = BACKURL . "matchs/delete/" . $idMatch;
        \Controleur\MethodesCurl::callAPI("DELETE", $url);
    }

    /**
     * Affiche le résultat d'un match (V, D, N).
     *
     * @param string $score Le code du score.
     * @return string Résultat en texte.
     */
    public function afficherResultat($score): string
    {
        return match ($score) {
            "V" => "Victoire",
            "D" => "Défaite",
            "N" => "Match nul",
            default => $score,
        };
    }

    /**
     * Affiche le lieu du match (dom ou ext).
     *
     * @param string $lieu Code du lieu.
     * @return string Texte du lieu.
     */
    public function afficherLieu($lieu): string
    {
        return match ($lieu) {
            "ext" => "Extérieur",
            "dom" => "A domicile",
            default => $lieu,
        };
    }

    /**
     * Formate la date et l'heure d'un match.
     *
     * @param array $match L'objet match contenant la date.
     * @return string Date et heure formatées.
     */
    public function afficherDateHeure($match): string
    {
        $dateTimeObj = new DateTime($match["date_et_heure"]);
        return $dateTimeObj->format('Y-m-d H:i');
    }
}
