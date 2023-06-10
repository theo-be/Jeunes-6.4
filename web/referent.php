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
            // proposer à l'utilisateur de rentrer son jeton ici
            // permet également aux autres utilisateurs de comprendre que cette page ne leur est pas destinée
            echo "ERREUR : pas de token";
        } else {            

            $contenutoken = file_get_contents("../data/token.json");
            $token = json_decode($contenutoken, false);
            $nbtokens = count($token->token);
            
            $contenufichier = file_get_contents("../data/bdd.json");
            $bdd = json_decode($contenufichier, false);

            $idref = 0;
            $idjeune = 0;

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
                echo '<a href="/php/deconnexion.php">Deconnexion</a>';
                $_SESSION["statut_client"] = "referent";
                $_SESSION["idcompte"] = $idref;
                $compte = $bdd->compteref[$idref];
            
                // affichage des infos du referent                

                // echo '
                // <form action="/php/confirmationreferencement.php" method="post">
                //     nom* <input type="text" name="nomref" id="nomref" required="required" value="'.$compte->nom.'">
                //     prenom* <input type="text" name="prenomref" id="prenomref" required="required" value="'.$compte->prenom.'">
                //     email* <input type="text" name="emailref" id="emailref" required="required" value="'.$compte->email.'">
                //     datenaissance* <input type="text" name="datenaissanceref" id="datenaissanceref" required="required" value="'.$compte->datenaissance.'">
                //     reseau* <input type="text" name="reseauref" id="reseauref" required="required" value="'.$compte->reseau.'">
                //     presentation* <input type="text" name="presentationref" id="presentationref" required="required" value="'.$compte->presentation.'">
                //     duree* <input type="text" name="dureeref" id="dureeref" required="required" value="'.$compte->duree.'">
                //     <p>Mes savoirs être*</p>
                //     confiance<input type="checkbox" name="savoiretreref[]" id="confiance" value="confiance"' . (in_array("confiance", $compte->savoiretre) ? 'checked="checked"' : '') . '>
                //     bienveillance<input type="checkbox" name="savoiretreref[]" id="bienveillance" value="bienveillance"' . (in_array("bienveillance", $compte->savoiretre) ? 'checked="checked"' : '') . '>
                //     respect<input type="checkbox" name="savoiretreref[]" id="respect" value="respect"' . (in_array("respect", $compte->savoiretre) ? 'checked="checked"' : '') . '>
                //     honnetete<input type="checkbox" name="savoiretreref[]" id="honnetete" value="honnetete"' . (in_array("honnetete", $compte->savoiretre) ? 'checked="checked"' : '') . '>
                //     tolerance<input type="checkbox" name="savoiretreref[]" id="tolerance" value="tolerance"' . (in_array("tolerance", $compte->savoiretre) ? 'checked="checked"' : '') . '>
                //     juste<input type="checkbox" name="savoiretreref[]" id="juste" value="juste"' . (in_array("juste", $compte->savoiretre) ? 'checked="checked"' : '') . '>
                //     impartial<input type="checkbox" name="savoiretreref[]" id="impartial" value="impartial"' . (in_array("impartial", $compte->savoiretre) ? 'checked="checked"' : '') . '>
                //     travail<input type="checkbox" name="savoiretreref[]" id="travail" value="travail"' . (in_array("travail", $compte->savoiretre) ? 'checked="checked"' : '') . '><br>
                //     commentaire<textarea name="commentaire" id="commentaire" cols="30" rows="10"></textarea>
                // ';

                echo '
                <form action="/php/confirmationreferencement.php" method="post">
                    nom* <input type="text" name="nomref" id="nomref" required="required" value="'.$compte->nom.'">
                    prenom* <input type="text" name="prenomref" id="prenomref" required="required" value="'.$compte->prenom.'">
                    email* <input type="text" name="emailref" id="emailref" required="required" value="'.$compte->email.'">
                    datenaissance* <input type="text" name="datenaissanceref" id="datenaissanceref" required="required" value="'.$compte->datenaissance.'">
                    reseau* <input type="text" name="reseauref" id="reseauref" required="required" value="'.$compte->reseau.'">
                    presentation* <input type="text" name="presentationref" id="presentationref" required="required" value="'.$compte->presentation.'">
                    duree* <input type="text" name="dureeref" id="dureeref" required="required" value="'.$compte->duree.'">';

                    echo '
                    <p>Ses savoirs être*</p>
                    confiance<input type="checkbox" name="savoiretreref[]" id="confiance" value="confiance">
                    bienveillance<input type="checkbox" name="savoiretreref[]" id="bienveillance" value="bienveillance">
                    respect<input type="checkbox" name="savoiretreref[]" id="respect" value="respect">
                    honnetete<input type="checkbox" name="savoiretreref[]" id="honnetete" value="honnetete">
                    tolerance<input type="checkbox" name="savoiretreref[]" id="tolerance" value="tolerance">
                    juste<input type="checkbox" name="savoiretreref[]" id="juste" value="juste">
                    impartial<input type="checkbox" name="savoiretreref[]" id="impartial" value="impartial">
                    travail<input type="checkbox" name="savoiretreref[]" id="travail" value="travail">
                    commentaire* : <textarea name="commentaire" id="commentaire" cols="30" rows="10"></textarea>
                ';


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
                echo "</div>";
                // cases a cocher sans attribut name pour eviter qu'ils soient envoyés inutilement au serveur
                echo '
                autonome<input type="checkbox" id="autonome" value="autonome"' . (in_array("autonome", $bdd->comptejeune[$idjeune]->savoiretre) ? 'checked="checked"' : '') . '>
                passionne<input type="checkbox" id="passionne" value="passionne"' . (in_array("passionne", $bdd->comptejeune[$idjeune]->savoiretre) ? 'checked="checked"' : '') . '>
                reflechi<input type="checkbox" id="reflechi" value="reflechi"' . (in_array("reflechi", $bdd->comptejeune[$idjeune]->savoiretre) ? 'checked="checked"' : '') . '>
                alecoute<input type="checkbox" id="alecoute" value="alecoute"' . (in_array("alecoute", $bdd->comptejeune[$idjeune]->savoiretre) ? 'checked="checked"' : '') . '>
                organise<input type="checkbox" id="organise" value="organise"' . (in_array("organise", $bdd->comptejeune[$idjeune]->savoiretre) ? 'checked="checked"' : '') . '>
                fiable<input type="checkbox" id="fiable" value="fiable"' . (in_array("fiable", $bdd->comptejeune[$idjeune]->savoiretre) ? 'checked="checked"' : '') . '>
                patient<input type="checkbox" id="patient" value="patient"' . (in_array("confiance", $bdd->comptejeune[$idjeune]->savoiretre) ? 'checked="checked"' : '') . '>
                responsable<input type="checkbox" id="responsable" value="responsable"' . (in_array("responsable", $bdd->comptejeune[$idjeune]->savoiretre) ? 'checked="checked"' : '') . '>
                sociable<input type="checkbox" id="sociable" value="sociable"' . (in_array("sociable", $bdd->comptejeune[$idjeune]->savoiretre) ? 'checked="checked"' : '') . '>
                optimiste<input type="checkbox" id="optimiste" value="optimiste"' . (in_array("optimiste", $bdd->comptejeune[$idjeune]->savoiretre) ? 'checked="checked"' : '') . '>';
                echo '<input type="submit" value="Confirmer la demande de référencement">';
                echo '<a href="/php/refusreferent.php">Refuser la demande de référencement</a>';
                echo '</form>';
            }
        }


    ?>
</body>
</html>