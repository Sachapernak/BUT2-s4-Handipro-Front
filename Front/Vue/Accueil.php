<?php

require_once 'autoload.php';
require 'Verif-Auth.php';

use Controleur\ControleurPageAccueil;
use Controleur\ControleurPageJoueurs;

$idManager = $_POST["idmanager"] ?? " ";

$idManager = "KTomato";

$controleur = new ControleurPageAccueil();
$controleurJoueurs = new ControleurPageJoueurs();


$infoManager = $controleur->infoPageAccueil($idManager);

//Afficher les deux derniers matchs passés
$listeMatchs = $controleur->getMatchsRecents();
$matchs ="";
foreach ($listeMatchs as $match) {
    $id_match =$match["id_match"] ?? "";

    //Enregistrer dans les variables les informations nécessaires
    $resultat = $match["resultat"];
    $adversaire = $match["adversaire"] ?? "";
    $lieu = $match["lieu"] == null | $match["lieu"] == "" ? ", lieu non renseigné" : $match["lieu"];
    $date_heure = $match["date_et_heure"] ?? "";
    $bestJoueur = $controleur->getMeilleurJoueur($id_match);
    $n_licence = $bestJoueur == null ? "" : $bestJoueur["n_licence"] ?? "";

    $commentaire = $controleur->getCommentaireJoueur($n_licence, $date_heure);
    $participation = $controleur->getParticipation($n_licence, $id_match);
    $note= $participation == null ? 0 : $participation['note'];

   
    $matchs .= '
    <div class="match">
        <h4 class="matchTitle">' . $resultat . '</h4>
        <p class="matchText">[Notre Equipe] vs ' . $adversaire . ' </p>
        <p class="matchText">Le ' . $date_heure . '  ' . $lieu . '</p>
        <h4 class="matchTextMJ">Meilleur joueur :</h4>
        <div class="mj">
            <div>
                <h5>' . ($bestJoueur == null ? "N/A":$bestJoueur["nom"]) . ' ' . ($bestJoueur == null ? "":$bestJoueur["prenom"]) . '</h5> 
                <span>' . str_repeat('★', ($note == "" || $note == null) ? 0 : $note) . str_repeat('☆', 5 - (($note == "" || $note == null) ? 0 : $note)) . '</span>
                <p>' . $commentaire . '</p>
            </div>
        </div>
    </div>';
}

//Afficher la liste des joueurs actifs
$listeJoueurs = $controleur->getJoueursActifs();
$joueurs = "";

foreach ($listeJoueurs as $joueur) {
    $nom = $joueur["nom"];
    $prenom = $joueur["prenom"];
    $licence = $joueur["n_licence"];
    $note = $controleurJoueurs->getNoteMoyenneJoueur($licence);

    $joueurs .= '
    <div class="joueur">
        <div>
            <h5>' . $nom . ' ' . $prenom . '<span>' . str_repeat('★', (($note == "" || $note == null) ? 0 : $note)) . str_repeat('☆', 5 - (($note == "" || $note == null) ? 0 : $note)) . '</span>  </h5> 
            <h6> N° de licence : ' . $licence . '</h6>
        </div>
    </div>';
}

?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="CSS/Accueil-Style.css">
    <title>Handi-Team Manager</title>
</head>
    <body>



        <?php include "barre-navigation.php" ?>

        <!-- Page content -->
        <div class="main">
            <h2>Bienvenue sur Handi-Team Manager,</h2>
            <h3><?php echo($infoManager) ?></h3>

            <!-- Matchs -->
            <div class="MatchRecentTitre"><h3>Matchs récents :</h3></div>
            <div class="flexContainer">
                <?php echo($matchs); ?>
            </div>
            
            <!-- Joueurs Disponibles -->
            <div class="MatchRecentTitre"><h3>Joueurs disponibles :</h3></div>
            <div class="flexContainer">
                <?php echo($joueurs); ?>
            </div>

        </div>
    </body>
</html>
