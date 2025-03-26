<?php
require_once 'autoload.php';
require 'Verif-Auth.php';
use Controleur\ControleurPageAjouterMatch;

$controleur = new ControleurPageAjouterMatch();

$blocErreur ="";

// Si le formulaire est soumis, on vérifie la date et si elle est correcte le match est ajouté, sinon un message d'erreur est affiché
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($controleur->verifierDate()) {
        $controleur->creerUnMatch();
    } else {
        //Affichage du message d'erreur
        $blocErreur = 
            '<div class="erreur">
                Vous ne pouvez pas créer un match déjà passé.
            </div>';
    }
}

?>


<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="CSS/Ajouter-Match-Style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>Handi-Team Manager</title>
</head>

<body>

    <?php include "barre-navigation.php" ?>
  
    <div class="main">

        <?php echo $blocErreur?>

        <div class="infos-match-container">
            <h2>Le match</h2>
            <!-- Formulaire d'ajout d'un match -->
            <form action="Ajouter-match.php" method="POST">
                <div class="match-item">
                    <label for="date-et-heure">Date et heure </label>
                    <input type="date" id="date" name="date" required>
                    <input type="time" id="heure" name="heure" required>
                </div>

                <div class="match-item">
                    <label for="adversaire">Adversaire :</label>
                    <input type="text" id="adversaire" name="adversaire" placeholder="Adversaire" required>

                    <label for="lieu">Lieu :</label>
                    <select id="lieu" name="lieu">
                        <option value="dom">A domicile</option>
                        <option value="ext">Extérieur</option>
                    </select>
                </div>

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