<?php 
    session_start();
    require_once "../php/verifsession.php";
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeune</title>
</head>
<body>


    <?php

        $contenufichier = file_get_contents("../data/bdd.json");
        $bdd = json_decode($contenufichier, false);
            
        if ($_SESSION["statut_client"] == "visiteur") {
            echo "Vous devez vous inscrire ou vous connecter";
            echo '
            <form action="../php/inscription.php" method="post" id="inscription">
                nom<input type="text" name="nom" id="nom" required="required">
                prenom<input type="text" name="prenom" id="prenom" required="required">
                date de naissance<input type="text" name="datenaissance" id="datenaissance" required="required">
                email<input type="text" name="email" id="email" required="required">
                mdp<input type="password" name="mdp" id="mdp" required="required">
                mdpc<input type="password" name="mdpc" id="mdpc" required="required">
                <input type="submit" value="Envoyer">
            </form>
            ';
            echo '
            <form action="../php/connexion.php" method="post" id="connexion">
                email<input type="text" name="email" id="email" required="required">
                mdp<input type="password" name="mdp" id="mdp" required="required">
                <input type="submit" value="Envoyer">
            </form>
            ';
            echo '
    <button id="conn">Connexion</button>
            ';
        } elseif ($_SESSION["statut_client"] == "jeune") {
            echo '
    <a href="../php/deconnexion.php">Deconnexion</a>
            ';
            if (!$_SESSION["comptecomplet"]) {
                // compte incomplet
                echo "<p>Votre compte n'est pas complet, noua avons besoin d'informations supplémentaires:</p>";
                require "../php/formulaireinscriptioncomplet.php";

            } else {
                // compte complet

                // bouton modifier son compte
                echo '
    <button id="modifiercompte">Modifier les informations de mon compte</button>
                ';

                // afficher la liste des referents

                for ($i = 0; $i < count($bdd->comptejeune[$_SESSION["idcompte"]]->idref); $i++) {
                    $referent = $bdd->compteref[$bdd->comptejeune[$_SESSION["idcompte"]]->idref[$i]];
                    echo 
                    '
    <div>
        <p>referent</p>
        <span>'.$referent->prenom.'</span> <span>'.$referent->nom.'</span> <span class="emailref">'.$referent->email.'</span>
        <button class="modifierref">Modifier les informations du référent</button>
    </div>
                    ';
                }





                echo '
    <button id="ajouterreferent">Ajouter une demande de référencement</button>
                ';



                // demande de ref
                // require "../php/formulaireinscriptionreferent.php";
            }
        }

        echo '<p>';
        echo "erreur : " . $_SESSION["erreur"];
        echo "message : " . $_SESSION["messageerreur"];
        echo '</p>';


    ?>

<!-- 
            <form action="../php/inscription.php" method="post">
                <p>Demande de référencement</p>
                reseau <input type="text" name="reseau" id="reseau">
                engagement <input type="text" name="engagement" id="engagement">
                duree <input type="text" name="duree" id="duree">
                <p>Mes savoirs être</p>
                autonome<input type="checkbox" name="savoiretre[]" id="autonome" value="autonome">
                passionne<input type="checkbox" name="savoiretre[]" id="passionne" value="passionne">
                reflechi<input type="checkbox" name="savoiretre[]" id="reflechi" value="reflechi">
                alecoute<input type="checkbox" name="savoiretre[]" id="alecoute" value="alecoute">
                organise<input type="checkbox" name="savoiretre[]" id="organise" value="organise">
                fiable<input type="checkbox" name="savoiretre[]" id="fiable" value="fiable">
                patient<input type="checkbox" name="savoiretre[]" id="patient" value="patient">
                responsable<input type="checkbox" name="savoiretre[]" id="responsable" value="responsable">
                sociable<input type="checkbox" name="savoiretre[]" id="sociable" value="sociable">
                optimiste<input type="checkbox" name="savoiretre[]" id="optimiste" value="optimiste">
                <input type="submit" value="Envoyer">
            </form>
 -->


        



<!-- formulaire demande de referencement

    <form action="../php/inscription.php" method="post">
        nom <input type="text" name="nom" id="nom">
        prenom <input type="text" name="prenom" id="prenom">
        email <input type="text" name="email" id="email">
        datenaissance <input type="text" name="datenaissance" id="datenaissance">
        reseau <input type="text" name="reseau" id="reseau">
        presentation <input type="text" name="presentation" id="presentation">
        duree <input type="text" name="duree" id="duree">
        <p>Mes savoirs être</p>
        confiance<input type="checkbox" name="savoiretre" id="confiance" value="confiance">
        bienveillance<input type="checkbox" name="savoiretre" id="bienveillance" value="bienveillance">
        respect<input type="checkbox" name="savoiretre" id="respect" value="respect">
        honnetete<input type="checkbox" name="savoiretre" id="honnetete" value="honnetete">
        tolerance<input type="checkbox" name="savoiretre" id="tolerance" value="tolerance">
        juste<input type="checkbox" name="savoiretre" id="juste" value="juste">
        impartial<input type="checkbox" name="savoiretre" id="impartial" value="impartial">
        travail<input type="checkbox" name="savoiretre" id="travail" value="travail">
        <input type="submit" value="Envoyer">
    </form>
 -->

        <script src="../js/jeune.js"></script>

</body>
</html>