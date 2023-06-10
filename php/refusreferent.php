<?php
require_once "cherchecompte.php";

session_start();


$contenufichier = file_get_contents("../data/bdd.json");
$bdd = json_decode($contenufichier, false);


$contenutoken = file_get_contents("../data/token.json");
$token = json_decode($contenutoken, false);


$idreferent = $_SESSION["idcompte"];
$idjeune = $token->token[$_SESSION["tokenid"]]->idjeune;


$indexjeune = chercheCompteJeuneParId($bdd, $idjeune);

$token->token[$_SESSION["tokenid"]]->etat = "complet";

$indexrefdansjeune = array_search($idreferent, $bdd->comptejeune[$indexjeune]->idref);
$bdd->comptejeune[$indexjeune]->statutdemande[$indexrefdansjeune] = "Demande refusée par le référent";



// sauvegarde
$contenufichier = json_encode($bdd, JSON_PRETTY_PRINT);
file_put_contents("../data/bdd.json", $contenufichier);


$contenutoken = json_encode($token, JSON_PRETTY_PRINT);
file_put_contents("../data/token.json", $contenutoken);

require_once "deconnexion.php";

header("Location: /web/referent.php");
?>