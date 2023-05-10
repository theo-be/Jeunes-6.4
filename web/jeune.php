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
    <title>Document</title>
</head>
<body>


    <a href="../php/deconnexion.php">Deconnexion</a>


    <?php 
        if ($_SESSION["statut_client"] == "visiteur") {
            echo "Vous devez vous inscrire ou vous connecter";
            echo '
            <form action="../php/inscription.php" method="post">
                nom* <input type="text" name="nom" id="nom" required="required">
                prenom* <input type="text" name="prenom" id="prenom" required="required">
                datenaissance* <input type="text" name="datenaissance" id="datenaissance" required="required">
                email* <input type="text" name="email" id="email" required="required">
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
            ';
        } elseif ($_SESSION["statut_client"] == "jeune") {
            echo "Ajouter une demande de referencement : ";
            echo "Informations du référent";
            echo '
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
            ';
        }
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

</body>
</html>