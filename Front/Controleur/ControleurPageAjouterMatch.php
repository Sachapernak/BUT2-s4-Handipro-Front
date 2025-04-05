<?php

namespace Controleur;
require_once 'Config.php';

use DateTime;

class ControleurPageAjouterMatch
{
    /**
     * Constructeur de la classe. (Actuellement vide)
     */
    public function __construct() {}

    /**
     * Crée un nouveau match et l'ajoute à la base de données en récupérant les données depuis une requête POST.
     * Redirige vers la page des matchs si succès, sinon affiche une alerte.
     *
     * @return int|null L'identifiant du match créé, ou null en cas d'erreur.
     */
    public function creerUnMatch(): ?int
    {
        $date_match = $_POST['date'];
        $heure_match = $_POST['heure'];

        $dateTimeString = $date_match . ' ' . $heure_match;
        $dateTime = new DateTime($dateTimeString);
        $dateTimeFormatted = $dateTime->format('Y-m-d H:i');

        $adversaire = $_POST['adversaire'];
        $lieu = $_POST['lieu'];

        $match = [
            "date_et_heure" => $dateTimeFormatted,
            "adversaire"    => $adversaire,
            "lieu"          => $lieu,
        ];

        $url = BACKURL . "matchs";

        $response = \Controleur\MethodesCurl::callAPI("POST", $url, $match);
        $result = json_decode($response, true);

        if ($result && $result["status_code"] != 200) {
            echo '<script type="text/javascript">window.alert("' . $result['status_message'] . '");</script>';
            return null;
        } else {
            header('Location: Matchs.php');
            return $result["data"]["id_match"];
        }
    }

    /**
     * Vérifie si la date et l'heure données sont supérieures à la date et heure actuelles.
     *
     * @return bool `true` si la date/heure est dans le futur, `false` sinon.
     */
    public function verifierDate(): bool
    {
        $dateHeureMin = new DateTime();
        $date_match = $_POST['date'];
        $heure_match = $_POST['heure'];
        $dateTimeString = $date_match . ' ' . $heure_match;
        $dateHeureDonnee = new DateTime($dateTimeString);
        return $dateHeureDonnee > $dateHeureMin;
    }
}
