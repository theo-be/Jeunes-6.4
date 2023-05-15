<?php

require_once "Compte.php";
require_once "cherchecompte.php";



session_start();
// recuperation des donnees du formulaire d'inscription
$_SESSION["erreur"] = 0;
$_SESSION["messageerreur"] = "";

// verification des donnees d'entree
// donees minimum necessaires
if (!(isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["datenaissance"]) && isset($_POST["email"]))) { 
    // erreur
    $_SESSION["erreur"] = 1;
    $_SESSION["messageerreur"] = "ERREUR : formulaire corompu";
} elseif ($_POST["mdp"] != $_POST["mdpc"]) { // si les mdp ne sont pas les memes
    $_SESSION["erreur"] = 1;
    $_SESSION["messageerreur"] = "Erreur : les mots de passe sont différents";
} else {
    $_SESSION["erreur"] = 0;
    $_SESSION["messageerreur"] = "";

    $contenufichier = file_get_contents("../data/bdd.json");
    $bdd = json_decode($contenufichier, false);
    

    $nombrecomptes = count($bdd->comptejeune);

    // Verification de la presence du compte
    if (chercheCompteJeune($bdd, $_POST["email"]) != -1 && $_SESSION["statut_client"] != "jeune") {
        $_SESSION["erreur"] = 1;
        $_SESSION["messageerreur"] = "Erreur : compte deja inscrit";
    }
    // s'il n'y a pas d'erreur
    if (!$_SESSION["erreur"]) {

        $compte = new CompteJeune();
        $compte->id = $bdd->prochain_id_jeune++;
        $compte->mdp = password_hash($_POST["mdp"], PASSWORD_DEFAULT);
        $compte->nom = htmlspecialchars($_POST["nom"]);
        $compte->prenom = htmlspecialchars($_POST["prenom"]);
        $compte->email = htmlspecialchars($_POST["email"]);
        $compte->datenaissance = htmlspecialchars($_POST["datenaissance"]);



        $_SESSION["nom"] = htmlspecialchars($_POST["nom"]);
        $_SESSION["prenom"] = htmlspecialchars($_POST["prenom"]);
        $_SESSION["email"] = htmlspecialchars($_POST["email"]);
        $_SESSION["datenaissance"] = htmlspecialchars($_POST["datenaissance"]);

        $_SESSION["nbreferent"] = 0;
        $_SESSION["comptecomplet"] = 0;
        $_SESSION["idcompte"] = $compte->id;



        $_SESSION["engagement"] = "";
        $_SESSION["duree"] = "";
        $_SESSION["reseau"] = "";
        $_SESSION["savoiretre"] = [];


        $_SESSION["nomref"] = "";
        $_SESSION["prenomref"] = "";
        $_SESSION["emailref"] = "";
        $_SESSION["datenaissanceref"] = "";
        $_SESSION["reseauref"] = "";
        $_SESSION["presentationref"] = "";
        $_SESSION["dureeref"] = "";
        $_SESSION["savoiretreref"] = [];

        array_push($bdd->comptejeune, $compte);
        $contenufichier = json_encode($bdd, JSON_PRETTY_PRINT);

        file_put_contents("../data/bdd.json", $contenufichier);




        $_SESSION["statut_client"] = "jeune";
    }
}

header("Location: ../web/jeune.php");
?>