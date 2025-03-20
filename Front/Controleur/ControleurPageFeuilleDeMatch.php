<?php

namespace Controleur;

use DAO\JoueurDAO;
use DAO\MatchDAO;
use DAO\JouerDAO;
use DAO\CommentaireDAO;
use Controleur\RechercherJoueursActifs;
use Controleur\RechercherJouerParMatch;
use Controleur\SupprimerJouerParticipantsMatch;
use Controleur\ObtenirTousLesCommentaires;

use Modele\Jouer;


class ControleurPageFeuilleDeMatch
{
    private $joueurDAO;
    private $jouerDAO;
    private $matchDAO;
    private $commentaireDAO;
    private $controleurJoueursParticipants;

     /**
     * Constructeur de la classe. Initialise les DAO nécessaires.
     */
    public function __construct()
    {
        $this->joueurDAO = new JoueurDAO();
        $this->jouerDAO = new JouerDAO();
        $this->matchDAO = new MatchDAO();
        $this->commentaireDAO = new CommentaireDAO();

        $this->controleurJoueursParticipants = new ControleurPageMatchs();
    }

    

    /**
     * Crée une participation (relation joueur-match).
     *
     * @param Jouer $jouer L'objet Jouer à insérer.
     */
    public function creerParticipation($jouer): void
    {
        $creationMatch = new CreerJouer($this->jouerDAO, $jouer);
        $creationMatch->executer();
    }

      /**
     * Supprime une participation pour un joueur et un match donnés.
     *
     * @param string $n_licence Le numéro de licence du joueur.
     * @param int $id_match L'identifiant du match.
     */
    public function supprimerParticipation($n_licence, $id_match): void
    {
        $creationMatch = new SupprimerJouer($this->jouerDAO, $n_licence, $id_match);
        $creationMatch->executer();
    }


    /**
     * Met à jour la table jouer qui contient les participations des joueurs pour un match.
     *
     * @param array $joueursSelectionnes Tableau des joueurs sélectionnés.
     * @param int $id_match L'identifiant du match.
     */
    public function actualiserParticipation(array $joueursSelectionnes, $id_match): void
    {
        print_r($joueursSelectionnes);
        $this->viderJoueurPourUnMatch($id_match);
        for($i = 0; $i < count($joueursSelectionnes); $i++) {
            $n_licence = $joueursSelectionnes[$i]['licence'];
            $position = $joueursSelectionnes[$i]['position'];
            $role = $joueursSelectionnes[$i]['role'];
            $jouer = new Jouer($n_licence, $id_match, $role, null, $position);
            $this->creerParticipation($jouer);
        }
        header('Location: Matchs.php');
    }

    /**
     * Supprime toutes les participations des joueurs pour un match donné.
     *
     * @param int $id_match L'identifiant du match.
     */
    public function viderJoueurPourUnMatch($id_match)
    {
        $suppression = new SupprimerJouerParticipantsMatch($this->jouerDAO, $id_match);
        $suppression->executer();
    }


     /**
     * Récupère la liste des joueurs actifs.
     *
     * @return array Un tableau de joueurs actifs.
     */
    public function getJoueursActifs(): array
    {
        $recherche = new RechercherJoueursActifs($this->joueurDAO, 'act');
        return $recherche->executer();

    }

    /**
     * Vérifie si les titulaires ont les positions minimales requises.
     *
     * @param array $joueursSelectionnes Tableau des joueurs sélectionnés.
     * @return bool True si les positions requises sont respectées, False sinon.
     */
    public function verifierPositionTitulaires(array $joueursSelectionnes): bool
    {
        $positionMeneur = 'Meneur';
        $positionAilier = 'Ailier';
        $positionPivot = 'Pivot';
        $countMeneur = 0;
        $countAilier = 0;
        $countPivot = 0;

        foreach ($joueursSelectionnes as $jouer) {
            if ($jouer['position'] === $positionMeneur && $jouer['role'] === '0') {
                $countMeneur++;
            }
            if ($jouer['position'] === $positionAilier && $jouer['role'] === '0') {
                $countAilier++;
            }
            if ($jouer['position'] === $positionPivot && $jouer['role'] === '0') {
                $countPivot++;
            }
        }
        return $countMeneur == 1 && $countAilier == 2 && $countPivot == 2;
    }

    
     /**
     * Vérifie si au moins 5 joueurs sont sélectionnés.
     *
     * @param array $joueurs Tableau des joueurs sélectionnés.
     * @return bool True si 5 joueurs ou plus sont sélectionnés, False sinon.
     */
    public function verifierTailleJoueursSelec(array $joueurs): bool
    {
        return count($joueurs) >= 5;
    }

    /**
     * Récupère tous les commentaires associés à un joueur.
     *
     * @param string $n_licence Le numéro de licence du joueur.
     * @return string Les commentaires formatés en HTML.
     */
    public function getCommentairesJoueur($n_licence)
    {
        $obtenirTousLesCommentaires = new ObtenirTousLesCommentaires($this->commentaireDAO, $n_licence);
        $commentaires = $obtenirTousLesCommentaires->executer();

        $tousLesCommentaires = "";

        foreach ($commentaires as $commentaire) {
            $tousLesCommentaires .= "<p>" . $commentaire->getDate(). " : " . $commentaire->getCommentaire(). "</p> <br>";
        }
        return $tousLesCommentaires;
    }

     /**
     * Récupère les informations de participation des joueurs pour un match.
     *
     * @param int $idMatch L'identifiant du match.
     * @return array La liste des joueurs participants.
     */
    public function getInfosParticipation($idMatch)
    {
        $recherche = new RechercherJouerParMatch($this->jouerDAO, $idMatch);
        $listeJoueursParticipants = $recherche->executer();
        return $listeJoueursParticipants;
    }

}

?>