<?php

require_once "Compte.php";



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
} else {
    $_SESSION["erreur"] = 0;
    $_SESSION["messageerreur"] = "";

    $contenufichier = file_get_contents("../data/bdd.json");
    $bdd = json_decode($contenufichier, false);
    

    $nombrecomptes = count($bdd->comptes);

    // Verification de la presence du compte
    for ($i = 0; $i < $nombrecomptes; $i++) {
        if ($bdd->comptes[$i]->email == $_POST["email"] ||
        ($bdd->comptes[$i]->nom == $_POST["nom"] && $bdd->comptes[$i]->prenom == $_POST["prenom"])) {
            $_SESSION["erreur"] = 1;
            $_SESSION["messageerreur"] = "Erreur : compte deja inscrit";
            break;
        }
    }
    // s'il n'y a pas d'erreur
    if (!$_SESSION["erreur"]) {

        $compte = new Compte();
        $compte->id = $bdd->prochain_id++;
        $compte->nom = htmlspecialchars($_POST["nom"]);
        $compte->prenom = htmlspecialchars($_POST["prenom"]);
        $compte->email = htmlspecialchars($_POST["email"]);
        $compte->datenaissance = htmlspecialchars($_POST["datenaissance"]);



        $_SESSION["nom"] = htmlspecialchars($_POST["nom"]);
        $_SESSION["prenom"] = htmlspecialchars($_POST["prenom"]);
        $_SESSION["email"] = htmlspecialchars($_POST["email"]);
        $_SESSION["datenaissance"] = htmlspecialchars($_POST["datenaissance"]);
        $_SESSION["referent"] = 0;



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

        array_push($bdd->comptes, $compte);
        $contenufichier = json_encode($bdd, JSON_PRETTY_PRINT);

        file_put_contents("../data/bdd.json", $contenufichier);




        $_SESSION["statut_client"] = "jeune";
    }
}

header("Location: ../web/jeune.php");
?>