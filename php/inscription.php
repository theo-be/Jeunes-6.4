<?php

require_once "Compte.php";



session_start();
// recuperation des donnees du formulaire d'inscription
$_SESSION["erreur"] = 0;
$_SESSION["messageerreur"] = "";

// verification des donnees d'entree
// donees minimum necessaires
if (!(isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["datenaissance"]) && isset($_POST["email"]))) { 
    // erreur donnees manquantes
    echo "ERREUR : données manquantes\n";
} else {


    $contenufichier = file_get_contents("../data/bdd.json");
    $bdd = json_decode($contenufichier, false);
    

    $nombrecomptes = count($bdd->comptes);

    // Verification de la presence du compte
    for ($i = 0; $i < $nombrecomptes; $i++) {
        if ($bdd->comptes[$i]->email == $_POST["email"] 
        || ($bdd->comptes[$i]->nom == $_POST["nom"] && $bdd->comptes[$i]->prenom == $_POST["prenom"])) {
            $_SESSION["erreur"] = 1;
            $_SESSION["messageerreur"] = "Erreur : compte deja inscrit";
            break;
        }
    }
    // s'il n'y a pas d'erreur
    if (!$_SESSION["erreur"]) {

        $compte = new Compte();
        $compte->nom = htmlspecialchars($_POST["nom"]);
        $compte->prenom = htmlspecialchars($_POST["prenom"]);
        $compte->email = htmlspecialchars($_POST["email"]);
        $compte->datenaissance = htmlspecialchars($_POST["datenaissance"]);



        $_SESSION["nom"] = htmlspecialchars($_POST["nom"]);
        $_SESSION["prenom"] = htmlspecialchars($_POST["prenom"]);
        $_SESSION["email"] = htmlspecialchars($_POST["email"]);
        $_SESSION["datenaissance"] = htmlspecialchars($_POST["datenaissance"]);
        $_SESSION["referent"] = 0;

        array_push($bdd->comptes, $compte);
        $contenufichier = json_encode($bdd);

        file_put_contents("../data/bdd.json", $contenufichier);




        $_SESSION["statut_client"] = "jeune";
    }
}

header("Location: ../web/jeune.php");
?>