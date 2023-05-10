<?php

session_start();
session_destroy();

// detruire les cookies

header("Location:../web/accueil.php");


?>