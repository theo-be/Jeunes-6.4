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
    <link href="/css/referent.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/header.css" >
    <link href="/css/consultant.css" rel="stylesheet">
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
                echo '
                
                <div class="boxjeune" >


                    <div class="jeune">
                        JEUNE
                    </div>
                
                    <div class="texte">';
                    
                        echo '<p>Informations du jeune</p>';
                        echo '<p>Prénom : ' . $bdd->comptejeune[$idjeune]->prenom. '</p>';
                        echo '<p>Nom : ' . $bdd->comptejeune[$idjeune]->nom. '</p>';
                        echo '<p>email : ' . $bdd->comptejeune[$idjeune]->email. '</p>';
                        echo '<p>datenaissance : ' . $bdd->comptejeune[$idjeune]->datenaissance. '</p>';
                        echo '<p>reseau : ' . $bdd->comptejeune[$idjeune]->reseau. '</p>';
                        echo '<p>engagement : ' . $bdd->comptejeune[$idjeune]->engagement. '</p>';
                        echo '<p>duree : ' . $bdd->comptejeune[$idjeune]->duree. '</p>';
                    echo '</div>

                                
                    <div class="petite-case">


                        <div class="savoirs-jeune">
                            MES SAVOIRS ETRE
                        </div>

                        <div class="jesuis">
                            Je suis*
                        </div>
                        <div class="coche-jeune">';

                            if (in_array("autonome", $bdd->comptejeune[$idjeune]->savoiretre))
                            echo '<label for="autonome">Autonome</label><input type="checkbox" name="savoiretre[]" id="autonome" value="autonome" checked="checked" disabled>';
                            if (in_array("passionne", $bdd->comptejeune[$idjeune]->savoiretre))
                            echo '<label for="passionne">Passionné</label><input type="checkbox" name="savoiretre[]" id="passionne" value="passionne" checked="checked" disabled>';
                            if (in_array("reflechi", $bdd->comptejeune[$idjeune]->savoiretre))
                            echo '<label for="reflechi">Réfléchi</label><input type="checkbox" name="savoiretre[]" id="reflechi" value="reflechi" checked="checked" disabled>';
                            if (in_array("alecoute", $bdd->comptejeune[$idjeune]->savoiretre))
                            echo '<label for="alecoute">A l\'écoute</label><input type="checkbox" name="savoiretre[]" id="alecoute" value="alecoute" checked="checked" disabled>';
                            if (in_array("organise", $bdd->comptejeune[$idjeune]->savoiretre))
                            echo '<label for="organise">Organisé</label><input type="checkbox" name="savoiretre[]" id="organise" value="organise" checked="checked" disabled>';
                            if (in_array("fiable", $bdd->comptejeune[$idjeune]->savoiretre))
                            echo '<label for="fiable">Fiable</label><input type="checkbox" name="savoiretre[]" id="fiable" value="fiable" checked="checked" disabled>';
                            if (in_array("patient", $bdd->comptejeune[$idjeune]->savoiretre))
                            echo '<label for="patient">Patient</label><input type="checkbox" name="savoiretre[]" id="patient" value="patient" checked="checked" disabled>';
                            if (in_array("responsable", $bdd->comptejeune[$idjeune]->savoiretre))
                            echo '<label for="responsable">Responsable</label><input type="checkbox" name="savoiretre[]" id="responsable" value="responsable" checked="checked" disabled>';
                            if (in_array("sociable", $bdd->comptejeune[$idjeune]->savoiretre))
                            echo '<label for="sociable">Sociable</label><input type="checkbox" name="savoiretre[]" id="sociable" value="sociable" checked="checked" disabled>';
                            if (in_array("optimiste", $bdd->comptejeune[$idjeune]->savoiretre))
                            echo '<label for="optimiste">Optimiste</label><input type="checkbox" name="savoiretre[]" id="optimiste" value="optimiste" checked="checked" disabled>';
                    
                        echo "</div>
                    </div>
                </div>";
            
                // affichage des infos de tous les referents

                $tailleidref = count($bdd->comptejeune[$idjeune]->idref);
                $taillecompteref = count($bdd->compteref);
                $taillecommentaire = count($bdd->comptejeune[$idjeune]->commentaire);
                for ($i = 0; $i < $tailleidref; $i++) {

                    for ($j = 0; $j < $taillecompteref; $j++) {
                        if ($bdd->comptejeune[$idjeune]->idref[$i] == $bdd->compteref[$j]->id && $bdd->comptejeune[$idjeune]->statutdemande[$i] == "Demande validée par le référent") {

                            echo '
                            <div class="boxreferent" >
                                <div class="referent">
                                    REFERENT
                                </div>


                                <div class="texte">
                                    <p>nom referent : '.$bdd->compteref[$j]->nom.'</p>
                                    <p>prenom referent : '.$bdd->compteref[$j]->prenom.'</p>
                                    <p>email referent : '.$bdd->compteref[$j]->email.'</p>
                                    <p>datenaissance referent : '.$bdd->compteref[$j]->datenaissance.'</p>
                                    <p>reseau referent : '.$bdd->compteref[$j]->reseau.'</p>
                                    <p>presentation referent : '.$bdd->compteref[$j]->presentation.'</p>
                                    <p>duree referent : '.$bdd->compteref[$j]->duree.'</p>
                                </div>
                                ';
                                // commentaire du referent sur le jeune et cases a cocher
                                for ($k = 0; $k < $taillecommentaire; $k++) {
                                    // cases a cocher
                                    if ($bdd->comptejeune[$idjeune]->savoiretreref[$k]->de == $bdd->compteref[$j]->id) {
                                        echo '<div class="petite-case">


                                            <div class="savoirs-referent">
                                                SES SAVOIRS ETRE
                                            </div>
                                            
                                            <div class="jeconfirme">
                                                Je confirme sa(son)*
                                            </div>
                                            <div class="coche-referent">';
                                                if (in_array("confiance", $bdd->comptejeune[$idjeune]->savoiretreref[$k]->savoiretre))
                                                echo '<label for="confiance">Confiance</label><input type="checkbox" name="savoiretreref[]" id="confiance" value="confiance" checked="checked" disabled>';
                                                if (in_array("bienveillance", $bdd->comptejeune[$idjeune]->savoiretreref[$k]->savoiretre))
                                                echo '<label for="bienveillance">Bienveillance</label><input type="checkbox" name="savoiretreref[]" id="bienveillance" value="bienveillance" checked="checked" disabled>';
                                                if (in_array("respect", $bdd->comptejeune[$idjeune]->savoiretreref[$k]->savoiretre))
                                                echo '<label for="respect">Respect</label><input type="checkbox" name="savoiretreref[]" id="respect" value="respect" checked="checked" disabled>';
                                                if (in_array("honnetete", $bdd->comptejeune[$idjeune]->savoiretreref[$k]->savoiretre))                                    
                                                echo '<label for="honnetete">Honneteté</label><input type="checkbox" name="savoiretreref[]" id="honnetete" value="honnetete" checked="checked" disabled>';
                                                if (in_array("tolerance", $bdd->comptejeune[$idjeune]->savoiretreref[$k]->savoiretre))
                                                echo '<label for="tolerance">Tolérance</label><input type="checkbox" name="savoiretreref[]" id="tolerance" value="tolerance" checked="checked"disabled >';
                                                if (in_array("juste", $bdd->comptejeune[$idjeune]->savoiretreref[$k]->savoiretre))
                                                echo '<label for="juste">Juste</label><input type="checkbox" name="savoiretreref[]" id="juste" value="juste" checked="checked" disabled>';
                                                if (in_array("impartial", $bdd->comptejeune[$idjeune]->savoiretreref[$k]->savoiretre))
                                                echo '<label for="impartial">Impartial</label><input type="checkbox" name="savoiretreref[]" id="impartial" value="impartial" checked="checked" disabled>';
                                                if (in_array("travail", $bdd->comptejeune[$idjeune]->savoiretreref[$k]->savoiretre))
                                                echo '<label for="travail">Travail</label><input type="checkbox" name="savoiretreref[]" id="travail" value="travail" checked="checked" disabled>';
                                            echo '</div>';
                                        echo '</div>';
                                    }
                                    // commentaire
                                    if ($bdd->comptejeune[$idjeune]->commentaire[$k]->de == $bdd->compteref[$j]->id) {
                                        echo '<span class="texte">commentaire : ' . $bdd->comptejeune[$idjeune]->commentaire[$k]->texte.'</span>';
                                        break;
                                    }
                                }
                            echo '</div>';

                            break;
                            
                        }

                    }
                }

                echo '<div class="lienconsultant">';
                echo '<a href="/php/confirmationconsultant.php" class="valider-consultant">Je confirme la demande</a>';
                echo '<a href="/php/refusconsultant.php" class="valider-consultant">Je refuse la demande</a>';
                echo '</div>';
            }
        }


    ?>


</body>
</html>

