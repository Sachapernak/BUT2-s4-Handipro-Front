<?php

namespace Controleur;
require_once 'Config.php';

class ControleurPageSaisieNote
{


     /**
     * Constructeur de la classe ControleurPageSaisieNote.
     * Initialise les objets DAO utilisés pour interagir avec les données des joueurs et des matchs.
     */
    public function __construct()
    {

    }


    /**
     * Modifie la note d'un joueur pour un match donné.
     *
     * @param int $idMatch L'identifiant du match.
     * @param int $n_licence Le numéro de licence du joueur.
     * @return array |null Retourne l'objet Jouer mis à jour après modification.
     */
    public function modifierJouer($idMatch, $n_licence): ?array
    {
        $note = $_POST["note"];


        $scoreArray  = array(
            "note" => $note,
        );

        $data = "?action=modifierNoteParticipation&idJ=$n_licence&idM=$idMatch";
        $url = BACKURL."EndPointParticipation.php".$data;
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
     * @return array |null Retourne l'objet Jouer contenant les informations du joueur pour ce match ou null s'il n'est pas trouvé.
     */
    public function recupererInfosJouer($idMatch, $n_licence): ?array {

        $data = "?action=getInfosParticipation&idM=$idMatch&idJ=$n_licence";
        $url = BACKURL."EndPointParticipation.php".$data;
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result;
    }

    /**
     * Récupère les informations d'un joueur en fonction de son numéro de licence.
     *
     * @param int $n_licence Le numéro de licence du joueur.
     * @return array|null Retourne l'objet Joueur correspondant à la licence donnée et null s'il n'est pas trouvé.
     */
    public function recupererInfosJoueur($n_licence): ?array{

        $data = "?action=recupererJoueur&id=$n_licence";
        $url = BACKURL."EndPointJoueur.php".$data;
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result;
    }


}

?>