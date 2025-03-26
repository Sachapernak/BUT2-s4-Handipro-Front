<?php

namespace Controleur;

use DateTime;

use DAO\MatchDAO;
use Modele\MatchBasket;



class ControleurPageModifierMatch
{

    private $matchDAO;


    /**
     * Constructeur de la classe ControleurPageModifierMatch.
     * Initialise l'objet MatchDAO utilisé pour interagir avec la base de données des matchs.
     */
    public function __construct()
    {
         $this->matchDAO = new MatchDAO();
    }


     /**
     * Modifie un match existant dans la base de données avec les nouvelles informations soumises via un formulaire.
     *
     * @param int $idMatch L'identifiant du match à modifier.
     * @return MatchBasket|null Les informations mises à jour du match.
     */
    public function modifierMatch($idMatch): ?MatchBasket
    {
        // Récupération des données du formulaire
        $date_match = $_POST['date'];
        $heure_match = $_POST['heure'];

        // Fusionner la date et l'heure pour créer un DateTime valide
        $dateTimeString = $date_match . ' ' . $heure_match; 
        $dateTime = new DateTime($dateTimeString);
        $dateTimeFormatted = $dateTime->format('Y-m-d H:i:s');
        
        // Récupération des autres informations du match
        $adversaire = $_POST['adversaire'];
        $lieu = $_POST['lieu'];

        // Recherche du match à modifier via son identifiant et modification du match
        $recherche = new RechercherUnMatch($this->matchDAO, $idMatch);
        $match = $recherche->executer();
        $match->setDate_et_heure($dateTimeFormatted);
        $match->setAdversaire($adversaire);
        $match->setLieu($lieu);

        $modifiermatch = new ModifierMatch($this->matchDAO, $match);
        $modifiermatch->executer();

        header('Location: Matchs.php');

        return $this->matchDAO->findById($idMatch);
    }

    /**
     * Récupère les informations d'un match en utilisant son identifiant.
     *
     * @param int $idMatch L'identifiant du match à récupérer.
     * @return Match|null L'objet match correspondant à l'identifiant ou null s'il n'est pas trouvé.
     */
    public function recupererInfosMatch($idMatch): ?MatchBasket{
        $recherche = new RechercherUnMatch($this->matchDAO, $idMatch);
        $match = $recherche->executer();

        return $match;
    }

}

?>