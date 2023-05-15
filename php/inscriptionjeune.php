<?php
session_start();
require_once "verifsession.php";
require_once "Compte.php";
require_once "cherchecompte.php";

if (!(isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["datenaissance"]) && isset($_POST["email"]) & isset($_POST["engagement"]) && isset($_POST["duree"]) && isset($_POST["savoiretre"]))) {
    // erreur
    $_SESSION["erreur"] = 1;
    $_SESSION["messageerreur"] = "ERREUR : formulaire corompu";
} else {
    $contenufichier = file_get_contents("../data/bdd.json");
    $bdd = json_decode($contenufichier, false);
    $idcompte = chercheCompteJeune($bdd, $_POST["email"]);

    $bdd->comptejeune[$idcompte]->nom = htmlspecialchars($_POST["nom"]);
    $bdd->comptejeune[$idcompte]->prenom = htmlspecialchars($_POST["prenom"]);
    $bdd->comptejeune[$idcompte]->email = htmlspecialchars($_POST["email"]);
    $bdd->comptejeune[$idcompte]->datenaissance = htmlspecialchars($_POST["datenaissance"]);
    $bdd->comptejeune[$idcompte]->reseau = htmlspecialchars($_POST["reseau"]);
    $bdd->comptejeune[$idcompte]->engagement = htmlspecialchars($_POST["engagement"]);
    $bdd->comptejeune[$idcompte]->duree = htmlspecialchars($_POST["duree"]);
    $bdd->comptejeune[$idcompte]->savoiretre = $_POST["savoiretre"];
    $bdd->comptejeune[$idcompte]->complet = 1;




    $_SESSION["nom"] = htmlspecialchars($_POST["nom"]);
    $_SESSION["prenom"] = htmlspecialchars($_POST["prenom"]);
    $_SESSION["email"] = htmlspecialchars($_POST["email"]);
    $_SESSION["datenaissance"] = htmlspecialchars($_POST["datenaissance"]);
    $_SESSION["engagement"] = htmlspecialchars($_POST["engagement"]);
    $_SESSION["duree"] = htmlspecialchars($_POST["duree"]);
    $_SESSION["reseau"] = htmlspecialchars($_POST["reseau"]);
    $_SESSION["savoiretre"] = $_POST["savoiretre"];

    $_SESSION["comptecomplet"] = 1;





    // sauvegarde
    $contenufichier = json_encode($bdd, JSON_PRETTY_PRINT);
    file_put_contents("../data/bdd.json", $contenufichier);
}
















header("Location: ../web/jeune.php");

?>