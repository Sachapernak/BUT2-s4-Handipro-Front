<?php

namespace Controleur;

use DateTime;

require_once "Config.php";

class ControleurPageAccueil
{
    /**
     * Constructeur de la classe. (Actuellement vide, mais prêt à l'emploi si besoin d'initialisation).
     */
    public function __construct() {}

    /**
     * Récupère les informations d'un manager par son ID.
     *
     * @param string $idManager L'identifiant du manager.
     * @return string Le prénom et le nom du manager, ou une chaîne vide si non trouvé.
     */
    public function infoPageAccueil(string $idManager): ?string
    {
        $url = BACKURL . "managers/" . $idManager;
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);

        if (isset($result['data']['prenom']) && isset($result['data']['nom'])) {
            return $result['data']['prenom'] . " " . $result['data']['nom'];
        }

        return "";
    }

    /**
     * Récupère les deux derniers matchs passés.
     *
     * @return array|null Un tableau contenant les matchs ou null en cas d'erreur.
     */
    public function getMatchsRecents(): ?array
    {
        $url = BACKURL . "matchs/recents";
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);

        return $result['data'] ?? null;
    }

    /**
     * Récupère le meilleur joueur d'un match donné.
     *
     * @param int $idMatch L'identifiant du match.
     * @return array|null Le joueur avec la meilleure note, ou null.
     */
    public function getMeilleurJoueur(int $idMatch): ?array
    {
        $url = BACKURL . "matchs/" . $idMatch . "/meilleur-joueur";
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);

        return $result['data'] ?? null;
    }

    /**
     * Récupère le commentaire d'un joueur pour un match donné.
     *
     * @param string $n_licence Numéro de licence du joueur.
     * @param string $dateMatch Date du match (format Y-m-d).
     * @return string Le commentaire trouvé ou un message par défaut.
     */
    public function getCommentaireJoueur(string $n_licence, string $dateMatch): ?string
    {
        if (empty($n_licence) || empty($dateMatch)) {
            return "Pas de commentaire";
        }

        $dateDuMatch = new DateTime($dateMatch);
        $url = BACKURL . "joueurs/" . $n_licence . "/commentaires";
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);

        if (!empty($result['data'])) {
            foreach ($result['data'] as $commentaire) {
                $dateDuCom = new DateTime($commentaire['date']);
                if ($dateDuCom->format('Y-m-d') === $dateDuMatch->format('Y-m-d')) {
                    return $commentaire['commentaire'];
                }
            }
        }

        return "Pas de commentaire";
    }

    /**
     * Récupère les informations de participation d'un joueur à un match.
     *
     * @param string $n_licence Le numéro de licence du joueur.
     * @param int $id_match L'identifiant du match.
     * @return array|null Les informations de participation ou null si non trouvées.
     */
    public function getParticipation(string $n_licence, int $id_match): ?array
    {
        $url = BACKURL . "participations/$n_licence/$id_match";
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);

        return $result['data'] ?? null;
    }

    /**
     * Affiche une version lisible du lieu du match.
     *
     * @param string $lieu Le code du lieu (ex: 'dom', 'ext').
     * @return string La version lisible.
     */
    public function afficherLieu(string $lieu): ?string
    {
        return match ($lieu) {
            'ext' => 'à l\'extérieur',
            'dom' => 'à domicile',
            default => '',
        };
    }

    /**
     * Récupère les joueurs actifs.
     *
     * @return array|null Liste des joueurs actifs ou null.
     */
    public function getJoueursActifs(): ?array
    {
        $url = BACKURL . "joueurs/actifs";
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);

        return $result['data'] ?? null;
    }
}
