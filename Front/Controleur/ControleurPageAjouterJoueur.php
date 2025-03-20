<?php

namespace Controleur;


class ControleurPageAjouterJoueur
{
    private $joueurDAO;


    /**
     * Constructeur de la classe. Initialise le DAO pour les joueurs.
     */
    public function __construct()
    {
        $this->joueurDAO = null;

    }

    /**
     * Ajoute un nouveau joueur à la base de données en récupérant les données depuis une requête POST.
     * 
     * @return void Cette méthode ne retourne rien. Elle redirige l'utilisateur après l'ajout.
     */
    public function ajouterJoueur(): void
    {

        $n_licence = $_POST['licence'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $statutComplet = $_POST['statut'];
        $statut = substr($statutComplet, 0, 3);
        $date_naissance = $_POST['date_naissance'];
        $taille = $_POST['taille'];
        $poids = $_POST['poids'];

        /*
        $joueur = new Joueur($n_licence, $nom, $prenom, $date_naissance,$taille, $poids, $statut);

        $creationJoueur = new CreerUnJoueur($this->joueurDAO, $joueur);
        $creationJoueur->executer();
        */

        header('Location: Joueurs.php');
    }
}


?>