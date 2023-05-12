<?php
session_start();
require_once "verifsession.php";
require_once "Compte.php";



// Verification des infos
if (!(isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["datenaissance"]) && isset($_POST["email"]) & isset($_POST["engagement"]) && isset($_POST["duree"]) && isset($_POST["duree"]) && isset($_POST["savoiretre"]) && isset($_POST["nomref"]) && isset($_POST["prenomref"]) && isset($_POST["emailref"]) && isset($_POST["datenaissanceref"]) && isset($_POST["reseauref"]) && isset($_POST["dureeref"]) && isset($_POST["presentationref"]) && isset($_POST["savoiretreref"]))) {
    // erreur
} else {
    $contenufichier = file_get_contents("../data/bdd.json");
    $bdd = json_decode($contenufichier, false);
    $nombrecomptes = count($bdd->comptes);
    for ($i = 0; $i < $nombrecomptes; $i++) {
        if ($bdd->comptes[$i]->email == $_SESSION["email"]) {
            $bdd->comptes[$i]->nom = htmlspecialchars($_POST["nom"]);
            $bdd->comptes[$i]->prenom = htmlspecialchars($_POST["prenom"]);
            $bdd->comptes[$i]->email = htmlspecialchars($_POST["email"]);
            $bdd->comptes[$i]->datenaissance = htmlspecialchars($_POST["datenaissance"]);
            $bdd->comptes[$i]->reseau = htmlspecialchars($_POST["reseau"]);
            $bdd->comptes[$i]->engagement = htmlspecialchars($_POST["engagement"]);
            $bdd->comptes[$i]->duree = htmlspecialchars($_POST["duree"]);
            $bdd->comptes[$i]->savoiretre = htmlspecialchars($_POST["savoiretre"]);



            break;
        }

        if (!$_SESSION["referent"]) {
            $referent = new Compte;
            $referent->nom = htmlspecialchars($_POST["nomref"]);
            $referent->prenom = htmlspecialchars($_POST["prenomref"]);
            $referent->email = htmlspecialchars($_POST["emailref"]);
            $referent->datenaissance = htmlspecialchars($_POST["datenaissanceref"]);
            $referent->reseau = htmlspecialchars($_POST["reseauref"]);
            $referent->engagement = htmlspecialchars($_POST["presentationref"]);
            $referent->duree = htmlspecialchars($_POST["dureeref"]);
            $referent->savoiretre = htmlspecialchars($_POST["savoiretreref"]);
            $referent->type = "referent";
            array_push($bdd->comptes, $referent);
        } else {
            for ($i = 0; $i < $nombrecomptes; $i++) {
                if ($bdd->comptes[$i]->email == $_POST["emailref"]) {
                    $bdd->comptes[$i]->nom = htmlspecialchars($_POST["nomref"]);
                    $bdd->comptes[$i]->prenom = htmlspecialchars($_POST["prenomref"]);
                    $bdd->comptes[$i]->email = htmlspecialchars($_POST["emailref"]);
                    $bdd->comptes[$i]->datenaissance = htmlspecialchars($_POST["datenaissanceref"]);
                    $bdd->comptes[$i]->reseau = htmlspecialchars($_POST["reseauref"]);
                    $bdd->comptes[$i]->engagement = htmlspecialchars($_POST["presentationref"]);
                    $bdd->comptes[$i]->duree = htmlspecialchars($_POST["dureeref"]);
                    $bdd->comptes[$i]->savoiretre = htmlspecialchars($_POST["savoiretreref"]);
                }
            }
        }





        $_SESSION["nom"] = htmlspecialchars($_POST["nom"]);
        $_SESSION["prenom"] = htmlspecialchars($_POST["prenom"]);
        $_SESSION["email"] = htmlspecialchars($_POST["email"]);
        $_SESSION["datenaissance"] = htmlspecialchars($_POST["datenaissance"]);
        $_SESSION["savoiretre"] = htmlspecialchars($_POST["savoiretre"]);
        $_SESSION["engagement"] = htmlspecialchars($_POST["engagement"]);
        $_SESSION["duree"] = htmlspecialchars($_POST["duree"]);
        $_SESSION["reseau"] = htmlspecialchars($_POST["reseau"]);


        $_SESSION["referent"] = 1;

        $_SESSION["nomref"] = $referent->nom;
        $_SESSION["prenomref"] = $referent->prenom;
        $_SESSION["emailref"] = $referent->email;
        $_SESSION["datenaissanceref"] = $referent->datenaissance;
        $_SESSION["reseauref"] = $referent->reseau;
        $_SESSION["presentationref"] = $referent->engagement;
        $_SESSION["dureeref"] = $referent->duree;
        $_SESSION["savoiretreref"] = $referent->savoiretre;
    }

    $contenufichier = json_encode($bdd);
    file_put_contents("../data/bdd.json", $contenufichier);
}


header("Location: ../web/jeune.php");

?>