<?php

namespace Controleur;
require_once 'Config.php';
use DateTime;


class ControleurPageAjouterMatch
{


    /**
     * Constructeur de la classe. Initialise le DAO pour les matchs.
     */
    public function __construct()
    {

    }



    /**
     * Crée un nouveau match et l'ajoute à la base de données en récupérant les données depuis une requête POST.
     * 
     * @return int L'identifiant du match créé.
     */
    public function creerUnMatch() {
        $date_match = $_POST['date'];
        $heure_match = $_POST['heure'];

        $dateTimeString = $date_match . ' ' . $heure_match; 
        $dateTime = new DateTime($dateTimeString);
        $dateTimeFormatted = $dateTime->format('Y-m-d H:i');

        $adversaire = $_POST['adversaire'];
        $lieu = $_POST['lieu'];


        $match = array(
            "date_et_heure" => $dateTimeFormatted,
            "adversaire"=> $adversaire,
            "lieu" => $lieu,
        );

        $data = "";
        $url = BACKURL."EndPointMatch.php".$data;
        $response = \Controleur\MethodesCurl::callAPI("POST", $url, $match);
        $result = json_decode($response, true);

        if ($result && $result["status_code"] != 200){
            echo '<script type="text/javascript">window.alert("'.$result['status_message'].'");</script>';
            return null;
        } else {
            header('Location: Matchs.php');
            return $result["data"]["id_match"];
        }




    }

    /**
     * Vérifie si la date et l'heure données sont supérieures ou égales à la date et l'heure actuelles.
     * Si la date et l'heure données sont dans le passé, la fonction retourne 'false' et 'true' sinon.
     * 
     * @return bool Retourne `true` si la date et l'heure données sont supérieurs à la date et l'heure actuelles, sinon `false`.
     */
    public function verifierDate(): bool {
        $dateHeureMin = new DateTime(); 
        $date_match = $_POST['date'];
        $heure_match = $_POST['heure'];
        $dateTimeString = $date_match . ' ' . $heure_match;
        $dateHeureDonnee = new DateTime($dateTimeString);
        return $dateHeureDonnee > $dateHeureMin;
    }


}

?>