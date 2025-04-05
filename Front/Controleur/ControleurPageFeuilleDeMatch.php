<?php

namespace Controleur;
require_once 'Config.php';

class ControleurPageFeuilleDeMatch
{
    /**
     * Constructeur de la classe. (Vide mais extensible)
     */
    public function __construct() {}

    /**
     * Crée une participation (relation joueur-match).
     *
     * @param array $jouer Tableau contenant les infos de participation.
     * @return array|null Réponse de l'API.
     */
    public function creerParticipation(array $jouer): ?array
    {
        $url = BACKURL . "participations";
        $response = \Controleur\MethodesCurl::callAPI("POST", $url, $jouer);
        return json_decode($response, true);
    }

    /**
     * Supprime une participation pour un joueur et un match donnés.
     *
     * @param string $n_licence Le numéro de licence du joueur.
     * @param int $id_match L'identifiant du match.
     */
    public function supprimerParticipation($n_licence, $id_match): void
    {
        $url = BACKURL . "participations/$n_licence/$id_match";
        \Controleur\MethodesCurl::callAPI("DELETE", $url);
    }

    /**
     * Met à jour toutes les participations pour un match donné.
     *
     * @param array $joueursSelectionnes Liste des joueurs sélectionnés.
     * @param int $id_match Identifiant du match.
     */
    public function actualiserParticipation(array $joueursSelectionnes, $id_match): void
    {
        $this->viderJoueurPourUnMatch($id_match);

        foreach ($joueursSelectionnes as $joueur) {
            $n_licence = $joueur['licence'];
            $position  = $joueur['position'];
            $role      = $joueur['role'];

            $jouer = [
                "n_licence"      => $n_licence,
                "id_match"       => $id_match,
                "est_remplacant" => (int) $role,
                "role"           => $position
            ];

            $res = $this->creerParticipation($jouer);

            if ($res && $res["status_code"] != 200) {
                echo '<script type="text/javascript">window.alert("' . $res['status_message'] . '");</script>';
                break;
            }
        }

        header('Location: Matchs.php');
    }

    /**
     * Supprime toutes les participations d'un match donné.
     *
     * @param int $id_match L'identifiant du match.
     */
    public function viderJoueurPourUnMatch($id_match): void
    {
        $url = BACKURL . "matchs/$id_match/joueurs";
        \Controleur\MethodesCurl::callAPI("DELETE", $url);
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
        return json_decode($response, true);
    }

    /**
     * Vérifie si les titulaires ont les positions minimales requises.
     *
     * @param array $joueursSelectionnes Liste des joueurs sélectionnés.
     * @return bool True si conditions remplies, sinon False.
     */
    public function verifierPositionTitulaires(array $joueursSelectionnes): bool
    {
        $countMeneur = 0;
        $countAilier = 0;
        $countPivot  = 0;

        foreach ($joueursSelectionnes as $jouer) {
            if ($jouer['role'] === '0') {
                match ($jouer['position']) {
                    'Meneur' => $countMeneur++,
                    'Ailier' => $countAilier++,
                    'Pivot'  => $countPivot++,
                };
            }
        }

        return $countMeneur === 1 && $countAilier === 2 && $countPivot === 2;
    }

    /**
     * Vérifie s'il y a au moins 5 joueurs sélectionnés.
     *
     * @param array $joueurs Liste des joueurs sélectionnés.
     * @return bool True si >= 5, sinon False.
     */
    public function verifierTailleJoueursSelec(array $joueurs): bool
    {
        return count($joueurs) >= 5;
    }

    /**
     * Récupère tous les commentaires associés à un joueur.
     *
     * @param string $n_licence Le numéro de licence du joueur.
     * @return string Commentaires formatés en HTML.
     */
    public function getCommentairesJoueur($n_licence): string
    {
        $url = BACKURL . "joueurs/$n_licence/commentaires";
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);

        $tousLesCommentaires = "";

        if (!empty($result["data"])) {
            foreach ($result["data"] as $commentaire) {
                $tousLesCommentaires .= "<p>" . $commentaire["date"] . " : " . $commentaire["commentaire"] . "</p><br>";
            }
        }

        return $tousLesCommentaires;
    }

    /**
     * Récupère les informations de participation des joueurs pour un match.
     *
     * @param int $idMatch L'identifiant du match.
     * @return array|null La réponse de l'API ou null.
     */
    public function getInfosParticipation($idMatch): ?array
    {
        $url = BACKURL . "matchs/$idMatch/participation";
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        return json_decode($response, true);
    }
}
