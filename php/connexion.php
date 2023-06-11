<?php

require_once "Compte.php";
require_once "cherchecompte.php";

session_start();



// verification des donnees entrantes
if (!isset($_POST["email"])) {
    echo "ERREUR : données manquantes";
} else {
    // chargement de la base de données
    $contenufichier = file_get_contents("../data/bdd.json");

    $bdd = json_decode($contenufichier, false);

    $nombrecomptesjeunes = count($bdd->comptejeune);
    $nombrecomptesref = count($bdd->compteref);

    $idjeune = chercheCompteJeune($bdd, $_POST["email"]);
    $compteexiste = 0;
    if ($idjeune != -1) {
        if (password_verify($_POST["mdp"], $bdd->comptejeune[$idjeune]->mdp)) {
            // si le mot de passe est bon, chargement du compte
            $compteexiste = 1;
            $_SESSION["statut_client"] = "jeune";
            $_SESSION["nom"] = $bdd->comptejeune[$idjeune]->nom;
            $_SESSION["prenom"] = $bdd->comptejeune[$idjeune]->prenom;
            $_SESSION["email"] = $bdd->comptejeune[$idjeune]->email;
            $_SESSION["emailconsultant"] = $bdd->comptejeune[$idjeune]->emailconsultant;
            $_SESSION["datenaissance"] = $bdd->comptejeune[$idjeune]->datenaissance;
            $_SESSION["reseau"] = $bdd->comptejeune[$idjeune]->reseau;
            $_SESSION["savoiretre"] = $bdd->comptejeune[$idjeune]->savoiretre;
            $_SESSION["duree"] = $bdd->comptejeune[$idjeune]->duree;
            $_SESSION["engagement"] = $bdd->comptejeune[$idjeune]->engagement;
            $_SESSION["comptecomplet"] = $bdd->comptejeune[$idjeune]->complet;
            $_SESSION["idcompte"] = $bdd->comptejeune[$idjeune]->id;
            // messages d'erreur
            $_SESSION["erreur"] = 0;
            $_SESSION["messageerreur"] = "";
        } else {
            // messages d'erreur
            $_SESSION["erreur"] = 1;
            $_SESSION["messageerreur"] = "Erreur : mdp incorrect";
        }


    }

    // messages d'erreur

    if (!$compteexiste) {
        $_SESSION["erreur"] = 1;
        $_SESSION["messageerreur"] = "Erreur : le compte n'existe pas";
    }

}


header("Location: /web/jeune.php");


?>

