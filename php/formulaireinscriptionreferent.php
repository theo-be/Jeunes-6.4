<?php

require_once "../php/cherchecompte.php";
if (!isset($_SESSION))
    session_start();

$prerempli = 0;
$contenufichier = file_get_contents("../data/bdd.json");
$bdd = json_decode($contenufichier, false);

$idjeune = 0;
$idref = 0;
$compte;

if (isset($_GET["prerempli"]) && $_GET["prerempli"] && isset($_GET["email"])) {
    echo $_GET["email"];
    $idjeune = chercheCompteJeune($bdd, $_SESSION["email"]);
    $idreferent = chercheCompteReferent($bdd, $_GET["email"]);
    $compte = $bdd->compteref[$idreferent];
    $prerempli = 1;
} elseif ($_SESSION["statut_client"] == "referent") {
    $compte = $bdd->compteref[$_SESSION["idcompte"]];
    $prerempli = 1;
}

// si on veut modifier un compte existant
if ($prerempli) {
// formulaire prerempli
    // echo 'prerempli';
    echo '
    <form action="/php/inscriptionreferent.php" method="post">
        nom* <input type="text" name="nomref" id="nomref" required="required" value="'.$compte->nom.'">
        prenom* <input type="text" name="prenomref" id="prenomref" required="required" value="'.$compte->prenom.'">
        email* <input type="text" name="emailref" id="emailref" required="required" value="'.$compte->email.'">
        datenaissance* <input type="text" name="datenaissanceref" id="datenaissanceref" required="required" value="'.$compte->datenaissance.'">
        reseau* <input type="text" name="reseauref" id="reseauref" required="required" value="'.$compte->reseau.'">
        presentation* <input type="text" name="presentationref" id="presentationref" required="required" value="'.$compte->presentation.'">
        duree* <input type="text" name="dureeref" id="dureeref" required="required" value="'.$compte->duree.'">';

        $taillesavoiretreref = count($bdd->comptejeune[$idjeune]->savoiretreref);
        $com = 0;
        $sav = 0;
        for ($i = 0; $i < $taillesavoiretreref; $i++) {
            if (!$sav && isset($bdd->comptejeune[$idjeune]->savoiretreref[$i]) && $bdd->comptejeune[$idjeune]->savoiretreref[$i]->de == $idreferent) {
                echo '
                <p>Ses savoirs être*</p>
                confiance<input type="checkbox" name="savoiretreref[]" id="confiance" value="confiance"' . (in_array("confiance", $bdd->comptejeune[$idjeune]->savoiretreref[$i]->savoiretre) ? 'checked="checked"' : '') . '>
                bienveillance<input type="checkbox" name="savoiretreref[]" id="bienveillance" value="bienveillance"' . (in_array("bienveillance", $bdd->comptejeune[$idjeune]->savoiretreref[$i]->savoiretre) ? 'checked="checked"' : '') . '>
                respect<input type="checkbox" name="savoiretreref[]" id="respect" value="respect"' . (in_array("respect", $bdd->comptejeune[$idjeune]->savoiretreref[$i]->savoiretre) ? 'checked="checked"' : '') . '>
                honnetete<input type="checkbox" name="savoiretreref[]" id="honnetete" value="honnetete"' . (in_array("honnetete", $bdd->comptejeune[$idjeune]->savoiretreref[$i]->savoiretre) ? 'checked="checked"' : '') . '>
                tolerance<input type="checkbox" name="savoiretreref[]" id="tolerance" value="tolerance"' . (in_array("tolerance", $bdd->comptejeune[$idjeune]->savoiretreref[$i]->savoiretre) ? 'checked="checked"' : '') . '>
                juste<input type="checkbox" name="savoiretreref[]" id="juste" value="juste"' . (in_array("juste", $bdd->comptejeune[$idjeune]->savoiretreref[$i]->savoiretre) ? 'checked="checked"' : '') . '>
                impartial<input type="checkbox" name="savoiretreref[]" id="impartial" value="impartial"' . (in_array("impartial", $bdd->comptejeune[$idjeune]->savoiretreref[$i]->savoiretre) ? 'checked="checked"' : '') . '>
                travail<input type="checkbox" name="savoiretreref[]" id="travail" value="travail"' . (in_array("travail", $bdd->comptejeune[$idjeune]->savoiretreref[$i]->savoiretre) ? 'checked="checked"' : '') . '>
                ';
                $sav = 1;
            }
            // commentaire
            if (!$com && isset($bdd->comptejeune[$idjeune]->commentaire[$i]) && $bdd->comptejeune[$idjeune]->commentaire[$i]->de == $idreferent) {
                echo '<p>commentaire :' . $bdd->comptejeune[$idjeune]->commentaire[$i]->texte.'</p>';
                $com = 1;
            }
        }


        echo'<input type="submit" value="Modifier les informations du référent">
    </form>
    ';
} else { // formulaire vide

    echo '
    <form action="/php/inscriptionreferent.php" method="post">
        nom* <input type="text" name="nomref" id="nomref" required="required">
        prenom* <input type="text" name="prenomref" id="prenomref" required="required">
        email* <input type="text" name="emailref" id="emailref" required="required">
        datenaissance* <input type="text" name="datenaissanceref" id="datenaissanceref" required="required">
        reseau* <input type="text" name="reseauref" id="reseauref" required="required">
        presentation* <input type="text" name="presentationref" id="presentationref" required="required">
        duree* <input type="text" name="dureeref" id="dureeref" required="required">'/*
        <p>Ses savoirs être*</p>
        confiance<input type="checkbox" name="savoiretreref[]" id="confiance" value="confiance">
        bienveillance<input type="checkbox" name="savoiretreref[]" id="bienveillance" value="bienveillance">
        respect<input type="checkbox" name="savoiretreref[]" id="respect" value="respect">
        honnetete<input type="checkbox" name="savoiretreref[]" id="honnetete" value="honnetete">
        tolerance<input type="checkbox" name="savoiretreref[]" id="tolerance" value="tolerance">
        juste<input type="checkbox" name="savoiretreref[]" id="juste" value="juste">
        impartial<input type="checkbox" name="savoiretreref[]" id="impartial" value="impartial">
        travail<input type="checkbox" name="savoiretreref[]" id="travail" value="travail">*/
        .'<input type="submit" value="Envoyer">
    </form>
    ';
}








// formulaire prerempli
// echo '
// <form action="/php/inscriptionreferent.php" method="post">
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


















