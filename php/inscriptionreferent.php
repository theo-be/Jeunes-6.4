<?php
session_start();
require_once "verifsession.php";
require_once "Compte.php";
require_once "cherchecompte.php";


// Verification des infos
if (!(isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["datenaissance"]) && isset($_POST["email"]) & isset($_POST["engagement"]) && isset($_POST["duree"]) && isset($_POST["duree"]) && isset($_POST["savoiretre"]) && isset($_POST["nomref"]) && isset($_POST["prenomref"]) && isset($_POST["emailref"]) && isset($_POST["datenaissanceref"]) && isset($_POST["reseauref"]) && isset($_POST["dureeref"]) && isset($_POST["presentationref"]) && isset($_POST["savoiretreref"]))) {
    // erreur
    $_SESSION["erreur"] = 1;
    $_SESSION["messageerreur"] = "ERREUR : formulaire corompu";
} else {
    $contenufichier = file_get_contents("../data/bdd.json");
    $bdd = json_decode($contenufichier, false);
    $nombrecomptes = count($bdd->comptes);
    $idjeune = chercheCompte($bdd, $_SESSION["email"]);
    $idreferent = count($bdd->comptes[$idjeune]->idliaison) ? $bdd->comptes[$idjeune]->idliaison[0] : -1;

    // si le compte du jeune existe
    if ($idjeune != -1) {
        $bdd->comptes[$idjeune]->nom = htmlspecialchars($_POST["nom"]);
        $bdd->comptes[$idjeune]->prenom = htmlspecialchars($_POST["prenom"]);
        $bdd->comptes[$idjeune]->email = htmlspecialchars($_POST["email"]);
        $bdd->comptes[$idjeune]->datenaissance = htmlspecialchars($_POST["datenaissance"]);
        $bdd->comptes[$idjeune]->reseau = htmlspecialchars($_POST["reseau"]);
        $bdd->comptes[$idjeune]->engagement = htmlspecialchars($_POST["engagement"]);
        $bdd->comptes[$idjeune]->duree = htmlspecialchars($_POST["duree"]);
        $bdd->comptes[$idjeune]->savoiretre = $_POST["savoiretre"];


        // on verifie si le jeune n'a pas de referent
        if (!$_SESSION["referent"]) {
            $referent = new Compte;
            $referent->id = $bdd->prochain_id++;
            $idreferent = $referent->id;
            $referent->nom = htmlspecialchars($_POST["nomref"]);
            $referent->prenom = htmlspecialchars($_POST["prenomref"]);
            $referent->email = htmlspecialchars($_POST["emailref"]);
            $referent->datenaissance = htmlspecialchars($_POST["datenaissanceref"]);
            $referent->reseau = htmlspecialchars($_POST["reseauref"]);
            $referent->engagement = htmlspecialchars($_POST["presentationref"]);
            $referent->duree = htmlspecialchars($_POST["dureeref"]);
            $referent->savoiretre = $_POST["savoiretreref"];
            $referent->type = "referent";
            array_push($referent->idliaison, $idjeune);
            array_push($bdd->comptes, $referent);
            array_push($bdd->comptes[$idjeune]->idliaison, $idreferent);
        } elseif ($idreferent != -1) { // s'il en a un
            $bdd->comptes[$idreferent]->nom = htmlspecialchars($_POST["nomref"]);
            $bdd->comptes[$idreferent]->prenom = htmlspecialchars($_POST["prenomref"]);
            $bdd->comptes[$idreferent]->email = htmlspecialchars($_POST["emailref"]);
            $bdd->comptes[$idreferent]->datenaissance = htmlspecialchars($_POST["datenaissanceref"]);
            $bdd->comptes[$idreferent]->reseau = htmlspecialchars($_POST["reseauref"]);
            $bdd->comptes[$idreferent]->engagement = htmlspecialchars($_POST["presentationref"]);
            $bdd->comptes[$idreferent]->duree = htmlspecialchars($_POST["dureeref"]);
            $bdd->comptes[$idreferent]->savoiretre = $_POST["savoiretreref"];
        } else { // 
            // erreur
        }

    }
  

    $_SESSION["nom"] = htmlspecialchars($_POST["nom"]);
    $_SESSION["prenom"] = htmlspecialchars($_POST["prenom"]);
    $_SESSION["email"] = htmlspecialchars($_POST["email"]);
    $_SESSION["datenaissance"] = htmlspecialchars($_POST["datenaissance"]);
    $_SESSION["engagement"] = htmlspecialchars($_POST["engagement"]);
    $_SESSION["duree"] = htmlspecialchars($_POST["duree"]);
    $_SESSION["reseau"] = htmlspecialchars($_POST["reseau"]);
    $_SESSION["savoiretre"] = $_POST["savoiretre"];


    $_SESSION["referent"] = 1;

    $_SESSION["nomref"] = htmlspecialchars($_POST["nomref"]);
    $_SESSION["prenomref"] = htmlspecialchars($_POST["prenomref"]);
    $_SESSION["emailref"] = htmlspecialchars($_POST["emailref"]);
    $_SESSION["datenaissanceref"] = htmlspecialchars($_POST["datenaissanceref"]);
    $_SESSION["reseauref"] = htmlspecialchars($_POST["reseauref"]);
    $_SESSION["presentationref"] = htmlspecialchars($_POST["presentationref"]);
    $_SESSION["dureeref"] = htmlspecialchars($_POST["dureeref"]);
    $_SESSION["savoiretreref"] = $_POST["savoiretreref"];
    


    // sauvegarde
    $contenufichier = json_encode($bdd, JSON_PRETTY_PRINT);
    file_put_contents("../data/bdd.json", $contenufichier);
}


header("Location: ../web/jeune.php");

?>