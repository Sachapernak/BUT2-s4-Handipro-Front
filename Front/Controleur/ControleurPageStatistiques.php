<?php

namespace Controleur;

use DAO\JoueurDAO;
use DAO\MatchDAO;
use DAO\JouerDAO;

use Modele\Joueur;



class ControleurPageStatistiques
{

    private $joueurDAO;
    private $jouerDAO;
    private $matchDAO;

    /**
     * Constructeur de la classe ControleurPageStatistiques.
     * Initialise les objets DAO utilisés pour interagir avec les données des joueurs, des matchs et des participations.
     */
    public function __construct()
    {
        $this->joueurDAO = new JoueurDAO();
        $this->jouerDAO = new JouerDAO();
        $this->matchDAO = new MatchDAO();
    }

     /**
     * Récupère le total des victoires.
     *
     * @return int Retourne le nombre total de victoires.
     */
    public function getTotalVictoires(): int
    {
        $total = $this->matchDAO->getTotalVictoires();
        return $total;
    }

     /**
     * Récupère le total des défaites.
     *
     * @return int Retourne le nombre total de défaites.
     */
    public function getTotalDefaites(): int
    {
        $total = $this->matchDAO->getTotalDefaites();
        return $total;
    }

     /**
     * Récupère le total des matchs nuls.
     *
     * @return int Retourne le nombre total de matchs nuls.
     */
    public function getTotalNuls(): int
    {
        $total = $this->matchDAO->getTotalNuls();
        return $total;
    }

     /**
     * Calcule le pourcentage de victoires.
     *
     * @return float Retourne le pourcentage de victoires arrondi à deux décimales.
     */
    public function getPourcentVictoires(): float
    {
        $nbVictoires = $this->getTotalVictoires();
        $nbMatchs = $this->matchDAO->getTotalMatchs();
        if ($nbMatchs == 0) {
            return 0.0;
        }

        $pourcentageVictoires = ($nbVictoires / $nbMatchs) * 100;

        return round($pourcentageVictoires, 2);

    }

    /**
     * Calcule le pourcentage de défaites.
     *
     * @return float Retourne le pourcentage de défaites arrondi à deux décimales.
     */
    public function getPourcentDefaites(): float
    {
        $nbDefaites = $this->getTotalDefaites();
        $nbMatchs = $this->matchDAO->getTotalMatchs();
        if ($nbMatchs == 0) {
            return 0.0;
        }

        $pourcentageDefaites = ($nbDefaites / $nbMatchs) * 100;

        return round($pourcentageDefaites, 2);

    }

     /**
     * Calcule le pourcentage de matchs nuls.
     *
     * @return float Retourne le pourcentage de matchs nuls arrondi à deux décimales.
     */
    public function getPourcentNuls(): float
    {
        $nbNuls = $this->getTotalNuls();
        $nbMatchs = $this->matchDAO->getTotalMatchs();
        if ($nbMatchs == 0) {
            return 0.0;
        }

        $pourcentageNuls = ($nbNuls / $nbMatchs) * 100;

        return round($pourcentageNuls,2);
    }

      /**
     * Récupère le poste favori d'un joueur (le poste le plus joué par le joueur).
     *
     * @param Joueur $joueur Objet Joueur pour lequel le poste favori doit être récupéré.
     * @return string Retourne le poste favori du joueur.
     */
    public function getPosteFavoris(Joueur $joueur): string{
        $n_licence = $joueur->getN_licence();
        $posteFav = $this->jouerDAO->getPositionFavoriteJoueur($n_licence);
        return $posteFav;
    }

    /**
     * Récupère le nombre de titularisations d'un joueur.
     *
     * @param Joueur $joueur Objet Joueur pour lequel le nombre de titularisations doit être récupéré.
     * @return int Retourne le nombre de titularisations du joueur.
     */
    public function getTitularisations(Joueur $joueur): int{
        $n_licence = $joueur->getN_licence();
        $titularisation = $this->jouerDAO->getTitularisationsJoueur($n_licence);
        return $titularisation;
    }

      /**
     * Récupère le nombre de remplacements d'un joueur.
     *
     * @param Joueur $joueur Objet Joueur pour lequel le nombre de remplacements doit être récupéré.
     * @return int Retourne le nombre de remplacements du joueur.
     */
    public function getRemplacements(Joueur $joueur): int{
        $n_licence = $joueur->getN_licence();
        $titularisation = $this->jouerDAO->getRemplacementsJoueur($n_licence);
        return $titularisation;
    }

    /**
     * Récupère la moyenne des évaluations d'un joueur.
     *
     * @param Joueur $joueur Objet Joueur pour lequel la moyenne des évaluations doit être récupérée.
     * @return float Retourne la moyenne des évaluations du joueur, arrondie à deux décimales.
     */
    public function getMoyenneEval(Joueur $joueur): float {
        $n_licence = $joueur->getN_licence();
        $moyenne = $this->jouerDAO->moyenneNoteJoueur($n_licence);

        $moyenne = round($moyenne, 2);

        if ($moyenne < 0 || $moyenne > 5) {
            return 0;
        }

        return $moyenne;
    }

    /**
     * Récupère le nombre de matchs consécutifs joués par un joueur.
     *
     * @param Joueur $joueur Objet Joueur pour lequel le nombre de matchs consécutifs doit être récupéré.
     * @return int Retourne le nombre de matchs consécutifs joués par le joueur.
     */
    public function getMatchsConsecutifs(Joueur $joueur): int{
        $n_licence = $joueur->getN_licence();
        $titularisation = $this->jouerDAO->getNbMatchsConsecutifsJoueur($n_licence);
        return $titularisation;
    }

      /**
     * Calcule le pourcentage de victoires pour un joueur spécifique.
     *
     * @param Joueur $joueur Objet Joueur pour lequel le pourcentage de victoires doit être calculé.
     * @return float Retourne le pourcentage de victoires du joueur, arrondi à deux décimales.
     */
    public function getPourcentVictoiresJoueur(Joueur $joueur): float{
        $n_licence = $joueur->getN_licence();
        
        $nbVicJoueurs = $this->jouerDAO->getNbVictoiresJoueur($n_licence);
        $nbMatchs = $this->matchDAO->getTotalMatchs();
        if ($nbMatchs == 0) {
            return 0.0;
        }

        $pourcentVic = ($nbVicJoueurs / $nbMatchs) * 100;
        return round($pourcentVic, 2);

        
    }




}

?>