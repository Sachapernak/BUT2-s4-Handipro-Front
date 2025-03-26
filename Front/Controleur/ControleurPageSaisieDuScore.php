<?php

namespace Controleur;

use DAO\MatchDAO;
use Controleur\ModifierMatch;
use Controleur\RechercherUnMatch;
use Modele\Matchbasket;

class ControleurPageSaisieDuScore {

    private $matchDAO;

    /**
     * Constructeur de la classe ControleurPageSaisieDuScore.
     * Initialise l'objet MatchDAO utilisé pour interagir avec la base de données des matchs.
     */
    public function __construct()
    {
        $this->matchDAO = new MatchDAO();
    }

    /**
     * Enregistre le score d'un match dans la base de données après qu'il ait été soumis via un formulaire.
     *
     * @param int $id_match L'identifiant du match dont le score doit être saisi.
     */
    public function saisirScore($id_match)
    {
        $score = $_POST['resultat'];

        $match = $this->recupererInfosMatch($id_match);
        
        $match->setResultat($score);

        $misAJour = new ModifierMatch($this->matchDAO, $match); 
        $misAJour->executer();

        header('Location: Matchs.php');
        exit;

    }

     /**
     * Récupère les informations d'un match en utilisant son identifiant.
     *
     * @param int $idMatch L'identifiant du match à récupérer.
     * @return mixed L'objet match correspondant à l'identifiant.
     */
    public function recupererInfosMatch($idMatch): ?MatchBasket{
        $recherche = new RechercherUnMatch($this->matchDAO, $idMatch);
        $match = $recherche->executer();

        return $match;
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
                $resultat = "Erreur";
                break;
        }
        return $resultat;
    }


}

?>