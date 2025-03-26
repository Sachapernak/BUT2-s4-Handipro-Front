<?php
// connexion.php

require_once 'autoload.php';
use Controleur\ControleurConnexion;

session_start();

$controleur = new ControleurConnexion();

$erreurMessage = $controleur->getMessageErreur();

$auth = $_SESSION['authentifie'] ?? false;
if (!$auth) {
    $btnDeco = "";
    $re = "";
} else {
    $btnDeco = '<input type="submit" value="Se deconnecter" name="decon" id="btn-rm">';
    $re = "re";
}

// Si la requête est de type POST (le formulaire a été soumis)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['connect'])){
        $login    = $_POST['login']    ?? '';
        $password = $_POST['password'] ?? '';
        $controleur->processLogin($login, $password);
    }

    if(isset($_POST['decon'])){
        session_destroy();
        header('Location: page-connexion.php');
    }
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/Connexion-Style.css">
    <title>Connexion</title>
</head>
<body>
<div class="flex-container">
    <div id="bloc-connexion">
        <div id="titre">
            <h2>Connexion</h2>
        </div>

        <!-- Le formulaire de connexion pointe vers la même page, qui traitera les données en POST -->
        <form method="post" action="">
            <div class="form-group">
                <label for="login">Nom d'utilisateur :</label>
                <input type="text" id="login" name="login" class="champs-saisi" required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" class="champs-saisi" required>
            </div>
            <?php if(!empty($erreurMessage)): ?>
                <div class="error-message">
                    <?php echo "<br>Erreur de connexion : ".$erreurMessage; ?>
                </div>
            <?php endif; ?>
            <input type="submit" value="Se <?php echo($re)?>connecter" name="connect" id="btn-submit">
        </form>
        <form method="post" action="">
            <?php echo($btnDeco); ?>
        </form>

    </div>
    <!-- Affichage du message d'erreur si non-null -->


</div>
</body>
</html>
