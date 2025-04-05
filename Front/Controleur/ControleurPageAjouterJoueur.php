<?php

namespace Controleur;
require_once "Config.php";

class ControleurPageAjouterJoueur
{
    /**
     * Constructeur de la classe. (Vide par défaut, prévu pour de futures extensions)
     */
    public function __construct() {}

    /**
     * Ajoute un joueur dans la base de données via l'API backend.
     *
     * Les données sont récupérées depuis un formulaire POST.
     *
     * @return array|null Résultat de l'appel API (succès ou message d'erreur).
     */
    public function ajouterJoueur(): ?array
    {
        $n_licence       = (int) $_POST['licence'];
        $nom             = $_POST['nom'];
        $prenom          = $_POST['prenom'];
        $statutComplet   = $_POST['statut'];
        $statut          = substr($statutComplet, 0, 3);
        $date_naissance  = $_POST['date_naissance'];
        $taille          = (int) $_POST['taille'];
        $poids           = $_POST['poids'];

        $joueur = [
            "n_licence"         => $n_licence,
            "nom"               => $nom,
            "prenom"            => $prenom,
            "date_de_naissance" => $date_naissance,
            "taille"            => $taille,
            "poids"             => $poids,
            "statut"            => $statut
        ];

        $url = BACKURL . "joueurs"; // Endpoint propre via htaccess

        $response = \Controleur\MethodesCurl::callAPI("POST", $url, $joueur);
        $result = json_decode($response, true);

        return $result;
    }
}
