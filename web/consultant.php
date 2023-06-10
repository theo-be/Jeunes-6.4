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
    <link rel="stylesheet" type="text/css" href="/css/header.css" >
    <title>Referent</title>
</head>
<body>

    <?php

        require_once "../php/header.php";

        echo '
        <a href="/php/deconnexion.php">Deconnexion</a>
    ';
        if (!isset($_GET["t"]) || !$_GET["t"]) {
            echo "ERREUR : pas de token";
        } else {
            // regarder dans les tokens et trouver le bon
            // récup les infos de compte et les retrouver dans la bdd
            // afficher les infos du jeune et le form du referent

            

            $contenutoken = file_get_contents("../data/token.json");
            $token = json_decode($contenutoken, false);
            $nbtokens = count($token->token);
            
            $contenufichier = file_get_contents("../data/bdd.json");
            $bdd = json_decode($contenufichier, false);

            $idref = 0;
            $idjeune = 0;

            $trouvejeton = 0;
            for ($i = 0; $i < $nbtokens; $i++) {
                if ($token->token[$i]->token == $_GET["t"] && $token->token[$i]->type == "consultant" && $token->token[$i]->etat == "en cours") {
                    $trouvejeton = 1;
                    $idref = chercheCompteReferentParId($bdd, $token->token[$i]->idref);
                    $idjeune = chercheCompteJeuneParId($bdd, $token->token[$i]->idjeune);
                    $_SESSION["tokenid"] = $i;
                    $_SESSION["idjeune"] = $idjeune;
                    $_SESSION["idref"] = $idref;
                    break;
                }
            }
            if (!$trouvejeton) {
                echo "token invalide ou a expiré";
                $_SESSION = array();
                session_destroy();
            }
            else {
                // echo '<a href="../php/deconnexion.php">Deconnexion</a>';
                $_SESSION["statut_client"] = "consultant";
                $compteref = $bdd->compteref[$idref];

            
                // affichage des infos du jeune
                echo "<div>";
                echo "<p>Informations du jeune</p>";
                echo "<p>Prénom : " . $bdd->comptejeune[$idjeune]->prenom . "</p>";
                echo "<p>Nom : " . $bdd->comptejeune[$idjeune]->nom . "</p>";
                echo "<p>email : " . $bdd->comptejeune[$idjeune]->email . "</p>";
                echo "<p>datenaissance : " . $bdd->comptejeune[$idjeune]->datenaissance . "</p>";
                echo "<p>reseau : " . $bdd->comptejeune[$idjeune]->reseau . "</p>";
                echo "<p>engagement : " . $bdd->comptejeune[$idjeune]->engagement . "</p>";
                echo "<p>duree : " . $bdd->comptejeune[$idjeune]->duree . "</p>";
                echo '
                <p>Mes savoirs être*</p>
                autonome<input type="checkbox" name="savoiretre[]" id="autonome" value="autonome"' . (in_array("autonome", $bdd->comptejeune[$idjeune]->savoiretre) ? 'checked="checked"' : '') . '>
                passionne<input type="checkbox" name="savoiretre[]" id="passionne" value="passionne"' . (in_array("passionne", $bdd->comptejeune[$idjeune]->savoiretre) ? 'checked="checked"' : '') . '>
                reflechi<input type="checkbox" name="savoiretre[]" id="reflechi" value="reflechi"' . (in_array("reflechi", $bdd->comptejeune[$idjeune]->savoiretre) ? 'checked="checked"' : '') . '>
                alecoute<input type="checkbox" name="savoiretre[]" id="alecoute" value="alecoute"' . (in_array("alecoute", $bdd->comptejeune[$idjeune]->savoiretre) ? 'checked="checked"' : '') . '>
                organise<input type="checkbox" name="savoiretre[]" id="organise" value="organise"' . (in_array("organise", $bdd->comptejeune[$idjeune]->savoiretre) ? 'checked="checked"' : '') . '>
                fiable<input type="checkbox" name="savoiretre[]" id="fiable" value="fiable"' . (in_array("fiable", $bdd->comptejeune[$idjeune]->savoiretre) ? 'checked="checked"' : '') . '>
                patient<input type="checkbox" name="savoiretre[]" id="patient" value="patient"' . (in_array("confiance", $bdd->comptejeune[$idjeune]->savoiretre) ? 'checked="checked"' : '') . '>
                responsable<input type="checkbox" name="savoiretre[]" id="responsable" value="responsable"' . (in_array("responsable", $bdd->comptejeune[$idjeune]->savoiretre) ? 'checked="checked"' : '') . '>
                sociable<input type="checkbox" name="savoiretre[]" id="sociable" value="sociable"' . (in_array("sociable", $bdd->comptejeune[$idjeune]->savoiretre) ? 'checked="checked"' : '') . '>
                optimiste<input type="checkbox" name="savoiretre[]" id="optimiste" value="optimiste"' . (in_array("optimiste", $bdd->comptejeune[$idjeune]->savoiretre) ? 'checked="checked"' : '') . '>';
                echo "</div>";
            
                // affichage des infos de tous les referents

                $tailleidref = count($bdd->comptejeune[$idjeune]->idref);
                $taillecompteref = count($bdd->compteref);
                $taillecommentaire = count($bdd->comptejeune[$idjeune]->commentaire);
                for ($i = 0; $i < $tailleidref; $i++) {

                    for ($j = 0; $j < $taillecompteref; $j++) {
                        if ($bdd->comptejeune[$idjeune]->idref[$i] == $bdd->compteref[$j]->id) {

                            echo '
                            <div>
                            <p>nom referent : '.$bdd->compteref[$j]->nom.'</p>
                            <p>prenom referent : '.$bdd->compteref[$j]->prenom.'</p>
                            <p>email referent : '.$bdd->compteref[$j]->email.'</p>
                            <p>datenaissance referent : '.$bdd->compteref[$j]->datenaissance.'</p>
                            <p>reseau referent : '.$bdd->compteref[$j]->reseau.'</p>
                            <p>presentation referent : '.$bdd->compteref[$j]->presentation.'</p>
                            <p>duree referent : '.$bdd->compteref[$j]->duree.'</p>
                            <p>Ses savoirs être</p>
                            ';
                            // commentaire du referent sur le jeune et cases a cocher
                            for ($k = 0; $k < $taillecommentaire; $k++) {
                                // cases a cocher
                                if ($bdd->comptejeune[$idjeune]->savoiretreref[$k]->de == $bdd->compteref[$j]->id) {
                                    echo '<p>
                                    confiance<input type="checkbox" name="savoiretreref[]" id="confiance" value="confiance"' . (in_array("confiance", $bdd->comptejeune[$idjeune]->savoiretreref[$k]->savoiretre) ? 'checked="checked"' : '') . '>
                                    bienveillance<input type="checkbox" name="savoiretreref[]" id="bienveillance" value="bienveillance"' . (in_array("bienveillance", $bdd->comptejeune[$idjeune]->savoiretreref[$k]->savoiretre) ? 'checked="checked"' : '') . '>
                                    respect<input type="checkbox" name="savoiretreref[]" id="respect" value="respect"' . (in_array("respect", $bdd->comptejeune[$idjeune]->savoiretreref[$k]->savoiretre) ? 'checked="checked"' : '') . '>
                                    honnetete<input type="checkbox" name="savoiretreref[]" id="honnetete" value="honnetete"' . (in_array("honnetete", $bdd->comptejeune[$idjeune]->savoiretreref[$k]->savoiretre) ? 'checked="checked"' : '') . '>
                                    tolerance<input type="checkbox" name="savoiretreref[]" id="tolerance" value="tolerance"' . (in_array("tolerance", $bdd->comptejeune[$idjeune]->savoiretreref[$k]->savoiretre) ? 'checked="checked"' : '') . '>
                                    juste<input type="checkbox" name="savoiretreref[]" id="juste" value="juste"' . (in_array("juste", $bdd->comptejeune[$idjeune]->savoiretreref[$k]->savoiretre) ? 'checked="checked"' : '') . '>
                                    impartial<input type="checkbox" name="savoiretreref[]" id="impartial" value="impartial"' . (in_array("impartial", $bdd->comptejeune[$idjeune]->savoiretreref[$k]->savoiretre) ? 'checked="checked"' : '') . '>
                                    travail<input type="checkbox" name="savoiretreref[]" id="travail" value="travail"' . (in_array("travail", $bdd->comptejeune[$idjeune]->savoiretreref[$k]->savoiretre) ? 'checked="checked"' : '') . '><br>
                                    </p>';
                                }

                                // commentaire
                                if ($bdd->comptejeune[$idjeune]->commentaire[$k]->de == $bdd->compteref[$j]->id) {
                                    echo '<p>commentaire :' . $bdd->comptejeune[$idjeune]->commentaire[$k]->texte.'</p>';
                                    break;
                                }
                                
                            }

                            echo '<p>Statut de la demande de référencement : '.$bdd->comptejeune[$idjeune]->statutdemande[$i].'</p>';
                            echo '</div>';

                            break;
                            
                        }

                    }
                }


                echo '<a href="/php/confirmationconsultant.php">Je confirme la demande</a>';
                echo '<a href="/php/refusconsultant.php">Je refuse la demande</a>';

            }
        }


    ?>


</body>
</html>