<?php

namespace Controleur;
require_once 'Config.php';

class ControleurPageSaisieDuScore {



    /**
     * Constructeur de la classe ControleurPageSaisieDuScore.
     * Initialise l'objet MatchDAO utilisé pour interagir avec la base de données des matchs.
     */
    public function __construct()
    {

    }

    /**
     * Enregistre le score d'un match dans la base de données après qu'il ait été soumis via un formulaire.
     *
     * @param int $id_match L'identifiant du match dont le score doit être saisi.
     */
    public function saisirScore($id_match)
    {
        $score = $_POST['resultat'];

        $scoreArray  = array(
            "resultat" => $score,
        );

        $data = "?id=$id_match";
        $url = BACKURL."EndPointMatch.php".$data;
        $response = \Controleur\MethodesCurl::callAPI("PATCH", $url, $scoreArray);
        $result = json_decode($response, true);
        header('Location: Matchs.php');
        exit;

    }

     /**
     * Récupère les informations d'un match en utilisant son identifiant.
     *
     * @param int $idMatch L'identifiant du match à récupérer.
     * @return array  L'objet match correspondant à l'identifiant.
     */
    public function recupererInfosMatch($idMatch): ?array {
        $data = "?action=getMatch&id=$idMatch";
        $url = BACKURL."EndPointMatch.php".$data;
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result;

    }

    /**
     * Affiche une description du lieu du match en fonction de sa valeur.
     * 
     * @param string $lieu Le lieu du match ('ext' pour extérieur, 'dom' pour domicile).
     * @return string Le texte décrivant le lieu du match.
     */
    public function afficherLieu($lieu){
        $resultat = "";
        switch ($lieu) {
            case "ext":
                $resultat = "Extérieur";
                break;
            case "dom":
                $resultat = "A domicile";
                break;
            default: 
                $resultat = "$lieu";
                break;
        }
        return $resultat;
    }


}

?>