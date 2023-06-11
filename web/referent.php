<?php
session_start();
require_once "../php/verifsession.php";
require_once "../php/cherchecompte.php";
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/jeune.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/header.css" >
    <link href="/css/referent.css" rel="stylesheet">
    <title>Referent</title>
    <script>
    // script qui limite le nombre de cases cochées à 4
     function limitCheckboxSelection() {
            var checkboxes = document.getElementsByClassName("coche-referent")[0].querySelectorAll('input[type="checkbox"]');
            var checkedCount = 0;

            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    checkedCount++;
                }
            }

            if (checkedCount >= 4) {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (!checkboxes[i].checked) {
                        checkboxes[i].disabled = true;
                    }
                }
            } else {
                for (var i = 0; i < checkboxes.length; i++) {
                    checkboxes[i].disabled = false;
                }
            }
        }
    </script>
</head>
<body>

    <?php

        require_once "../php/header.php";

        if (!isset($_GET["t"]) || !$_GET["t"]) {
            // permet aux autres utilisateurs de comprendre que cette page ne leur est pas destinée
            echo "ERREUR : pas de token";
        } else {            

            $contenutoken = file_get_contents("../data/token.json");
            $token = json_decode($contenutoken, false);
            $nbtokens = count($token->token);
            
            $contenufichier = file_get_contents("../data/bdd.json");
            $bdd = json_decode($contenufichier, false);

            $idref = 0;
            $idjeune = 0;

            // verification de l'existence du token
            
            $trouvejeton = 0;
            for ($i = 0; $i < $nbtokens; $i++) {
                if ($token->token[$i]->token == $_GET["t"] && $token->token[$i]->type == "referent" && $token->token[$i]->etat == "en cours") {
                    $trouvejeton = 1;
                    $idref = chercheCompteReferentParId($bdd, $token->token[$i]->idref);
                    $idjeune = chercheCompteJeuneParId($bdd, $token->token[$i]->idjeune);
                    $_SESSION["tokenid"] = $i;
                    $_SESSION["idjeune"] = $idjeune;
                    break;
                }
            }
            if (!$trouvejeton) {
                echo "token invalide ou a expiré";
                $_SESSION = array();
                session_destroy();
            }
            else {
                echo '<a href="/php/deconnexion.php" class="deconnexion">Déconnexion</a>';
                $_SESSION["statut_client"] = "referent";
                $_SESSION["idcompte"] = $idref;
                $compte = $bdd->compteref[$idref];
            
                // affichage des infos du referent                

                echo '    <div class="textereferent">
                Confirmez cette expérience et ce que vous avez
                </div>
                <div class="textereferent2">
                pu constater au contact de ce jeune. <br> <br>
                </div>';

                // formulaire du référent
                echo '
                <form action="/php/confirmationreferencement.php" method="post">
                <div class="boxreferent" >
                <div class="referent">
                    <label for="nomref">Nom</label>* <input type="text" name="nomref" id="nomref" required="required" value="'.$compte->nom.'">
                    <label for="prenomref">Prénom</label>* <input type="text" name="prenomref" id="prenomref" required="required" value="'.$compte->prenom.'"><br>
                    <label for="emailref">Email</label>* <input type="text" name="emailref" id="emailref" required="required" value="'.$compte->email.'"><br>
                    <label for="datenaissanceref">Date de naissance</label>* <input type="text" name="datenaissanceref" id="datenaissanceref" required="required" value="'.$compte->datenaissance.'">
                    <label for="reseauref">Réseau social</label>* <input type="text" name="reseauref" id="reseauref" required="required" value="'.$compte->reseau.'"><br><br>
                    <label for="presentationref">Présentation</label>* <input type="text" name="presentationref" id="presentationref" required="required" value="'.$compte->presentation.'"><br>
                    <label for="dureeref">Durée</label>* <input type="text" name="dureeref" id="dureeref" required="required" value="'.$compte->duree.'">
                </div>
                </div>';
                    echo '
                    <div class="boxdroite-referent">
                    
                    <div class="messavoirs-referent">
                    <b>SES SAVOIRS ETRE</b>
                    </div>

                    <div class="boxconfirme-referent">
                        <b>Je confirme sa(son)*</b>
                    </div>
                    <div class="coche-referent">
                    
                    <input type="checkbox" name="savoiretreref[]" id="confiance" value="confiance" onclick="limitCheckboxSelection()" class="case-coche"><label for="confiance">Confiance</label><br>
                    <input type="checkbox" name="savoiretreref[]" id="bienveillance" value="bienveillance" onclick="limitCheckboxSelection()" class="case-coche"><label for="bienveillance">Bienveillance</label><br>
                    <input type="checkbox" name="savoiretreref[]" id="respect" value="respect" onclick="limitCheckboxSelection()" class="case-coche"><label for="respect">Respect</label><br>
                    <input type="checkbox" name="savoiretreref[]" id="honnetete" value="honnetete" onclick="limitCheckboxSelection()" class="case-coche"><label for="honnetete">Honneteté</label><br>
                    <input type="checkbox" name="savoiretreref[]" id="tolerance" value="tolerance" onclick="limitCheckboxSelection()" class="case-coche"><label for="tolerance">Tolérance</label><br>
                    <input type="checkbox" name="savoiretreref[]" id="juste" value="juste" onclick="limitCheckboxSelection()" class="case-coche"><label for="juste">Juste</label><br>
                    <input type="checkbox" name="savoiretreref[]" id="impartial" value="impartial" onclick="limitCheckboxSelection()" class="case-coche"><label for="impartial">Impartial</label><br>
                    <input type="checkbox" name="savoiretreref[]" id="travail" value="travail" onclick="limitCheckboxSelection()" class="case-coche"><label for="travail">Travail</label><br>   
                    </div>
                    <div class="choix-referent">
                    *faire 4 choix maximum
                  </div>
                   
                    </div>

                    <div class="boxgauche-referent">

                    <div class="boxcommentaire-referent">
                        COMMENTAIRES
                    </div>
                
                    <div class="commentaire-referent">
                    <textarea name="commentaire" id="commentaire" cols="27" rows="24"></textarea>
                    </div>
                
                    </div>
                ';


                // affichage des infos du jeune
                echo '
                <div class="boxinfosjeune-referent">
                <div class="informations-du-jeune">
                <u>Informations du jeune</u>
                </div>
                <div>
                <div class="boxjeune" >
                <div class="Jeune">';
                
                echo "<p>Prénom : " . $bdd->comptejeune[$idjeune]->prenom . "</p>";
                echo "<p>Nom : " . $bdd->comptejeune[$idjeune]->nom . "</p>";
                echo "<p>Date de naissance: " . $bdd->comptejeune[$idjeune]->datenaissance . "</p>";
                echo "<p>Email : " . $bdd->comptejeune[$idjeune]->email . "</p>";
                echo "<p>Réseau social : " . $bdd->comptejeune[$idjeune]->reseau . "</p>";
                echo "<p>Engagement : " . $bdd->comptejeune[$idjeune]->engagement . "</p>";
                echo "<p>Durée : " . $bdd->comptejeune[$idjeune]->duree . "</p>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                // cases a cocher sans attribut name pour eviter qu'ils soient envoyés inutilement au serveur
                echo '
                
                <div class="boxdroite-jeune">
                    <div class="messavoirs-jeune">
                        <b>MES SAVOIRS ETRE</b>
                    </div>
                    <div class="boxconfirme-jeune">
                        <b>Je suis*</b>
                    </div>
                    <div class="coche-jeune">

                    <input type="checkbox" id="autonome" class="case-coche-jeune" value="autonome"' . (in_array("autonome", $bdd->comptejeune[$idjeune]->savoiretre) ? 'checked="checked" disabled' : '') . '><label for="autonome">Autonome</label><br>
                        <input type="checkbox" id="passionne" class="case-coche-jeune" value="passionne"' . (in_array("passionne", $bdd->comptejeune[$idjeune]->savoiretre) ? 'checked="checked" disabled' : '') . '><label for="passionne">Passionné</label><br>
                        <input type="checkbox" id="reflechi" class="case-coche-jeune" value="reflechi"' . (in_array("reflechi", $bdd->comptejeune[$idjeune]->savoiretre) ? 'checked="checked" disabled' : '') . '><label for="reflechi">Réfléchi</label><br>
                        <input type="checkbox" id="alecoute" class="case-coche-jeune" value="alecoute"' . (in_array("alecoute", $bdd->comptejeune[$idjeune]->savoiretre) ? 'checked="checked" disabled' : '') . '><label for="alecoute">A l\'écoute</label><br>
                       <input type="checkbox" id="organise" class="case-coche-jeune" value="organise"' . (in_array("organise", $bdd->comptejeune[$idjeune]->savoiretre) ? 'checked="checked" disabled' : '') . '> <label for="organise">Organisé</label><br>
                       <input type="checkbox" id="fiable" class="case-coche-jeune" value="fiable"' . (in_array("fiable", $bdd->comptejeune[$idjeune]->savoiretre) ? 'checked="checked" disabled' : '') . '> <label for="fiable">Fiable</label><br>
                       <input type="checkbox" id="patient" class="case-coche-jeune" value="patient"' . (in_array("confiance", $bdd->comptejeune[$idjeune]->savoiretre) ? 'checked="checked" disabled' : '') . '> <label for="patient">Patient</label><br>
                        <input type="checkbox" id="responsable" class="case-coche-jeune" value="responsable"' . (in_array("responsable", $bdd->comptejeune[$idjeune]->savoiretre) ? 'checked="checked" disabled' : '') . '><label for="responsable">Responsable</label><br>
                        <input type="checkbox" id="sociable" class="case-coche-jeune" value="sociable"' . (in_array("sociable", $bdd->comptejeune[$idjeune]->savoiretre) ? 'checked="checked" disabled' : '') . '><label for="sociable">Sociable</label><br>
                       <input type="checkbox" id="optimiste" class="case-coche-jeune" value="optimiste"' . (in_array("optimiste", $bdd->comptejeune[$idjeune]->savoiretre) ? 'checked="checked" disabled' : '') . '> <label for="optimiste">Optimiste</label><br>
                    </div>
                </div>
                </div>
                ';
                echo '<input type="submit" class="valider-referent" value="Valider la demande de référencement">';
                echo '<a href="/php/refusreferent.php" class="refuser-referent">Refuser la demande de référencement</a>';
                echo '</form>';
            }
        }

?>


</body>
</html>
