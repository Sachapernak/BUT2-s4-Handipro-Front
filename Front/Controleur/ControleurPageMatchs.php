<?php

namespace Controleur;

use DAO\JoueurDAO;
use DAO\MatchDAO;
use DAO\JouerDAO;
use Controleur\RechercherJouerParMatch;
use Controleur\RechercherMatchsAVenir;
use Controleur\SupprimerUnMatch;
use Modele\Jouer;

use DateTime;

class ControleurPageMatchs
{

    private $joueurDAO;
    private $jouerDAO;
    private $matchDAO;

    /**
     * Constructeur de la classe ControleurPageMatchs.
     * Initialise les DAO nécessaires pour gérer les joueurs, les matchs et les participations.
     */
    public function __construct()
    {
        $this->joueurDAO = new JoueurDAO();
        $this->jouerDAO = new JouerDAO();
        $this->matchDAO = new MatchDAO();
    }

    /**
     * Récupère les joueurs participants à un match donné.
     *
     * @param int $id_match L'identifiant du match.
     * @return array Un tableau d'objets Joueur représentant les joueurs participants.
     */
    public function getJoueursParticipants($id_match)
    {
        $resultat = [];
        $recherche = new RechercherJouerParMatch($this->jouerDAO, $id_match);
        $listeMatchsJoues = $recherche->executer();
        foreach ($listeMatchsJoues as $jouer) {
            $n_licence = $jouer->getN_licence();
            $recherche = new RechercherUnJoueur($this->joueurDAO, $n_licence);
            $joueur = $recherche->executer();

            $resultat[] = $joueur;
        }

        return $resultat;
    }

    /**
     * Récupère les informations de participation d'un joueur pour un match donné.
     *
     * @param int $id_match L'identifiant du match.
     * @param string $id_joueur Le numéro de licence du joueur.
     * @return Jouer Les informations de participation du joueur au match.
     */
    public function getInfosParticipants($id_match, $id_joueur): ?Jouer
    {
        $recherche = new RechercherJouer($this->jouerDAO, $id_joueur, $id_match);
        $resultat = $recherche->executer();
        return $resultat;

    }


    /**
     * Récupère les matchs à venir par rapport à la date actuelle.
     *
     * @return array La liste des matchs à venir.
     */
    public function getMatchsAVenir()
    {
        $recherche = new RechercherMatchsAVenir($this->matchDAO, date('Y-m-d'));
        $res = $recherche->executer();
        return $res;
    }


    /**
     * Récupère les matchs passés par rapport à la date actuelle.
     *
     * @return array La liste des matchs passés.
     */
    public function getMatchsPasses()
    {
        $recherche = new RechercherMatchsPasses($this->matchDAO, date('Y-m-d'));
        $res = $recherche->executer();
        return $res;
    }

    /**
     * Affiche une chaîne d'étoiles en fonction de la note donnée.
     *
     * @param int $note La note du joueur.
     * @return string La représentation des étoiles.
     */
    public function afficherEtoiles($note): string
    {
        $etoile = "";
        $nbrEtoilesTotal = 5;
        for ($i = 0; $i < $note; $i++) {
            $etoile .= "★";
        }
        $etoilesVides = $nbrEtoilesTotal - $note;
        for ($i = 0; $i < $etoilesVides; $i++) {
            $etoile .= "☆";
        }

        return $etoile;
    }

    /**
     * Affiche le statut d'un joueur (titulaire ou remplaçant).
     *
     * @param int $estRemplacant 1 pour remplaçant, 0 pour titulaire.
     * @return string Le statut du joueur.
     */
    public function afficherRemplacement($estRemplacant)
    {
        $resultat = "";
        switch ($estRemplacant) {
            case 1:
                $resultat = "Remplacant";
                break;
            case 0:
                $resultat = "Titulaire";
                break;
        }
        return $resultat;
    }

    /**
     * Supprime un match donné de la base de données.
     *
     * @param int $idMatch L'identifiant du match à supprimer.
     */
    public function supprimerMatch($idMatch): void
    {
        $suppression = new SupprimerUnMatch($this->matchDAO, $idMatch);
        $suppression->executer();
    }

    /**
     * Affiche le résultat d'un match basé sur un code (V, D, N).
     *
     * @param string $score Le code du score (V = victoire, D = défaite, N = match nul).
     * @return string Le résultat sous forme de texte.
     */
    public function afficherResultat($score){
        $resultat = "";
        switch ($score) {
            case "V":
                $resultat = "Victoire";
                break;
            case "D":
                $resultat = "Défaite";
                break;
            case "N":
                $resultat = "Match nul";
                break;
            default: 
                $resultat = "N\A";
                break;
        }
        return $resultat;
    }

    /**
     * Affiche le lieu du match basé sur un code (dom ou ext).
     *
     * @param string $lieu Le code du lieu (dom = domicile, ext = extérieur).
     * @return string Le lieu sous forme de texte.
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
                $resultat = "N\A";
                break;
        }
        return $resultat;
    }

     /**
     * Formate la date et l'heure d'un match.
     * 
     * @param Match $match L'objet match contenant la date et l'heure.
     * @return string La date et l'heure formatées (Y-m-d H:i).
     */
    public function afficherDateHeure($match){
        $dateTimeObj = new DateTime($match->getDate_et_heure());
        $date_heure = $dateTimeObj->format('Y-m-d H:i'); 
        return $date_heure;
    }

}

?>