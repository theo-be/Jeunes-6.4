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

    $nombrecomptesjeunes = count($bdd->comptejeune);
    $nombrecomptesref = count($bdd->compteref);

    $idjeune = chercheCompteJeune($bdd, $_POST["email"]);
    $compteexiste = 0;
    if ($idjeune != -1) {
        if (password_verify($_POST["mdp"], $bdd->comptejeune[$idjeune]->mdp)) {
            $compteexiste = 1;
            $_SESSION["statut_client"] = "jeune";
            $_SESSION["nom"] = $bdd->comptejeune[$idjeune]->nom;
            $_SESSION["prenom"] = $bdd->comptejeune[$idjeune]->prenom;
            $_SESSION["email"] = $bdd->comptejeune[$idjeune]->email;
            $_SESSION["datenaissance"] = $bdd->comptejeune[$idjeune]->datenaissance;
            $_SESSION["reseau"] = $bdd->comptejeune[$idjeune]->reseau;
            $_SESSION["savoiretre"] = $bdd->comptejeune[$idjeune]->savoiretre;
            $_SESSION["duree"] = $bdd->comptejeune[$idjeune]->duree;
            $_SESSION["engagement"] = $bdd->comptejeune[$idjeune]->engagement;
            $_SESSION["comptecomplet"] = $bdd->comptejeune[$idjeune]->complet;
            $_SESSION["idcompte"] = $bdd->comptejeune[$idjeune]->id;

            // // s'il y a au moins un referent
            // if (($nombreliaison = count($bdd->comptejeune[$idjeune]->idref)) != 0) {
            //     $idreferent = $bdd->comptejeune[$idjeune]->idref[0];
            //     $_SESSION["nbreferent"]++;
            //     $_SESSION["nomref"] = $bdd->compteref[$idreferent]->nom;
            //     $_SESSION["prenomref"] = $bdd->compteref[$idreferent]->prenom;
            //     $_SESSION["emailref"] = $bdd->compteref[$idreferent]->email;
            //     $_SESSION["datenaissanceref"] = $bdd->compteref[$idreferent]->datenaissance;
            //     $_SESSION["reseauref"] = $bdd->compteref[$idreferent]->reseau;
            //     $_SESSION["savoiretreref"] = $bdd->compteref[$idreferent]->savoiretre;
            //     $_SESSION["dureeref"] = $bdd->compteref[$idreferent]->duree;
            //     $_SESSION["presentationref"] = $bdd->compteref[$idreferent]->presentation;
            // } else { // s'il n'y a aucun referent
            //     $_SESSION["nbreferent"] = 0;
            //     $_SESSION["nomref"] = "";
            //     $_SESSION["prenomref"] = "";
            //     $_SESSION["emailref"] = "";
            //     $_SESSION["datenaissanceref"] = "";
            //     $_SESSION["reseauref"] = "";
            //     $_SESSION["savoiretreref"] = [];
            //     $_SESSION["dureeref"] = "";
            //     $_SESSION["presentationref"] = "";
            // }
            $_SESSION["erreur"] = 0;
            $_SESSION["messageerreur"] = "";
        } else {
            $_SESSION["erreur"] = 1;
            $_SESSION["messageerreur"] = "Erreur : mdp incorrect";
        }


    }


    if (!$compteexiste) {
        $_SESSION["erreur"] = 1;
        $_SESSION["messageerreur"] = "Erreur : le compte n'existe pas";
    }

}


header("Location: ../web/jeune.php");


?>

