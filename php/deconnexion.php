<?php

if (!isset($_SESSION)) session_start();
// réinitialisation de la session
$_SESSION = array();
session_destroy();

header("Location:/web/accueil.php");


?>
