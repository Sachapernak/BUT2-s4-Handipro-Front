<?php

namespace Controleur;

use DateTime;


class ControleurPageAjouterMatch
{
    private $matchDAO;

    /**
     * Constructeur de la classe. Initialise le DAO pour les matchs.
     */
    public function __construct()
    {
         $this->matchDAO = new MatchDAO();
    }



    /**
     * Crée un nouveau match et l'ajoute à la base de données en récupérant les données depuis une requête POST.
     * 
     * @return int L'identifiant du match créé.
     */
    public function creerUnMatch() {
        $date_match = $_POST['date'];
        $heure_match = $_POST['heure'];

        $dateTimeString = $date_match . ' ' . $heure_match; 
        $dateTime = new DateTime($dateTimeString);
        $dateTimeFormatted = $dateTime->format('Y-m-d H:i:s');

        $adversaire = $_POST['adversaire'];
        $lieu = $_POST['lieu'];

        $match = new MatchBasket($dateTimeFormatted, $adversaire,$lieu);


        /* ajouter jouer*/

        $creationMatch = new CreerUnMatch($this->matchDAO, $match);
        $idMatch = $creationMatch->executer();
        header('Location: Matchs.php');
        return $idMatch;

    }

    /**
     * Vérifie si la date et l'heure données sont supérieures ou égales à la date et l'heure actuelles.
     * Si la date et l'heure données sont dans le passé, la fonction retourne 'false' et 'true' sinon.
     * 
     * @return bool Retourne `true` si la date et l'heure données sont supérieurs à la date et l'heure actuelles, sinon `false`.
     */
    public function verifierDate(): bool {
        $dateHeureMin = new DateTime(); 
        $date_match = $_POST['date'];
        $heure_match = $_POST['heure'];
        $dateTimeString = $date_match . ' ' . $heure_match;
        $dateHeureDonnee = new DateTime($dateTimeString);
        return $dateHeureDonnee > $dateHeureMin;
    }


}

?>