<?php

session_start();

// securite
if ($_SESSION["statut_client"] != "consultant")
    header("Location: /web/");









$contenufichier = file_get_contents("../data/bdd.json");
$bdd = json_decode($contenufichier, false);

$contenutoken = file_get_contents("../data/token.json");
$token = json_decode($contenutoken, false);


$indexref = array_search($_SESSION["idref"], $bdd->comptejeune[$_SESSION["idjeune"]]->idref);
// echo $indexref;

$bdd->comptejeune[$_SESSION["idjeune"]]->statutdemandeconsultant = 3;
$bdd->comptejeune[$_SESSION["idjeune"]]->messagestatutdemandeconsultant = "Demande refusée par le consultant";
$token->token[$_SESSION["tokenid"]]->etat = "complet";






$contenufichier = json_encode($bdd, JSON_PRETTY_PRINT);
file_put_contents("../data/bdd.json", $contenufichier);

$contenutoken = json_encode($token, JSON_PRETTY_PRINT);
file_put_contents("../data/token.json", $contenutoken);

require_once "deconnexion.php";

header("Location: /web/accueil.php");
?>