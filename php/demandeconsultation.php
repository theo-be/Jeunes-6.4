<?php

session_start();
require_once "envoimail.php";
require_once "creertoken.php";
require_once "cherchecompte.php";



$contenufichier = file_get_contents("../data/bdd.json");
$bdd = json_decode($contenufichier, false);

$contenutoken = file_get_contents("../data/token.json");
$token = json_decode($contenutoken, false);

// creation du jeton

$t = creerToken($token, $_SESSION["idcompte"], $_SESSION["idcompte"], "consultant");


// envoi du mail

envoyermail($_SESSION["emailconsultant"], "consultant", "Jeunes 6.4 - Demande de consultation", $t);


// changement du statut de la demande vers le consultant

$indexjeune = chercheCompteJeuneParId($bdd, $_SESSION["idcompte"]);

$bdd->comptejeune[$indexjeune]->statutdemandeconsultant = 1;
$bdd->comptejeune[$indexjeune]->messagestatutdemandeconsultant = "En attente du consultant";





$contenutoken = json_encode($token, JSON_PRETTY_PRINT);
file_put_contents("../data/token.json", $contenutoken);

// sauvegarde
$contenufichier = json_encode($bdd, JSON_PRETTY_PRINT);
file_put_contents("../data/bdd.json", $contenufichier);

header("Location: /web/jeune.php");


/*

codes et messages pour le consultant
0 : aucune demande faite
1 : demande envoyee
2 : demande acceptee
3 : demande refusee










*/


?>