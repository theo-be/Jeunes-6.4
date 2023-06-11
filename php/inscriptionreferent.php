<?php
session_start();
require_once "verifsession.php";
require_once "Compte.php";
require_once "cherchecompte.php";
require_once "creertoken.php";
require_once "envoimail.php";


// Verification des infos
if (!(isset($_POST["nomref"]) && isset($_POST["prenomref"]) && isset($_POST["emailref"]) && isset($_POST["datenaissanceref"]) && isset($_POST["reseauref"]) && isset($_POST["dureeref"]) && isset($_POST["presentationref"]))) {
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
    $t = '';
    $idjeune = $_SESSION["idcompte"];
    $idreferent = chercheCompteReferent($bdd, $_POST["emailref"]);


    // on verifie si c'est un nouveau referent
    if ($idreferent == -1) {
        $referent = new CompteReferent;
        $referent->id = $bdd->prochain_id_referent++;
        $idreferent = $referent->id;
        $referent->nom = htmlspecialchars(trim($_POST["nomref"]));
        $referent->prenom = htmlspecialchars(trim($_POST["prenomref"]));
        $referent->email = htmlspecialchars(trim($_POST["emailref"]));
        $referent->datenaissance = htmlspecialchars(trim($_POST["datenaissanceref"]));
        $referent->reseau = htmlspecialchars(trim($_POST["reseauref"]));
        $referent->presentation = htmlspecialchars(trim($_POST["presentationref"]));
        $referent->duree = htmlspecialchars(trim($_POST["dureeref"]));
        if (isset($_POST["savoiretreref"]))
            $referent->savoiretre = $_POST["savoiretreref"];
        array_push($referent->idjeune, $idjeune);
        array_push($bdd->compteref, $referent);

        // on cree le jeton pour le referent
        $contenutoken = file_get_contents("../data/token.json");
        $token = json_decode($contenutoken, false);


        // creation du jeton
        $t = creerToken($token, $referent->idjeune[0], $referent->id, "referent");

        // ajout du statut de la demande
        $indexjeune = chercheCompteJeuneParId($bdd, $idjeune);
        array_push($bdd->comptejeune[$indexjeune]->statutdemande, "En attente du référent");



    } else { // s'il en a un
        // echo var_dump($bdd);
        $indexjeune = chercheCompteJeuneParId($bdd, $idjeune);
        $bdd->compteref[$idreferent]->nom = htmlspecialchars(trim($_POST["nomref"]));
        $bdd->compteref[$idreferent]->prenom = htmlspecialchars(trim($_POST["prenomref"]));
        $bdd->compteref[$idreferent]->email = htmlspecialchars(trim($_POST["emailref"]));
        $bdd->compteref[$idreferent]->datenaissance = htmlspecialchars(trim($_POST["datenaissanceref"]));
        $bdd->compteref[$idreferent]->reseau = htmlspecialchars(trim($_POST["reseauref"]));
        $bdd->compteref[$idreferent]->presentation = htmlspecialchars(trim($_POST["presentationref"]));
        $bdd->compteref[$idreferent]->duree = htmlspecialchars(trim($_POST["dureeref"]));

        // $strucsavoiretreref = new stdClass;
        // $strucsavoiretreref->de = $bdd->compteref[$idreferent]->id;
        // $strucsavoiretreref->savoiretre = $_POST["savoiretreref"];
        // array_push($bdd->comptejeune[$indexjeune]->savoiretreref, $strucsavoiretreref);




        // creation du jeton
        $t = creerToken($token, $idjeune, $bdd->compteref[$idreferent]->id, "referent");


    
        // on ajoute le jeune a la liste des jeunes lies au referent car le referent peut deja exister via un autre jeune
        if (!in_array($idjeune, $bdd->compteref[$idreferent]->idjeune))
            array_push($bdd->compteref[$idreferent]->idjeune, $idjeune);

        // ajout du statut de la demande
        $indexstatutdemande = array_search($idreferent, $bdd->comptejeune[$indexjeune]->idref);
        array_push($bdd->comptejeune[$indexjeune]->statutdemande, "En attente du référent");
    }


    // on ajoute le referent au compte jeune s'il n'y est pas deja
    if (!in_array($idreferent, $bdd->comptejeune[$indexjeune]->idref))
        array_push($bdd->comptejeune[$indexjeune]->idref, $idreferent);


    $_SESSION["nbreferent"]++;

    // $_SESSION["nomref"] = htmlspecialchars($_POST["nomref"]);
    // $_SESSION["prenomref"] = htmlspecialchars($_POST["prenomref"]);
    // $_SESSION["emailref"] = htmlspecialchars($_POST["emailref"]);
    // $_SESSION["datenaissanceref"] = htmlspecialchars($_POST["datenaissanceref"]);
    // $_SESSION["reseauref"] = htmlspecialchars($_POST["reseauref"]);
    // $_SESSION["presentationref"] = htmlspecialchars($_POST["presentationref"]);
    // $_SESSION["dureeref"] = htmlspecialchars($_POST["dureeref"]);
    // $_SESSION["savoiretreref"] = $_POST["savoiretreref"];
    

    $_SESSION["erreur"] = 0;
    $_SESSION["messageerreur"] = "";


    // sauvegarde
    $contenufichier = json_encode($bdd, JSON_PRETTY_PRINT);
    file_put_contents("../data/bdd.json", $contenufichier);

    $contenutoken = json_encode($token, JSON_PRETTY_PRINT);
    file_put_contents("../data/token.json", $contenutoken);

    // envoi du mail
    envoyermail($_POST["emailref"], "referent", "Demande de référencement", $t);

}


header("Location: /web/jeune.php");

?>