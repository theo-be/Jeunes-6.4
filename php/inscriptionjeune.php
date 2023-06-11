<?php
session_start();
require_once "verifsession.php";
require_once "Compte.php";
require_once "cherchecompte.php";

if (!(isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["datenaissance"]) && isset($_POST["email"]) & isset($_POST["engagement"]) && isset($_POST["duree"]) && isset($_POST["savoiretre"]))) {
    // erreur données manquantes
    $_SESSION["erreur"] = 1;
    $_SESSION["messageerreur"] = "ERREUR : formulaire corompu";
} else if ((isset($_POST["email"]) && !preg_match('#([0-9a-z]){3,}@([a-z]){2,}.([a-z]){2,4}$#i', $_POST["email"])) || 
(isset($_POST["emailconsultant"]) && !preg_match('#([0-9a-z]){3,}@([a-z]){2,}.([a-z]){2,4}$#i', $_POST["emailconsultant"]))) {
    // erreur email
    $_SESSION["erreur"] = 1;
    $_SESSION["messageerreur"] = "ERREUR : addresse email dans la mauvais format";
} else if ((isset($_POST["email"]) && !preg_match('#^([0-9]{2}/){2}[0-9]{4}$#', $_POST["datenaissance"]))) {
    // erreur date de naissance
    $_SESSION["erreur"] = 1;
    $_SESSION["messageerreur"] = "ERREUR : date de naissance dans le mauvais format, format JJ/MM/AAAA";
} else {




    // chargement de la base de données
    $contenufichier = file_get_contents("../data/bdd.json");
    $bdd = json_decode($contenufichier, false);
    $idcompte = chercheCompteJeune($bdd, trim($_POST["email"]));
    
    // modification du compte

    $bdd->comptejeune[$idcompte]->nom = htmlspecialchars(trim($_POST["nom"]));
    $bdd->comptejeune[$idcompte]->prenom = htmlspecialchars(trim($_POST["prenom"]));
    $bdd->comptejeune[$idcompte]->email = htmlspecialchars(trim($_POST["email"]));
    $bdd->comptejeune[$idcompte]->emailconsultant = htmlspecialchars(trim($_POST["emailconsultant"]));
    $bdd->comptejeune[$idcompte]->datenaissance = htmlspecialchars(trim($_POST["datenaissance"]));
    $bdd->comptejeune[$idcompte]->reseau = htmlspecialchars(trim($_POST["reseau"]));
    $bdd->comptejeune[$idcompte]->engagement = htmlspecialchars(trim($_POST["engagement"]));
    $bdd->comptejeune[$idcompte]->duree = htmlspecialchars(trim($_POST["duree"]));
    $bdd->comptejeune[$idcompte]->savoiretre = $_POST["savoiretre"];
    $bdd->comptejeune[$idcompte]->complet = 1;




    $_SESSION["nom"] = htmlspecialchars(trim($_POST["nom"]));
    $_SESSION["prenom"] = htmlspecialchars(trim($_POST["prenom"]));
    $_SESSION["email"] = htmlspecialchars(trim($_POST["email"]));
    $_SESSION["emailconsultant"] = htmlspecialchars(trim($_POST["emailconsultant"]));
    $_SESSION["datenaissance"] = htmlspecialchars(trim($_POST["datenaissance"]));
    $_SESSION["engagement"] = htmlspecialchars(trim($_POST["engagement"]));
    $_SESSION["duree"] = htmlspecialchars(trim($_POST["duree"]));
    $_SESSION["reseau"] = htmlspecialchars(trim($_POST["reseau"]));
    $_SESSION["savoiretre"] = $_POST["savoiretre"];

    $_SESSION["comptecomplet"] = 1;







    // sauvegarde
    $contenufichier = json_encode($bdd, JSON_PRETTY_PRINT);
    file_put_contents("../data/bdd.json", $contenufichier);
}
















header("Location: ../web/jeune.php");

?>
