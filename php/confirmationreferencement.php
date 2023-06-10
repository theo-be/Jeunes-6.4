<?php
session_start();
require_once "verifsession.php";
require_once "Compte.php";
require_once "cherchecompte.php";
require_once "creertoken.php";


// Verification des infos
if (!(isset($_POST["nomref"]) && isset($_POST["prenomref"]) && isset($_POST["emailref"]) && isset($_POST["datenaissanceref"]) && isset($_POST["reseauref"]) && isset($_POST["dureeref"]) && isset($_POST["presentationref"]) && isset($_POST["savoiretreref"]))) {
    // erreur
    $_SESSION["erreur"] = 1;
    $_SESSION["messageerreur"] = "ERREUR : formulaire corompu";

} else if (isset($_POST["email"]) && !preg_match('#([0-9a-z]){3,}@([a-z]){2,}.([a-z]){2,4}$#i', trim($_POST["email"]))) {
    // erreur
    $_SESSION["erreur"] = 1;
    $_SESSION["messageerreur"] = "ERREUR : addresse email dans la mauvais format";
} else if ((isset($_POST["email"]) && !preg_match('#^([0-9]{2}/){2}[0-9]{4}$#', $_POST["datenaissance"]))) {
    // erreur
    $_SESSION["erreur"] = 1;
    $_SESSION["messageerreur"] = "ERREUR : date de naissance dans le mauvais format, format JJ/MM/AAAA";


} else {
    $contenufichier = file_get_contents("../data/bdd.json");
    $bdd = json_decode($contenufichier, false);

    
    $contenutoken = file_get_contents("../data/token.json");
    $token = json_decode($contenutoken, false);
    

    $idreferent = $_SESSION["idcompte"];
    $idjeune = $token->token[$_SESSION["tokenid"]]->idjeune;

    $bdd->compteref[$idreferent]->nom = htmlspecialchars(trim($_POST["nomref"]));
    $bdd->compteref[$idreferent]->prenom = htmlspecialchars(trim($_POST["prenomref"]));
    $bdd->compteref[$idreferent]->email = htmlspecialchars(trim($_POST["emailref"]));
    $bdd->compteref[$idreferent]->datenaissance = htmlspecialchars(trim($_POST["datenaissanceref"]));
    $bdd->compteref[$idreferent]->reseau = htmlspecialchars(trim($_POST["reseauref"]));
    $bdd->compteref[$idreferent]->presentation = htmlspecialchars(trim($_POST["presentationref"]));
    $bdd->compteref[$idreferent]->duree = htmlspecialchars(trim($_POST["dureeref"]));

    $indexjeune = chercheCompteJeuneParId($bdd, $idjeune);


    $struc_savoiretreref = new stdClass();
    $struc_savoiretreref->de = $idreferent;
    $struc_savoiretreref->savoiretre = $_POST["savoiretreref"];
    array_push($bdd->comptejeune[$idjeune]->savoiretreref, $struc_savoiretreref);

    $struc_commentaire = new stdClass();
    $struc_commentaire->de = $idreferent;
    $struc_commentaire->texte = htmlspecialchars($_POST["commentaire"]);
    array_push($bdd->comptejeune[$idjeune]->commentaire, $struc_commentaire);

    // modification de l'état de la demande de référencement
    
    $indexstatutdemande = array_search($idreferent, $bdd->comptejeune[$indexjeune]->idref);
    $bdd->comptejeune[$indexjeune]->statutdemande[$indexstatutdemande] = "Demande validée par le référent";


    // detruire le jeton

    // array_splice($token->token, $_SESSION["idtoken"], 1);
    $token->token[$_SESSION["tokenid"]]->etat = "complet";


    // sauvegarde
    $contenufichier = json_encode($bdd, JSON_PRETTY_PRINT);
    file_put_contents("../data/bdd.json", $contenufichier);


    $contenutoken = json_encode($token, JSON_PRETTY_PRINT);
    file_put_contents("../data/token.json", $contenutoken);

}

require_once "deconnexion.php";

header("Location: /web/referent.php");

?>