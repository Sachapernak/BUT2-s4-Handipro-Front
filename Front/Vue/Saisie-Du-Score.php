<?php
require_once 'autoload.php';
require 'Verif-Auth.php';
use Controleur\ControleurPageSaisieDuScore;

$controleur = new ControleurPageSaisieDuScore();

//recuperer l'identifiant du match 
$idMatch = $_GET['idMatch'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controleur->saisirScore($idMatch);
}

//Recuperer les informations du match qui seront affichées
$match = $controleur->recupererInfosMatch($idMatch);
$date = $match->getDate();
$heure = $match->getHeure();
$adversaire = $match->getAdversaire();
$lieu = $match->getlieu();


$valeurDefaut = $match->getResultat();  //S'il a déjà été saisi, il permet le pré-remplissage du champs de formulaire

?>


<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="CSS/Saisie-Du-Score-Style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>Handi-Team Manager</title>
</head>

<body>

    <?php include "barre-navigation.php" ?>

    <div class="main">

        <!-- Informations relatives au match--> 
        <div class="infos-match">
            <h2>Rappel du match</h2>

            <div class="match-item">
                <div class="ligne-info">
                    <label for="id_match">Identifiant :</label>
                    <p><?php echo $idMatch; ?></p>
                </div>
                <div class="ligne-info">
                    <label for="date-et-heure">Date et heure :</label>
                    <p><?php echo $date . ' ' . $heure; ?></p>
                </div>
                <div class="ligne-info">
                    <label for="adversaire">Adversaire :</label>
                    <p><?php echo $adversaire; ?></p>
                </div>
                <div class="ligne-info">
                    <label for="lieu">Lieu :</label>
                    <p><?php echo $controleur->afficherLieu($lieu); ?></p>
                </div>

            </div>

            <!-- Formulaire de saisie du score-->
            <div class="score-form">
                <h2>Saisir le score</h2>
                <form action="Saisie-Du-Score.php?idMatch=<?php echo urlencode($idMatch); ?>" method="POST">

                    <label for="resultat">Resultat :</label>
                    <select id="resultat" name="resultat">
                        <option value="V" <?php echo ($valeurDefaut === "V") ? "selected" : ""; ?>>Victoire</option>
                        <option value="D" <?php echo ($valeurDefaut === "D") ? "selected" : ""; ?>>Défaite</option>
                        <option value="N" <?php echo ($valeurDefaut === "N") ? "selected" : ""; ?>>Match nul</option>
                    </select>

                    <div class="form-buttons">
                        <button type="submit" class="btn btn-valider">Valider</button>
                        <button type="button" class="btn btn-annuler"
                            onclick="window.location.href='Matchs.php'">Annuler</button>
                    </div>
                </form>
            </div>

        </div>
</body>

</html>