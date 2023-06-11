<?php
require_once "cherchecompte.php";
require_once 'envoimail.php';

session_start();

// chargement de la base de données

$contenufichier = file_get_contents("../data/bdd.json");
$bdd = json_decode($contenufichier, false);


$contenutoken = file_get_contents("../data/token.json");
$token = json_decode($contenutoken, false);


$idreferent = $_SESSION["idcompte"];
$idjeune = $token->token[$_SESSION["tokenid"]]->idjeune;


// modification du compte du jeune
$indexjeune = chercheCompteJeuneParId($bdd, $idjeune);

$token->token[$_SESSION["tokenid"]]->etat = "complet";

$indexrefdansjeune = array_search($idreferent, $bdd->comptejeune[$indexjeune]->idref);
$bdd->comptejeune[$indexjeune]->statutdemande[$indexrefdansjeune] = "Demande refusée par le référent";



// envoyermail($bdd->comptejeune[$indexjeune]->email, "jeuneref", "Votre demande de référencement", '');



// sauvegarde
$contenufichier = json_encode($bdd, JSON_PRETTY_PRINT);
file_put_contents("../data/bdd.json", $contenufichier);


$contenutoken = json_encode($token, JSON_PRETTY_PRINT);
file_put_contents("../data/token.json", $contenutoken);


// déconnexion
$_SESSION = array();
session_destroy();

header("Location: /web/remerciements.php");
?>
