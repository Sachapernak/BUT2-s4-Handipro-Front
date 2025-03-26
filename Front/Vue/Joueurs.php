<?php

require_once 'autoload.php';
require 'Verif-Auth.php';
use Controleur\ControleurPageJoueurs;

$controleur = new ControleurPageJoueurs();

//Permet la recherche d'un joueurà partir de la barre de recherche
if (isset($_POST['searchbar']) && !empty($_POST['searchbar'])) {
    $recherche = $_POST['searchbar']; 
    $listeJoueurs = $controleur->resultatRecherche($recherche);
} else {
    $listeJoueurs = $controleur->getJoueurs();
}

//récupérer l'ensemble des joueurs
$joueurs = ""; 

foreach ($listeJoueurs as $joueur) {
    $nom = $joueur->getNom();
    $prenom = $joueur->getPrenom();
    $nLicence = $joueur->getN_licence();
    $statut = $joueur->getIntituleStatut();
    $noteMoyenne = $controleur->afficherEtoiles($nLicence);
    
    $joueurs .= '
    <a class="divCliquable" href=".\Consulter-Infos-Joueur.php?nLicence=' . urlencode($nLicence) . '">
        <div class="joueur">
            <div>
                <h5>' . $nom . ' ' . $prenom . '</h5>
                <h6> N° de licence : ' . $nLicence . '</h6>
                <h6> Statut : ' . $statut . '</h6>
                <span> '. $noteMoyenne  .' </span> 
            </div>
        </div>
    </a>';
}
?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="CSS/Joueurs-Style.css">
    <title>Handi-Team Manager</title>
</head>

<body>

    <?php include "barre-navigation.php" ?>

    <div class="main">
        <h2>Vos joueurs</h2>

        <div class="en-tete">
            <!-- Formulaire de recherche d'un joueur selon son nom, prenom ou numéro de licence-->
            <form class="recherche" method="POST" action ="">
                <input type="text" id="search-bar" name="searchbar" placeholder="Rechercher un joueur...">
                <button type="submit" id="search-button">🔍</button>
            </form>

            <!-- Bouton permettant de rediriger vers la fenetre d'ajout d'un joueur-->
            <div class="boutons-ajout">
                <button id="btn-ajouter-joueur" onclick="window.location.href='Ajouter-Joueur.php'"> Nouveau Joueur</button>
            </div>
        </div>

        <div class="flexContainer">
            <?php echo $joueurs; ?>
        </div>

    </div>
</body>

</html>