<?php

namespace Controleur;


use DAO\JouerDAO;
use DAO\JoueurDAO;
use Controleur\RechercherJouer;
use Controleur\RechercherUnJoueur;

use Modele\Joueur;
use Modele\Jouer;


class ControleurPageSaisieNote
{

    private $jouerDAO;
    private $joueurDAO;

     /**
     * Constructeur de la classe ControleurPageSaisieNote.
     * Initialise les objets DAO utilisés pour interagir avec les données des joueurs et des matchs.
     */
    public function __construct()
    {
         $this->jouerDAO = new JouerDAO();
         $this->joueurDAO = new JoueurDAO();
    }


    /**
     * Modifie la note d'un joueur pour un match donné.
     *
     * @param int $idMatch L'identifiant du match.
     * @param int $n_licence Le numéro de licence du joueur.
     * @return Jouer|null Retourne l'objet Jouer mis à jour après modification.
     */
    public function modifierJouer($idMatch, $n_licence): ?Jouer
    {
        $note = $_POST["note"];

        $recherche = new RechercherJouer($this->jouerDAO, $n_licence,$idMatch);
        $jouer = $recherche->executer();

        $jouer->setNote($note);

        $modifierJouer = new ModifierAttributsJouer($this->jouerDAO, $jouer);
        $modifierJouer->executer();

        header('Location: Matchs.php');

        return $this->jouerDAO->findById($n_licence,$idMatch);
    }

     /**
     * Récupère les informations d'un joueur pour un match donné.
     *
     * @param int $idMatch L'identifiant du match.
     * @param int $n_licence Le numéro de licence du joueur.
     * @return Jouer|null Retourne l'objet Jouer contenant les informations du joueur pour ce match ou null s'il n'est pas trouvé.
     */
    public function recupererInfosJouer($idMatch, $n_licence): ?Jouer{
        $recherche = new RechercherJouer($this->jouerDAO, $n_licence ,$idMatch);
        $jouer = $recherche->executer();

        return $jouer;
    }

    /**
     * Récupère les informations d'un joueur en fonction de son numéro de licence.
     *
     * @param int $n_licence Le numéro de licence du joueur.
     * @return Joueur|null Retourne l'objet Joueur correspondant à la licence donnée et null s'il n'est pas trouvé.
     */
    public function recupererInfosJoueur($n_licence): ?Joueur{
        $recherche = new RechercherUnJoueur($this->joueurDAO, $n_licence);	
        $joueur = $recherche->executer();

        return $joueur;
    }


}

?>