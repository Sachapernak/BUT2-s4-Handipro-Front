<?php 

namespace Vue;

session_start();
$auth = $_SESSION['authentifie'] ?? false;
if (!$auth) {
    header('Location: page-connexion.php');
    exit;
} else if (!isset($_COOKIE['jwt_token'])) {
    header('Location: page-connexion.php');
    exit;
}
?>