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
    public function infoPageAccueil($idManager) {
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
            // Optionnel : concaténer prénom et nom
            return $prenom . " " . $nom;
        }
        // En cas d'erreur, retourner une chaîne vide ou gérer l'erreur autrement
        return "";
    } // TODO : A TESTER. Devrait etre OK !

     /**
     * Récupère les matchs récents (les deux derniers matchs passés).
     * 
     * @return array Un tableau contenant les deux derniers matchs récents.
     */
    public function getMatchsRecents (){

        // Données à envoyer en GET
        $data = "?type_match="."recent";

        // URL de l'API de connexion
        $url = BACKURL."EndPointAccueil.php".$data;

        // Appel de l'API via POST en utilisant la méthode callAPI
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);

        // Décodage de la réponse JSON
        $result = json_decode($response, true);

        error_log("Match ".$result['data']);
        return $result['data'];
    }

     /**
     * Récupère le meilleur joueur d'un match donné (soit le joueur ayant la plus haute note).
     * 
     * @param int $idMatch L'identifiant du match.
     * @return array | null L'objet joueur représentant le meilleur joueur ou null s'il n'existe pas.
     */
    public function getMeilleurJoueur ($idMatch){

        $res = null;
       /* $n_licence = $this->jouerDAO->getMeilleurJoueurMatch($idMatch);
        
        if ($n_licence != null){
            $recherche = new RechercherUnJoueur($this->joueurDAO, $n_licence);
            $res = $recherche->executer();
        }
        */
        return $res;  
    }

    /**
     * Récupère le commentaire pour un joueur spécifique lors d'un match donné.
     * 
     * @param string $n_licence Le numéro de licence du joueur.
     * @param string $dateMatch La date du match.
     * @return string Le commentaire ou une chaîne vide s'il n'existe pas.
     */
    public function getCommentaireJoueur ($n_licence, $dateMatch) {
       /*
        $recherche = new RechercherUnCommentaire($this->commentaireDAO, $n_licence, $dateMatch);
        $res = $recherche->executer();
        if($res) {
            return $res->getCommentaire();
        }
       */
        return "";
    }

    /**
     * Récupère les informations de participation d'un joueur à un match donné.
     * 
     * @param string $n_licence Le numéro de licence du joueur.
     * @param int $id_match L'identifiant du match.
     * @return J|null Un objet représentant la participation ou null si non trouvée.
     */
    public function getParticipation ($n_licence, $id_match):?Array {
        $res = null;
        /*
        $recherche = new RechercherJouer($this->jouerDAO, $n_licence, $id_match);
        $res = $recherche->executer();
        */
        return $res;
    }

    /**
     * Affiche le résultat d'un match sous forme de texte.
     * 
     * @param string $resultat Le résultat brut (V, N, D).
     * @return string Le texte correspondant (Victoire, Match nul, Défaite).
     */
    public function afficherResultat ($resultat): string {
        switch ($resultat) {
            case 'N':
                return 'Match nul';
            case 'V':
                return 'Victoire';
            case 'D':
                return 'Défaite';
            default:
                return '';
        }
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
     * Formate la date et l'heure d'un match.
     * 
     * @param  $match L'objet match contenant la date et l'heure.
     * @return string La date et l'heure formatées (Y-m-d H:i).
     */
    public function afficherDateHeure($date){
        $dateTimeObj = new DateTime($date);
        $date_heure = $dateTimeObj->format('Y-m-d H:i'); 
        return $date_heure;

    }

    /**
     * Récupère les joueurs actifs
     * 
     * @return array Un tableau contenant les joueurs actifs.
     */
    public function getJoueursActifs(){
        /*
        $res = $this->joueurDAO->findByStatut('Act');
        return $res;
        */
    }
}