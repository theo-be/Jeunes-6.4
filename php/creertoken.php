<?php

// creerToken génère un jeton aléatoire de 48 caractères et l'enregistre dans la liste

function creerToken ($fichier, $idjeune, $idref, $type) {
    srand();

    $LETTRES = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    $nouveau = new stdClass;
    $chaine = [];
    for ($i = 0; $i < 48; $i++) {
        array_push($chaine, $LETTRES[rand(0, 61)]);
    }
    $nouveau->token = implode('', $chaine);
    $nouveau->type = $type;
    $nouveau->idjeune = $idjeune;
    $nouveau->idref = $idref;
    $nouveau->etat = "en cours";

    array_push($fichier->token, $nouveau);

    return $nouveau->token;

}







?>
