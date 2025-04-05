<?php

namespace Controleur;
require_once 'Config.php';

use DateTime;

class ControleurPageModifierMatch
{
    /**
     * Constructeur de la classe ControleurPageModifierMatch.
     */
    public function __construct() {}

    /**
     * Modifie un match existant avec les nouvelles données du formulaire.
     *
     * @param int $idMatch L'identifiant du match à modifier.
     * @return array|null Les informations mises à jour du match ou null en cas d'erreur.
     */
    public function modifierMatch($idMatch): ?array
    {
        $date_match = $_POST['date'];
        $heure_match = $_POST['heure'];
        $dateTime = new DateTime($date_match . ' ' . $heure_match);
        $dateTimeFormatted = $dateTime->format('Y-m-d H:i');

        $adversaire = $_POST['adversaire'];
        $lieu = $_POST['lieu'];

        $match = [
            "date_et_heure" => $dateTimeFormatted,
            "adversaire"    => $adversaire,
            "lieu"          => $lieu,
            "resultat"      => null
        ];

        $url = BACKURL . "matchs/" . $idMatch;
        $response = \Controleur\MethodesCurl::callAPI("PUT", $url, $match);
        $result = json_decode($response, true);

        if ($result["status_code"] != 200) {
            echo '<script type="text/javascript">window.alert("' . $result['status_message'] . '");</script>';
        } else {
            header('Location: Matchs.php');
        }

        return $result;
    }

    /**
     * Récupère les informations d'un match selon son identifiant.
     *
     * @param int $idMatch Identifiant du match.
     * @return array|null Détails du match ou null si non trouvé.
     */
    public function recupererInfosMatch($idMatch): ?array
    {
        $url = BACKURL . "matchs/" . $idMatch;
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result["data"] ?? null;
    }
}
