<?php
session_start();
require_once "verifsession.php";
require_once "Compte.php";
require_once "cherchecompte.php";


// Verification des infos
if (!(isset($_POST["nomref"]) && isset($_POST["prenomref"]) && isset($_POST["emailref"]) && isset($_POST["datenaissanceref"]) && isset($_POST["reseauref"]) && isset($_POST["dureeref"]) && isset($_POST["presentationref"]) && isset($_POST["savoiretreref"]))) {
    // erreur
    $_SESSION["erreur"] = 1;
    $_SESSION["messageerreur"] = "ERREUR : formulaire corompu";
} else {
    $contenufichier = file_get_contents("../data/bdd.json");
    $bdd = json_decode($contenufichier, false);

    
    $idjeune = $_SESSION["idcompte"];
    $idreferent = chercheCompteReferent($bdd, $_POST["emailref"]);


    // on verifie si c'est un nouveau referent
    if ($idreferent == -1) {
        $referent = new CompteReferent;
        $referent->id = $bdd->prochain_id_referent++;
        $idreferent = $referent->id;
        $referent->nom = htmlspecialchars($_POST["nomref"]);
        $referent->prenom = htmlspecialchars($_POST["prenomref"]);
        $referent->email = htmlspecialchars($_POST["emailref"]);
        $referent->datenaissance = htmlspecialchars($_POST["datenaissanceref"]);
        $referent->reseau = htmlspecialchars($_POST["reseauref"]);
        $referent->presentation = htmlspecialchars($_POST["presentationref"]);
        $referent->duree = htmlspecialchars($_POST["dureeref"]);
        $referent->savoiretre = $_POST["savoiretreref"];
        array_push($referent->idjeune, $idjeune);
        array_push($bdd->compteref, $referent);

    } else { // s'il en a un
        $bdd->compteref[$idreferent]->nom = htmlspecialchars($_POST["nomref"]);
        $bdd->compteref[$idreferent]->prenom = htmlspecialchars($_POST["prenomref"]);
        $bdd->compteref[$idreferent]->email = htmlspecialchars($_POST["emailref"]);
        $bdd->compteref[$idreferent]->datenaissance = htmlspecialchars($_POST["datenaissanceref"]);
        $bdd->compteref[$idreferent]->reseau = htmlspecialchars($_POST["reseauref"]);
        $bdd->compteref[$idreferent]->presentation = htmlspecialchars($_POST["presentationref"]);
        $bdd->compteref[$idreferent]->duree = htmlspecialchars($_POST["dureeref"]);
        $bdd->compteref[$idreferent]->savoiretre = $_POST["savoiretreref"];
    
        // on ajoute le jeune a la liste des jeunes lies au referent car le referent peut deja exister via un autre jeune
        if (!in_array($idjeune, $bdd->compteref[$idreferent]->idjeune))
            array_push($bdd->compteref[$idreferent]->idjeune, $idjeune);
    }


    // on ajoute le referent au compte jeune s'il n'y est pas deja
    if (!in_array($idreferent, $bdd->comptejeune[$idjeune]->idref))
        array_push($bdd->comptejeune[$idjeune]->idref, $idreferent);


    $_SESSION["nbreferent"]++;

    // $_SESSION["nomref"] = htmlspecialchars($_POST["nomref"]);
    // $_SESSION["prenomref"] = htmlspecialchars($_POST["prenomref"]);
    // $_SESSION["emailref"] = htmlspecialchars($_POST["emailref"]);
    // $_SESSION["datenaissanceref"] = htmlspecialchars($_POST["datenaissanceref"]);
    // $_SESSION["reseauref"] = htmlspecialchars($_POST["reseauref"]);
    // $_SESSION["presentationref"] = htmlspecialchars($_POST["presentationref"]);
    // $_SESSION["dureeref"] = htmlspecialchars($_POST["dureeref"]);
    // $_SESSION["savoiretreref"] = $_POST["savoiretreref"];
    


    // sauvegarde
    $contenufichier = json_encode($bdd, JSON_PRETTY_PRINT);
    file_put_contents("../data/bdd.json", $contenufichier);

}


header("Location: ../web/jeune.php");

?>