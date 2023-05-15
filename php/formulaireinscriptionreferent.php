<?php

session_start();
require_once "cherchecompte.php";




// si on veut modifier un compte existant
if (isset($_GET["prerempli"]) && $_GET["prerempli"] && isset($_GET["email"])) {
// formulaire prerempli

    $contenufichier = file_get_contents("../data/bdd.json");
    $bdd = json_decode($contenufichier, false);


    $idjeune = chercheCompteJeune($bdd, $_SESSION["email"]);
    $idreferent = chercheCompteReferent($bdd, $_GET["email"]);

    $compte = $bdd->compteref[$idreferent];

    echo '
    <form action="../php/inscriptionreferent.php" method="post">
        nom* <input type="text" name="nomref" id="nomref" required="required" value="'.$compte->nom.'">
        prenom* <input type="text" name="prenomref" id="prenomref" required="required" value="'.$compte->prenom.'">
        email* <input type="text" name="emailref" id="emailref" required="required" value="'.$compte->email.'">
        datenaissance* <input type="text" name="datenaissanceref" id="datenaissanceref" required="required" value="'.$compte->datenaissance.'">
        reseau* <input type="text" name="reseauref" id="reseauref" required="required" value="'.$compte->reseau.'">
        presentation* <input type="text" name="presentationref" id="presentationref" required="required" value="'.$compte->presentation.'">
        duree* <input type="text" name="dureeref" id="dureeref" required="required" value="'.$compte->duree.'">
        <p>Ses savoirs être*</p>
        confiance<input type="checkbox" name="savoiretreref[]" id="confiance" value="confiance"' . (in_array("confiance", $compte->savoiretre) ? 'checked="checked"' : '') . '>
        bienveillance<input type="checkbox" name="savoiretreref[]" id="bienveillance" value="bienveillance"' . (in_array("bienveillance", $compte->savoiretre) ? 'checked="checked"' : '') . '>
        respect<input type="checkbox" name="savoiretreref[]" id="respect" value="respect"' . (in_array("respect", $compte->savoiretre) ? 'checked="checked"' : '') . '>
        honnetete<input type="checkbox" name="savoiretreref[]" id="honnetete" value="honnetete"' . (in_array("honnetete", $compte->savoiretre) ? 'checked="checked"' : '') . '>
        tolerance<input type="checkbox" name="savoiretreref[]" id="tolerance" value="tolerance"' . (in_array("tolerance", $compte->savoiretre) ? 'checked="checked"' : '') . '>
        juste<input type="checkbox" name="savoiretreref[]" id="juste" value="juste"' . (in_array("juste", $compte->savoiretre) ? 'checked="checked"' : '') . '>
        impartial<input type="checkbox" name="savoiretreref[]" id="impartial" value="impartial"' . (in_array("impartial", $compte->savoiretre) ? 'checked="checked"' : '') . '>
        travail<input type="checkbox" name="savoiretreref[]" id="travail" value="travail"' . (in_array("travail", $compte->savoiretre) ? 'checked="checked"' : '') . '>
        <input type="submit" value="Envoyer">
    </form>
    ';
} else { // formulaire vide
    echo "<p>Ajouter une demande de referencement :</p>";
    echo "<p>Informations du référent</p>";
    echo '
    <form action="../php/inscriptionreferent.php" method="post">
        nom* <input type="text" name="nomref" id="nomref" required="required">
        prenom* <input type="text" name="prenomref" id="prenomref" required="required">
        email* <input type="text" name="emailref" id="emailref" required="required">
        datenaissance* <input type="text" name="datenaissanceref" id="datenaissanceref" required="required">
        reseau* <input type="text" name="reseauref" id="reseauref" required="required">
        presentation* <input type="text" name="presentationref" id="presentationref" required="required">
        duree* <input type="text" name="dureeref" id="dureeref" required="required">
        <p>Ses savoirs être*</p>
        confiance<input type="checkbox" name="savoiretreref[]" id="confiance" value="confiance">
        bienveillance<input type="checkbox" name="savoiretreref[]" id="bienveillance" value="bienveillance">
        respect<input type="checkbox" name="savoiretreref[]" id="respect" value="respect">
        honnetete<input type="checkbox" name="savoiretreref[]" id="honnetete" value="honnetete">
        tolerance<input type="checkbox" name="savoiretreref[]" id="tolerance" value="tolerance">
        juste<input type="checkbox" name="savoiretreref[]" id="juste" value="juste">
        impartial<input type="checkbox" name="savoiretreref[]" id="impartial" value="impartial">
        travail<input type="checkbox" name="savoiretreref[]" id="travail" value="travail">
        <input type="submit" value="Envoyer">
    </form>
    ';
}








// formulaire prerempli
// echo '
// <form action="../php/inscriptionreferent.php" method="post">
//     nom* <input type="text" name="nomref" id="nomref" required="required" value="'.$_SESSION["nomref"].'">
//     prenom* <input type="text" name="prenomref" id="prenomref" required="required" value="'.$_SESSION["prenomref"].'">
//     email* <input type="text" name="emailref" id="emailref" required="required" value="'.$_SESSION["emailref"].'">
//     datenaissance* <input type="text" name="datenaissanceref" id="datenaissanceref" required="required" value="'.$_SESSION["datenaissanceref"].'">
//     reseau* <input type="text" name="reseauref" id="reseauref" required="required" value="'.$_SESSION["reseauref"].'">
//     presentation* <input type="text" name="presentationref" id="presentationref" required="required" value="'.$_SESSION["presentationref"].'">
//     duree* <input type="text" name="dureeref" id="dureeref" required="required" value="'.$_SESSION["dureeref"].'">
//     <p>Ses savoirs être*</p>
//     confiance<input type="checkbox" name="savoiretreref[]" id="confiance" value="confiance"' . (in_array("confiance", $_SESSION["savoiretreref"]) ? 'checked="checked"' : '') . '>
//     bienveillance<input type="checkbox" name="savoiretreref[]" id="bienveillance" value="bienveillance"' . (in_array("bienveillance", $_SESSION["savoiretreref"]) ? 'checked="checked"' : '') . '>
//     respect<input type="checkbox" name="savoiretreref[]" id="respect" value="respect"' . (in_array("respect", $_SESSION["savoiretreref"]) ? 'checked="checked"' : '') . '>
//     honnetete<input type="checkbox" name="savoiretreref[]" id="honnetete" value="honnetete"' . (in_array("honnetete", $_SESSION["savoiretreref"]) ? 'checked="checked"' : '') . '>
//     tolerance<input type="checkbox" name="savoiretreref[]" id="tolerance" value="tolerance"' . (in_array("tolerance", $_SESSION["savoiretreref"]) ? 'checked="checked"' : '') . '>
//     juste<input type="checkbox" name="savoiretreref[]" id="juste" value="juste"' . (in_array("juste", $_SESSION["savoiretreref"]) ? 'checked="checked"' : '') . '>
//     impartial<input type="checkbox" name="savoiretreref[]" id="impartial" value="impartial"' . (in_array("impartial", $_SESSION["savoiretreref"]) ? 'checked="checked"' : '') . '>
//     travail<input type="checkbox" name="savoiretreref[]" id="travail" value="travail"' . (in_array("travail", $_SESSION["savoiretreref"]) ? 'checked="checked"' : '') . '>
//     <input type="submit" value="Envoyer">
// </form>
// ';






?>


















