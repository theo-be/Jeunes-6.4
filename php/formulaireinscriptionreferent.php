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
    <div class="referentdétail">

    <div>Statut de la demande de référencement : '.$bdd->comptejeune[$idjeune]->statutdemande[$indexref].'</div>
<br>
    <label for="nomref">Nom</label>* <input type="text" name="nomref" id="nomref" required="required" value="'.$compte->nom.'">
    <label for="prenomref">Prénom</label>* <input type="text" name="prenomref" id="prenomref" required="required" value="'.$compte->prenom.'"><br>
    <label for="emailref">Email</label>* <input type="text" name="emailref" id="emailref" required="required" value="'.$compte->email.'"><br>
    <label for="datenaissanceref">Date de naissance</label>* <input type="text" name="datenaissanceref" id="datenaissanceref" required="required" value="'.$compte->datenaissance.'"><br>
    <label for="reseauref">Réseau social</label>* <input type="text" name="reseauref" id="reseauref" required="required" value="'.$compte->reseau.'"><br>
    <label for="presentationref">Présentation</label>* <input type="text" name="presentationref" id="presentationref" required="required" value="'.$compte->presentation.'"><br>
    <label for="dureeref">Durée</label>* <input type="text" name="dureeref" id="dureeref" required="required" value="'.$compte->duree.'"><br>
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
                <input type="checkbox" name="savoiretreref[]" id="confiance" class="case-coche" value="confiance"' . (in_array("confiance", $bdd->comptejeune[$idjeune]->savoiretreref[$i]->savoiretre) ? 'checked="checked"' : '') . '><label for="confiance">Confiance</label><br>
                <input type="checkbox" name="savoiretreref[]" id="bienveillance" class="case-coche" value="bienveillance"' . (in_array("bienveillance", $bdd->comptejeune[$idjeune]->savoiretreref[$i]->savoiretre) ? 'checked="checked"' : '') . '><label for="bienveillance">Bienveillance</label><br>
                <input type="checkbox" name="savoiretreref[]" id="respect" class="case-coche" value="respect"' . (in_array("respect", $bdd->comptejeune[$idjeune]->savoiretreref[$i]->savoiretre) ? 'checked="checked"' : '') . '><label for="respect">Respect</label><br>
                <input type="checkbox" name="savoiretreref[]" id="honnetete" class="case-coche" value="honnetete"' . (in_array("honnetete", $bdd->comptejeune[$idjeune]->savoiretreref[$i]->savoiretre) ? 'checked="checked"' : '') . '><label for="honnetete">Honneteté</label><br>
                <input type="checkbox" name="savoiretreref[]" id="tolerance" class="case-coche" value="tolerance"' . (in_array("tolerance", $bdd->comptejeune[$idjeune]->savoiretreref[$i]->savoiretre) ? 'checked="checked"' : '') . '><label for="tolerance">Tolérance</label><br>
                <input type="checkbox" name="savoiretreref[]" id="juste" class="case-coche" value="juste"' . (in_array("juste", $bdd->comptejeune[$idjeune]->savoiretreref[$i]->savoiretre) ? 'checked="checked"' : '') . '><label for="juste">Juste</label><br>
                <input type="checkbox" name="savoiretreref[]" id="impartial" class="case-coche" value="impartial"' . (in_array("impartial", $bdd->comptejeune[$idjeune]->savoiretreref[$i]->savoiretre) ? 'checked="checked"' : '') . '><label for="impartial">Impartial</label><br>
                <input type="checkbox" name="savoiretreref[]" id="travail" class="case-coche" value="travail"' . (in_array("travail", $bdd->comptejeune[$idjeune]->savoiretreref[$i]->savoiretre) ? 'checked="checked"' : '') . '><label for="travail">Travail</label><br>
            </div>
            <div class="choix-referent">
            *faire 4 choix maximum
            </div>
           </div>
            ';
            $sav = 1;
        }
        // commentaire
        if (!$com && isset($bdd->comptejeune[$idjeune]->commentaire[$i]) && $bdd->comptejeune[$idjeune]->commentaire[$i]->de == $idreferent) {
            echo '<div class="boxgauche-referentformulaire">

            <div class="boxcommentaire-referent">
                COMMENTAIRES
            </div>
            <div class="commentaire-referent">
            <textarea name="commentaire" id="commentaire" cols="27" rows="24">' . $bdd->comptejeune[$idjeune]->commentaire[$i]->texte.'</textarea>
            </div></div>';
            $com = 1;
        }

    }



    echo '</div></div>';
} else { // formulaire vide

    echo '
    <form action="/php/inscriptionreferent.php" method="post">
    <div class="boxreferentajout" >
    <div class="referent">
    <label for="nomref">Nom</label>* <input type="text" name="nomref" id="nomref" required="required"><br>
    <label for="prenomref">Prénom</label>* <input type="text" name="prenomref" id="prenomref" required="required"><br>
    <label for="emailref">Email</label>* <input type="text" name="emailref" id="emailref" required="required"><br>
    <label for="datenaissanceref">Date de naissance</label>* <input type="text" name="datenaissanceref" id="datenaissanceref" required="required"><br>
    <label for="reseauref">Réseau social</label>* <input type="text" name="reseauref" id="reseauref" required="required"><br>
    <label for="presentationref">Présentation</label>* <input type="text" name="presentationref" id="presentationref" required="required"><br>
    <label for="dureeref">Durée</label>* <input type="text" name="dureeref" id="dureeref" required="required"><br>'
      
        .'<input type="submit" class="valider-referent" value="Envoyer">
        </div>
        </div>
    </form>
    ';
}

?>


