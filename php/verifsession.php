<?php
// on initialise plusieurs variables qui sont utilisées partout sur le site

if (!isset($_SESSION["statut_client"]))
    $_SESSION["statut_client"] = "visiteur";

if (!isset($_SESSION["erreur"]))
    $_SESSION["erreur"] = 0;

if (!isset($_SESSION["messageerreur"]))
    $_SESSION["messageerreur"] = "";
if (!isset($_SESSION["nbreferent"]))
    $_SESSION["nbreferent"] = 0;

    

?>
