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
        <a href="/php/deconnexion.php" class="deconnexion">Deconnexion</a>
    ';
        if (!isset($_GET["t"]) || !$_GET["t"]) {
            echo "ERREUR : pas de token";
        } else {
            // regarder dans les tokens et trouver le bon
            // récup les infos de compte et les retrouver dans la bdd
            // afficher les infos du jeune et le form du referent

            
            // chargement de la base de données

            $contenutoken = file_get_contents("../data/token.json");
            $token = json_decode($contenutoken, false);
            $nbtokens = count($token->token);
            
            $contenufichier = file_get_contents("../data/bdd.json");
            $bdd = json_decode($contenufichier, false);

            $idref = 0;
            $idjeune = 0;

            
            // vérification du jeton
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
                
                <div class="boxjeune-consultant" >


                    <div class="jeune-consultant">
                        JEUNE
                    </div>
                
                    <div class="texte">';
                    
                        
                        echo '<p>Prénom : ' . $bdd->comptejeune[$idjeune]->prenom. '</p>';
                        echo '<p>Nom : ' . $bdd->comptejeune[$idjeune]->nom. '</p>';
                        echo '<p>Email : ' . $bdd->comptejeune[$idjeune]->email. '</p>';
                        echo '<p>Date de naissance : ' . $bdd->comptejeune[$idjeune]->datenaissance. '</p>';
                        echo '<p>Réseau social : ' . $bdd->comptejeune[$idjeune]->reseau. '</p>';
                        echo '<p>Engagement : ' . $bdd->comptejeune[$idjeune]->engagement. '</p>';
                        echo '<p>Durée : ' . $bdd->comptejeune[$idjeune]->duree. '</p>';
                    echo '</div>

                                
                    <div class="petite-case">


                        <div class="savoirs-jeune">
                            MES SAVOIRS ETRE
                        </div>

                        <div class="jesuis-consultant">
                            Je suis*
                        </div>
                        <div class="coche-jeune-consultant">';

                            if (in_array("autonome", $bdd->comptejeune[$idjeune]->savoiretre))
                            echo '<input type="checkbox" name="savoiretre[]" id="autonome" class="case-coche-consultant" value="autonome" checked="checked" disabled><label for="autonome">Autonome</label><br>';
                            if (in_array("passionne", $bdd->comptejeune[$idjeune]->savoiretre))
                            echo '<input type="checkbox" name="savoiretre[]" id="passionne" class="case-coche-consultant" value="passionne" checked="checked" disabled><label for="passionne">Passionné</label><br>';
                            if (in_array("reflechi", $bdd->comptejeune[$idjeune]->savoiretre))
                            echo '<input type="checkbox" name="savoiretre[]" id="reflechi" class="case-coche-consultant" value="reflechi" checked="checked" disabled><label for="reflechi">Réfléchi</label><br>';
                            if (in_array("alecoute", $bdd->comptejeune[$idjeune]->savoiretre))
                            echo '<input type="checkbox" name="savoiretre[]" id="alecoute" class="case-coche-consultant" value="alecoute" checked="checked" disabled><label for="alecoute">A l\'écoute</label><br>';
                            if (in_array("organise", $bdd->comptejeune[$idjeune]->savoiretre))
                            echo '<input type="checkbox" name="savoiretre[]" id="organise" class="case-coche-consultant" value="organise" checked="checked" disabled><label for="organise">Organisé</label><br>';
                            if (in_array("fiable", $bdd->comptejeune[$idjeune]->savoiretre))
                            echo '<input type="checkbox" name="savoiretre[]" id="fiable" class="case-coche-consultant" value="fiable" checked="checked" disabled><label for="fiable">Fiable</label><br>';
                            if (in_array("patient", $bdd->comptejeune[$idjeune]->savoiretre))
                            echo '<input type="checkbox" name="savoiretre[]" id="patient" class="case-coche-consultant" value="patient" checked="checked" disabled><label for="patient">Patient</label><br>';
                            if (in_array("responsable", $bdd->comptejeune[$idjeune]->savoiretre))
                            echo '<input type="checkbox" name="savoiretre[]" id="responsable" class="case-coche-consultant" value="responsable" checked="checked" disabled><label for="responsable">Responsable</label><br>';
                            if (in_array("sociable", $bdd->comptejeune[$idjeune]->savoiretre))
                            echo '<input type="checkbox" name="savoiretre[]" id="sociable" class="case-coche-consultant" value="sociable" checked="checked" disabled><label for="sociable">Sociable</label><br>';
                            if (in_array("optimiste", $bdd->comptejeune[$idjeune]->savoiretre))
                            echo '<input type="checkbox" name="savoiretre[]" id="optimiste" class="case-coche-consultant" value="optimiste" checked="checked" disabled><label for="optimiste">Optimiste</label><br>';
                    
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


                                <div class="texte-consultant">
                                    <p>Nom: '.$bdd->compteref[$j]->nom.'</p>
                                    <p>Prénom: '.$bdd->compteref[$j]->prenom.'</p>
                                    <p>Email: '.$bdd->compteref[$j]->email.'</p>
                                    <p>Date de naissance: '.$bdd->compteref[$j]->datenaissance.'</p>
                                    <p>Réseau social: '.$bdd->compteref[$j]->reseau.'</p>
                                    <p>Présentation: '.$bdd->compteref[$j]->presentation.'</p>
                                    <p>Durée: '.$bdd->compteref[$j]->duree.'</p>
                                </div>
                                ';
                                // commentaire du referent sur le jeune et cases a cocher
                                for ($k = 0; $k < $taillecommentaire ; $k++) {
                                    // cases a cocher
                                    if ($bdd->comptejeune[$idjeune]->savoiretreref[$k]->de == $bdd->compteref[$j]->id) {
                                        echo '<div class="petite-case">


                                            <div class="savoirs-referent">
                                                SES SAVOIRS ETRE
                                            </div>
                                            
                                            <div class="jeconfirme">
                                                Je confirme sa(son)*
                                            </div>
                                            <div class="coche-referent-consultant">';
                                                if (in_array("confiance", $bdd->comptejeune[$idjeune]->savoiretreref[$k]->savoiretre))
                                                echo '<input type="checkbox" name="savoiretreref[]" id="confiance" value="confiance" class="case-coche-consultant" checked="checked" disabled><label for="confiance">Confiance</label><br>';
                                                if (in_array("bienveillance", $bdd->comptejeune[$idjeune]->savoiretreref[$k]->savoiretre))
                                                echo '<input type="checkbox" name="savoiretreref[]" id="bienveillance" value="bienveillance" class="case-coche-consultant" checked="checked" disabled><label for="bienveillance">Bienveillance</label><br>';
                                                if (in_array("respect", $bdd->comptejeune[$idjeune]->savoiretreref[$k]->savoiretre))
                                                echo '<input type="checkbox" name="savoiretreref[]" id="respect" value="respect" class="case-coche-consultant" checked="checked" disabled><label for="respect">Respect</label><br>';
                                                if (in_array("honnetete", $bdd->comptejeune[$idjeune]->savoiretreref[$k]->savoiretre))                                    
                                                echo '<input type="checkbox" name="savoiretreref[]" id="honnetete" value="honnetete" class="case-coche-consultant" checked="checked" disabled><label for="honnetete">Honneteté</label><br>';
                                                if (in_array("tolerance", $bdd->comptejeune[$idjeune]->savoiretreref[$k]->savoiretre))
                                                echo '<input type="checkbox" name="savoiretreref[]" id="tolerance" value="tolerance" class="case-coche-consultant" checked="checked"disabled ><label for="tolerance">Tolérance</label><br>';
                                                if (in_array("juste", $bdd->comptejeune[$idjeune]->savoiretreref[$k]->savoiretre))
                                                echo '<input type="checkbox" name="savoiretreref[]" id="juste" value="juste" class="case-coche-consultant" checked="checked" disabled><label for="juste">Juste</label><br>';
                                                if (in_array("impartial", $bdd->comptejeune[$idjeune]->savoiretreref[$k]->savoiretre))
                                                echo '<input type="checkbox" name="savoiretreref[]" id="impartial" value="impartial" class="case-coche-consultant" checked="checked" disabled><label for="impartial">Impartial</label><br>';
                                                if (in_array("travail", $bdd->comptejeune[$idjeune]->savoiretreref[$k]->savoiretre))
                                                echo '<input type="checkbox" name="savoiretreref[]" id="travail" value="travail" class="case-coche-consultant" checked="checked" disabled><label for="travail">Travail</label><br>';
                                            echo '</div>';
                                        echo '</div>';
                                    }
                                    // commentaire
                                    
                                    if ($bdd->comptejeune[$idjeune]->commentaire[$k]->de == $bdd->compteref[$j]->id) {
                                        echo '<div class="commentaire-consultant">';
                                        echo '<div class="titrecommentaire"> Commentaire du référent</div>';
                                        echo '<div class="textecommentaire">' . $bdd->comptejeune[$idjeune]->commentaire[$k]->texte.'</div></div>
                                        ';
                                        
                                    }
                                }
                            echo '</div>';

                            break;
                            
                        }

                    }
                }

                // lien de validation
                echo '<div class="lienconsultant">';
                echo '<a href="/php/confirmationconsultant.php" class="valider-consultant">Je confirme la demande</a>';
                echo '<a href="/php/refusconsultant.php" class="refuser-consultant">Je refuse la demande</a>';
                echo '</div>';
            }
        }


    ?>


</body>
</html>

