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
    // echo $_GET["email"];
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
    $indexref = array_search($bdd->compteref[$idreferent]->id, $bdd->comptejeune[$idjeune]->idref);
    // echo 'prerempli';
    echo '
    <div class="boxreferent" >
    <div class="referent">

    <div>Statut de la demande de référencement : '.$bdd->comptejeune[$idjeune]->statutdemande[$indexref].'</div>

    <label for="nomref">Nom</label>* <input type="text" name="nomref" id="nomref" required="required" value="'.$compte->nom.'">
    <label for="prenomref">Prénom</label>* <input type="text" name="prenomref" id="prenomref" required="required" value="'.$compte->prenom.'">
    <label for="emailref">Email</label>* <input type="text" name="emailref" id="emailref" required="required" value="'.$compte->email.'">
    <label for="datenaissanceref">Date de naissance</label>* <input type="text" name="datenaissanceref" id="datenaissanceref" required="required" value="'.$compte->datenaissance.'">
    <label for="reseauref">Réseau</label>* <input type="text" name="reseauref" id="reseauref" required="required" value="'.$compte->reseau.'">
    <label for="presentationref">Présentation</label>* <input type="text" name="presentationref" id="presentationref" required="required" value="'.$compte->presentation.'">
    <label for="dureeref">Durée</label>* <input type="text" name="dureeref" id="dureeref" required="required" value="'.$compte->duree.'">
    </div>
    </div>';

    $taillesavoiretreref = count($bdd->comptejeune[$idjeune]->savoiretreref);
    $com = 0;
    $sav = 0;
    for ($i = 0; $i < $taillesavoiretreref; $i++) {
        if (!$sav && isset($bdd->comptejeune[$idjeune]->savoiretreref[$i]) && $bdd->comptejeune[$idjeune]->savoiretreref[$i]->de == $idreferent) {
            echo '
            
            <div class="boxdroite-referent">
                    
            <div class="messavoirs-referent">
            <b>SES SAVOIRS ETRE</b>
            </div>

            <div class="boxconfirme-referent">
                <b>Je confirme sa(son)*</b>
            </div>
            <div class="coche-referent">
                <label for="confiance">Confiance</label><input type="checkbox" name="savoiretreref[]" id="confiance" value="confiance"' . (in_array("confiance", $bdd->comptejeune[$idjeune]->savoiretreref[$i]->savoiretre) ? 'checked="checked"' : '') . '>
                <label for="bienveillance">Bienveillance</label><input type="checkbox" name="savoiretreref[]" id="bienveillance" value="bienveillance"' . (in_array("bienveillance", $bdd->comptejeune[$idjeune]->savoiretreref[$i]->savoiretre) ? 'checked="checked"' : '') . '>
                <label for="respect">Respect</label><input type="checkbox" name="savoiretreref[]" id="respect" value="respect"' . (in_array("respect", $bdd->comptejeune[$idjeune]->savoiretreref[$i]->savoiretre) ? 'checked="checked"' : '') . '>
                <label for="honnetete">Honneteté</label><input type="checkbox" name="savoiretreref[]" id="honnetete" value="honnetete"' . (in_array("honnetete", $bdd->comptejeune[$idjeune]->savoiretreref[$i]->savoiretre) ? 'checked="checked"' : '') . '>
                <label for="tolerance">Tolérance</label><input type="checkbox" name="savoiretreref[]" id="tolerance" value="tolerance"' . (in_array("tolerance", $bdd->comptejeune[$idjeune]->savoiretreref[$i]->savoiretre) ? 'checked="checked"' : '') . '>
                <label for="juste">Juste</label><input type="checkbox" name="savoiretreref[]" id="juste" value="juste"' . (in_array("juste", $bdd->comptejeune[$idjeune]->savoiretreref[$i]->savoiretre) ? 'checked="checked"' : '') . '>
                <label for="impartial">Impartial</label><input type="checkbox" name="savoiretreref[]" id="impartial" value="impartial"' . (in_array("impartial", $bdd->comptejeune[$idjeune]->savoiretreref[$i]->savoiretre) ? 'checked="checked"' : '') . '>
                <label for="travail">Travail</label><input type="checkbox" name="savoiretreref[]" id="travail" value="travail"' . (in_array("travail", $bdd->comptejeune[$idjeune]->savoiretreref[$i]->savoiretre) ? 'checked="checked"' : '') . '>
            </div>
            <div class="choix">
            *faire 4 choix maximum
            </div>
            <div class="boxgauche-referent">

            <div class="boxcommentaire-referent">
                COMMENTAIRES
            </div>';
            $sav = 1;
        }
        // commentaire
        if (!$com && isset($bdd->comptejeune[$idjeune]->commentaire[$i]) && $bdd->comptejeune[$idjeune]->commentaire[$i]->de == $idreferent) {
            echo '<div class="commentaire-referent">
            <textarea name="commentaire" id="commentaire" cols="30" rows="10">' . $bdd->comptejeune[$idjeune]->commentaire[$i]->texte.'</textarea>
            </div>';
            $com = 1;
        }

    }



    echo '</div></div>';
} else { // formulaire vide

    echo '
    <form action="/php/inscriptionreferent.php" method="post">
    <div class="boxreferent" >
    <div class="referent">
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
        .'<input type="submit" class="valider value="Envoyer">
        </div>
        </div>
    </form>
    ';
}

?>


