<?php

namespace Controleur;
require_once "Config.php";

class ControleurPageAjouterJoueur
{


    /**
     * Constructeur de la classe. Initialise le DAO pour les joueurs.
     */
    public function __construct()
    {

    }

    /**
     * Ajoute un joueur en base de données
     *
     * Récupère les informations passées en POST pour
     * créer le joueur a l'aide de l'API en Back
     * */
    public function ajouterJoueur(): ?array
    {
            $n_licence = (int) $_POST['licence'];
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $statutComplet = $_POST['statut'];
            $statut = substr($statutComplet, 0, 3);
            $date_naissance = $_POST['date_naissance'];
            $taille = (int) $_POST['taille'];
            $poids = $_POST['poids'];

            $joueur = [
                "n_licence"         => $n_licence,       // entier
                "nom"               => $nom,             // string
                "prenom"            => $prenom,          // string
                "date_de_naissance" => $date_naissance,  // string
                "taille"            => $taille,          // entier
                "poids"             => $poids,           // string
                "statut"            => $statut           // string
            ];

            $url = BACKURL . "EndPointJoueur.php";

            $response = \Controleur\MethodesCurl::callAPI("POST", $url, $joueur);
            $result = json_decode($response, true);

            return $result;
    }
}


?>