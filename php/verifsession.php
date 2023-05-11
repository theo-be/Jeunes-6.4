<?php

if (!isset($_SESSION["statut_client"]))
    $_SESSION["statut_client"] = "visiteur";

if (!isset($_SESSION["erreur"]))
    $_SESSION["erreur"] = 0;

if (!isset($_SESSION["messageerreur"]))
    $_SESSION["messageerreur"] = "";


?>