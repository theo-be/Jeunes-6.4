<?php

if (!isset($_SESSION)) session_start();
$_SESSION = array();
session_destroy();

// detruire les cookies

header("Location:/web/accueil.php");


?>