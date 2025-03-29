<?php

namespace Controleur;
require_once 'Config.php';
use DateTime;



class ControleurPageModifierMatch
{

    private $matchDAO;


    /**
     * Constructeur de la classe ControleurPageModifierMatch.
     * Initialise l'objet MatchDAO utilisé pour interagir avec la base de données des matchs.
     */
    public function __construct()
    {

    }


     /**
     * Modifie un match existant dans la base de données avec les nouvelles informations soumises via un formulaire.
     *
     * @param int $idMatch L'identifiant du match à modifier.
     * @return array|null Les informations mises à jour du match.
     */
    public function modifierMatch($idMatch): ?array
    {
        // Récupération des données du formulaire
        $date_match = $_POST['date'];
        $heure_match = $_POST['heure'];

        // Fusionner la date et l'heure pour créer un DateTime valide
        $dateTimeString = $date_match . ' ' . $heure_match; 
        $dateTime = new DateTime($dateTimeString);
        $dateTimeFormatted = $dateTime->format('Y-m-d H:i');
        
        // Récupération des autres informations du match
        $adversaire = $_POST['adversaire'];
        $lieu = $_POST['lieu'];

        $match = array(
          "date_et_heure" => $dateTimeFormatted,
          "adversaire"=> $adversaire,
          "lieu" => $lieu,
          "resultat" => null
        );

        // Recherche du match à modifier via son identifiant et modification du match
        $data = "?id=$idMatch";
        $url = BACKURL."EndPointMatch.php".$data;
        $response = \Controleur\MethodesCurl::callAPI("PUT", $url, $match);
        $result = json_decode($response, true);

        if ($result["status_code"] != 200){
            echo '<script type="text/javascript">window.alert("'.$result['status_message'].'");</script>';
        } else {
            header('Location: Matchs.php');
        }


        return $result;
    }

    /**
     * Récupère les informations d'un match en utilisant son identifiant.
     *
     * @param int $idMatch L'identifiant du match à récupérer.
     * @return array|null L'objet match correspondant à l'identifiant ou null s'il n'est pas trouvé.
     */
    public function recupererInfosMatch($idMatch): ?array{
        $data = "?action=getMatch&id=$idMatch";
        $url = BACKURL."EndPointMatch.php".$data;
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result;

    }

}

?>