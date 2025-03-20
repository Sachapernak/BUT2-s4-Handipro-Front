<?php

namespace Controleur;

use Controleur\ModifierJoueur;
use DAO\JoueurDAO;
use DAO\CommentaireDAO;
use Controleur\ObtenirTousLesCommentaires;
use Modele\Commentaire;
use Modele\Joueur;
use DAO\JouerDAO;
use Controleur\RechercherJouerParJoueur;
use Controleur\RechercherUnCommentaire;
use Controleur\SupprimerUnJoueur;

class ControleurPageConsulterInfosJoueur 
{
    private $joueurDAO;

    private $jouerDAO;
    private $commentaireDAO;


    /**
     * Constructeur de la classe. Initialise les DAO nécessaires.
     */
    public function __construct()
    {
        $this->joueurDAO = new JoueurDAO();
        $this->jouerDAO = new JouerDAO();
        $this->commentaireDAO = new commentaireDAO();

    }

    /**
     * Récupère un joueur à partir de son numéro de licence.
     *
     * @param string $n_licence Le numéro de licence du joueur.
     * @return Joueur Le joueur correspondant.
     */
    public function recupererJoueur($n_licence): Joueur {
        $rechercherUnJoueur = new RechercherUnJoueur($this->joueurDAO, $n_licence);
        $joueur = $rechercherUnJoueur->executer();
        return $joueur;
    }

    /**
     * Récupère tous les commentaires associés à un joueur.
     *
     * @return array Un tableau de commentaires pour le joueur.
     */
    public function recupererCommentaires() {
        $n_licence = $_GET['nLicence'];

        $obtenirTousLesCommentaires = new ObtenirTousLesCommentaires($this->commentaireDAO, $n_licence);
        return $obtenirTousLesCommentaires->executer();
    }

    /**
     * Ajoute un commentaire pour un joueur.
     *
     * @return void
     */
    public function ajouterCommentaire(){
        $n_licence = $_GET['nLicence'];
        $commentaireSaisi = $_POST['commentaire'];
        $date = date('Y-m-d'); 

        $commentaire = new Commentaire($n_licence, $date, $commentaireSaisi);

        $creationCommentaire = new CreerUnCommentaire($this->commentaireDAO, $commentaire);
        $creationCommentaire->executer();
    }


     /**
     * Met à jour les informations d'un joueur.
     *
     * @return Joueur Le joueur mis à jour.
     */
    public function mettreAJourJoueur()
    {
        $n_licence = $_GET['nLicence'];

        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $statutComplet = $_POST['statut'];
        $statut = substr($statutComplet, 0, 3);
        $date_naissance = $_POST['date_naissance'];
        $taille = $_POST['taille'];
        $poids = $_POST['poids'];

        $joueur = $this->joueurDAO->findById($n_licence);
        $joueur->setNom($nom);
        $joueur->setPrenom($prenom);
        $joueur->setStatut($statut);
        $joueur->setTaille($taille);
        $joueur->setPoids($poids);
        $joueur->setDate_de_naissance($date_naissance);


        $modifierJoueur = new ModifierJoueur($this->joueurDAO, $joueur);
        $modifierJoueur->executer();

        return $this->joueurDAO->findById($n_licence);
    }

    /**
     * Vérifie si un joueur peut être supprimé (possible s'il n'a jamais participé à un match).
     *
     * @param string $n_licence Le numéro de licence du joueur.
     * @return bool True si le joueur peut être supprimé, False sinon.
     */
    public function peutEtreSupprime($n_licence){
        $recherche = new RechercherJouerParJoueur($this->jouerDAO, $n_licence);
        $res = $recherche->executer();
        return empty($res);
    }

     /**
     * Supprime un joueur de la base de données.
     *
     * @param string $n_licence Le numéro de licence du joueur.
     * @return void
     */
    public function supprimerJoueur($n_licence) {
        $suppression = new SupprimerUnJoueur($this->joueurDAO, $n_licence);
        $suppression->executer();
        header('Location: Joueurs.php');
    }

    public function estCommentaireExistant(): bool {
        $n_licence = $_GET['nLicence'];
        $date = date('Y-m-d'); 

        $rechercherUnCommentaire = new RechercherUnCommentaire($this->commentaireDAO, $n_licence, $date);
        $res = $rechercherUnCommentaire->executer();
        
        return $res!=null; 
    }

}


?>