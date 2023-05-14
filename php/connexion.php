<?php

require_once "Compte.php";
require_once "cherchecompte.php";

session_start();



// verification des donnees entrantes
if (!isset($_POST["email"])) {
    echo "ERREUR : données manquantes";
} else {
    $contenufichier = file_get_contents("../data/bdd.json");

    $bdd = json_decode($contenufichier, false);

    $nombrecomptes = count($bdd->comptes);

    $idjeune = chercheCompte($bdd, $_POST["email"]);
    $compteexiste = 0;
    if ($idjeune != -1) {
        // si le compte n'est pas un compte jeune
        if ($bdd->comptes[$idjeune]->type != "jeune") {
            $_SESSION["erreur"] = 1;
            $_SESSION["messageerreur"] = "ERREUR : tentative de connexion à un compte référent";
        } else {
            $compteexiste = 1;
            $_SESSION["statut_client"] = "jeune";
            $_SESSION["nom"] = $bdd->comptes[$idjeune]->nom;
            $_SESSION["prenom"] = $bdd->comptes[$idjeune]->prenom;
            $_SESSION["email"] = $bdd->comptes[$idjeune]->email;
            $_SESSION["datenaissance"] = $bdd->comptes[$idjeune]->datenaissance;
            $_SESSION["reseau"] = $bdd->comptes[$idjeune]->reseau;
            $_SESSION["savoiretre"] = $bdd->comptes[$idjeune]->savoiretre;
            $_SESSION["duree"] = $bdd->comptes[$idjeune]->duree;
            $_SESSION["engagement"] = $bdd->comptes[$idjeune]->engagement;

            // s'il y a au moins un referent
            if (($nombreliaison = count($bdd->comptes[$idjeune]->idliaison)) != 0) {
                $idreferent = $bdd->comptes[$idjeune]->idliaison[0];
                $_SESSION["referent"] = 1;
                $_SESSION["nomref"] = $bdd->comptes[$idreferent]->nom;
                $_SESSION["prenomref"] = $bdd->comptes[$idreferent]->prenom;
                $_SESSION["emailref"] = $bdd->comptes[$idreferent]->email;
                $_SESSION["datenaissanceref"] = $bdd->comptes[$idreferent]->datenaissance;
                $_SESSION["reseauref"] = $bdd->comptes[$idreferent]->reseau;
                $_SESSION["savoiretreref"] = $bdd->comptes[$idreferent]->savoiretre;
                $_SESSION["dureeref"] = $bdd->comptes[$idreferent]->duree;
                $_SESSION["presentationref"] = $bdd->comptes[$idreferent]->engagement;
            } else { // s'il n'y a aucun referent
                $_SESSION["referent"] = 0;
                $_SESSION["nomref"] = "";
                $_SESSION["prenomref"] = "";
                $_SESSION["emailref"] = "";
                $_SESSION["datenaissanceref"] = "";
                $_SESSION["reseauref"] = "";
                $_SESSION["savoiretreref"] = [];
                $_SESSION["dureeref"] = "";
                $_SESSION["presentationref"] = "";
            }
            $_SESSION["erreur"] = 0;
            $_SESSION["messageerreur"] = "";
        }


    }


    if (!$compteexiste) {
        $_SESSION["erreur"] = 1;
        $_SESSION["messageerreur"] = "Erreur : le compte n'existe pas";
    }

}


header("Location: ../web/jeune.php");


?>

