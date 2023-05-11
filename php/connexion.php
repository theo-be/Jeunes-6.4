<?php

require_once "Compte.php";

session_start();



// verification des donnees entrantes
if (!isset($_POST["email"])) {
    echo "ERREUR : données manquantes";
} else {
    $contenufichier = file_get_contents("../data/bdd.json");

    $bdd = json_decode($contenufichier, false);

    $nombrecomptes = count($bdd->comptes);

    $compteexiste = 0;

    for ($i = 0; $i < $nombrecomptes; $i++) {
        if ($bdd->comptes[$i]->email == $_POST["email"]) {
            $compteexiste = 1;
            $_SESSION["statut_client"] = "jeune";
            $_SESSION["nom"] = $bdd->comptes[$i]->nom;
            $_SESSION["prenom"] = $bdd->comptes[$i]->prenom;
            $_SESSION["email"] = $bdd->comptes[$i]->email;
            $_SESSION["datenaissance"] = $bdd->comptes[$i]->datenaissance;
            $_SESSION["savoiretre"] = $bdd->comptes[$i]->savoiretre;
            $_SESSION["duree"] = $bdd->comptes[$i]->duree;
            $_SESSION["engagements"] = $bdd->comptes[$i]->engagements;

            break;
        }
    }

    if (!$compteexiste) {
        $_SESSION["erreur"] = 1;
        $_SESSION["messageerreur"] = "Erreur : le compte n'existe pas";
    }

}


header("Location: ../web/jeune.php");


?>

