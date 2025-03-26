<?php

namespace Controleur;

use DateTime;

require_once "Config.php";


class ControleurPageAccueil
{


     /**
     * Constructeur de la classe. Initialise les DAO pour les joueurs, les participations (jouerDAO), les matchs et les commentaires.
     */
    public function __construct(){

    }

    /**
     * Récupère les informations d'un manager par son ID.
     *
     * @param string $idManager L'identifiant du manager.
     * @return string Le prénom et le nom du manager, ou une chaîne vide si non trouvé.
     */
    public function infoPageAccueil(string $idManager): string
    {
        // Données à envoyer en GET
        $data = "?action=manager&id=" . $idManager;
        // URL de l'API de connexion
        $url = BACKURL . "EndPointManager.php" . $data;
        // Appel de l'API via GET en utilisant la méthode callAPI
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);

        // Décodage de la réponse JSON
        $result = json_decode($response, true);

        // Vérification que 'data' existe et contient bien les clés attendues
        if (isset($result['data']['prenom']) && isset($result['data']['nom'])) {
            $prenom = $result['data']['prenom'];
            $nom = $result['data']['nom'];

            return $prenom . " " . $nom;
        }
        // En cas d'erreur, retourner une chaîne vide ou gérer l'erreur autrement
        return "";
    }

     /**
     * Récupère les matchs récents (les deux derniers matchs passés).
     * 
     * @return array Un tableau contenant les deux derniers matchs récents.
     */
    public function getMatchsRecents (){

        // Données à envoyer en GET
        $data = "?action=getMatchsRecents";

        // URL de l'API de connexion
        $url = BACKURL."EndPointMatch.php".$data;

        // Appel de l'API via POST en utilisant la méthode callAPI
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);

        // Décodage de la réponse JSON
        $result = json_decode($response, true);

        return $result['data'];
    }

     /**
     * Récupère le meilleur joueur d'un match donné (soit le joueur ayant la plus haute note).
     * 
     * @param int $idMatch L'identifiant du match.
     * @return array | null L'objet joueur représentant le meilleur joueur ou null s'il n'existe pas.
     */
    public function getMeilleurJoueur ($idMatch){

        // Données à envoyer en GET
        $data = "?action=getMeilleurJoueurMatch&id=" . $idMatch;

        // URL de l'API de connexion
        $url = BACKURL."EndPointMatch.php".$data;

        // Appel de l'API via POST en utilisant la méthode callAPI
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);

        // Décodage de la réponse JSON
        $result = json_decode($response, true);
        return $result['data'];

    }

    /**
     * Récupère le commentaire pour un joueur spécifique lors d'un match donné.
     * 
     * @param string $n_licence Le numéro de licence du joueur.
     * @param string $dateMatch La date du match.
     * @return string Le commentaire ou une chaîne vide s'il n'existe pas.
     */
    public function getCommentaireJoueur ($n_licence, $dateMatch) {

        if ($n_licence == null || $dateMatch == null) {
            return "Pas de commentaire";
        }

        $dateDuMatch = new DateTime($dateMatch);
            // Données à envoyer en GET
        $data = "?action=getCommentaireJoueur&id=".$n_licence;

        // URL de l'API de connexion
        $url = BACKURL."EndPointJoueur.php".$data;

        // Appel de l'API via POST en utilisant la méthode callAPI
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);

        // Décodage de la réponse JSON
        $result = json_decode($response, true);

        if ($result['data'] != null){
            foreach($result['data'] as $commentaire){
                $dateDuCom = new DateTime($commentaire['date']);
                if ($dateDuCom->format('Y-m-d') == $dateDuMatch->format('Y-m-d')) {
                    return $commentaire['commentaire'];
                }
            }
        }

        return "Pas de commentaire";
    }

    /**
     * Récupère les informations de participation d'un joueur à un match donné.
     * 
     * @param string $n_licence Le numéro de licence du joueur.
     * @param int $id_match L'identifiant du match.
     * @return array | null Un objet représentant la participation ou null si non trouvée.
     */
    public function getParticipation ($n_licence, $id_match):?Array {
        // Données à envoyer en GET

        $data = "?action=getInfosParticipation&idM=$id_match&idJ=$n_licence";

        // URL de l'API de connexion
        $url = BACKURL."EndPointParticipation.php".$data;

        // Appel de l'API via POST en utilisant la méthode callAPI
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);

        // Décodage de la réponse JSON
        $result = json_decode($response, true);
        return $result == null ? null : $result["data"];

    }



    /**
     * Affiche le lieu d'un match sous forme de texte.
     * 
     * @param string $lieu Le lieu brut (dom, ext).
     * @return string Le texte correspondant (à domicile, à l'extérieur).
     */
    public function afficherLieu($lieu): string{
        switch ($lieu) {
            case 'ext':
                return 'à l\'extérieur';
            case 'dom':
                return 'à domicile';
            default: 
                return '';
        }
    }


    /**
     * Récupère les joueurs actifs
     * 
     * @return array Un tableau contenant les joueurs actifs.
     */
    public function getJoueursActifs(){
        // Données à envoyer en GET
        $data = "?action=getJoueursActifs";

        // URL de l'API de connexion
        $url = BACKURL."EndPointJoueur.php".$data;

        // Appel de l'API via POST en utilisant la méthode callAPI
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);

        // Décodage de la réponse JSON
        $result = json_decode($response, true);

        return $result['data'];
    }
}