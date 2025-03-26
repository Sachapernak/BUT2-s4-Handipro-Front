<?php

namespace Controleur;

use DAO\JoueurDAO;
use DAO\JouerDAO;

use Controleur\ObtenirTousLesJoueurs;
use Controleur\RechercherParAttributsJoueurs;
use Controleur\ObtenirMoyenneNoteJoueur;

class ControleurPageJoueurs
{

    private $joueurDAO;
    private $jouerDAO;

     /**
     * Constructeur de la classe. Initialise les DAO nécessaires pour gérer les joueurs et leurs relations.
     */
    public function __construct(){
        $this->joueurDAO = null;
        $this->jouerDAO = null;
    }

     /**
     * Récupère tous les joueurs disponibles en base de données.
     *
     * @return array Un tableau contenant les joueurs.
     */
    public function getJoueurs() : ?array {
       /*
        $obtenirTousLesJoueurs = new ObtenirTousLesJoueurs($this->joueurDAO);
        return $obtenirTousLesJoueurs->executer();
       */
        return null;

    }

    /**
     * Récupère la note moyenne d'un joueur à partir de son numéro de licence.
     *
     * @param string $n_licence Le numéro de licence du joueur.
     * @return int La note moyenne du joueur.
     */
    public function getNoteMoyenneJoueur($n_licence): int{
        /*
        $obtenirMoyenneNoteJoueur = new ObtenirMoyenneNoteJoueur($this->jouerDAO, $n_licence);
        return $obtenirMoyenneNoteJoueur->executer();
        */
        return 0;
    }

    /**
     * Génère une chaîne représentant les étoiles correspondant à la note moyenne d'un joueur.
     *
     * ★ pour les étoiles pleines, ☆ pour les étoiles vides.
     *
     * @param string $n_licence Le numéro de licence du joueur.
     * @return string Une chaîne contenant les étoiles.
     */
    public function afficherEtoiles($n_licence) : string {
        $etoile = ""; 
        $nbrEtoilesTotal = 5;
        $note = $this->getNoteMoyenneJoueur($n_licence);
        for ($i = 0; $i < $note; $i++) {
            $etoile.= "★";
        }
        $etoilesVides = $nbrEtoilesTotal - $note;
        for ($i = 0; $i < $etoilesVides; $i++) {
            $etoile.= "☆";
        }

        return $etoile;
    }

    // TODO : CHANGER LA SPEC : On prend une note et le transforme en etoile

     /**
     * Effectue une recherche de joueurs en fonction de critères spécifiques.
     *
     * @param string $recherche Les critères de recherche.
     * @return array Les résultats correspondant aux critères.
     */
    public function resultatRecherche($recherche): ?array{
        /*
        $rechercherJoueurs = new RechercherParAttributsJoueurs($this->joueurDAO, $recherche);
        return $rechercherJoueurs->executer();
        */
        return null;
    }
}

?>