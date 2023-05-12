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
    if ($_SESSION["statut_client"] == "jeune")
        echo '<a href="../php/deconnexion.php">Deconnexion</a>';
    ?>


    <?php 
        if ($_SESSION["statut_client"] == "visiteur") {
            echo "Vous devez vous inscrire ou vous connecter";
            echo '
            <form action="../php/inscription.php" method="post" id="inscription">
                nom* <input type="text" name="nom" id="nom" required="required">
                prenom* <input type="text" name="prenom" id="prenom" required="required">
                date de naissance* <input type="text" name="datenaissance" id="datenaissance" required="required">
                email* <input type="text" name="email" id="email" required="required">
                <input type="submit" value="Envoyer">
            </form>
            ';
            echo '
            <form action="../php/connexion.php" method="post" id="connexion">
                email* <input type="text" name="email" id="email" required="required">
                <input type="submit" value="Envoyer">
            </form>
            ';
            echo '
            <button id="conn">Connexion</button>
            ';






/*
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

*/

        } elseif ($_SESSION["statut_client"] == "jeune") {
            echo "<p>Ajouter une demande de referencement :</p>";
            echo "<p>Informations supplémentaires:</p>";
            echo '
            <form action="../php/inscriptionreferent.php" method="post">
                nom* <input type="text" name="nom" id="nom" required="required" value="'.$_SESSION["nom"].'">
                prenom* <input type="text" name="prenom" id="prenom" required="required" value="'.$_SESSION["prenom"].'">
                date de naissance* <input type="text" name="datenaissance" id="datenaissance" required="required" value="'.$_SESSION["datenaissance"].'">
                email* <input type="text" name="email" id="email" required="required" value="'.$_SESSION["email"].'">
                reseau* <input type="text" name="reseau" id="reseau">
                engagement* <input type="text" name="engagement" id="engagement">
                duree* <input type="text" name="duree" id="duree">
                <p>Mes savoirs être*</p>
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
            ';
            echo "<p>Informations du référent</p>";
            echo '
                nom* <input type="text" name="nomref" id="nomref">
                prenom* <input type="text" name="prenomref" id="prenomref">
                email* <input type="text" name="emailref" id="emailref">
                datenaissance* <input type="text" name="datenaissanceref" id="datenaissanceref">
                reseau* <input type="text" name="reseauref" id="reseauref">
                presentation* <input type="text" name="presentationref" id="presentationref">
                duree* <input type="text" name="dureeref" id="dureeref">
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





        echo "erreur : " . $_SESSION["erreur"];
        echo "message : " . $_SESSION["messageerreur"];



    ?>


        



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

        <script type="text/javascript">
            document.getElementById("connexion").style.display = "none";
            var bouton = document.getElementById("conn");
            bouton.addEventListener("click", function () {
                document.getElementById("connexion").style.display = "block";
                document.getElementById("inscription").style.display = "none";
            });
        </script>

</body>
</html>