<?php

// formulaire complet d'inscription du jeune

if (!isset($_SESSION)) session_start();

echo '
<form action="/php/inscriptionjeune.php" method="post">
    nom* <input type="text" name="nom" id="nom" required="required" value="'.$_SESSION["nom"].'">
    prenom* <input type="text" name="prenom" id="prenom" required="required" value="'.$_SESSION["prenom"].'">
    date de naissance* <input type="text" name="datenaissance" id="datenaissance" required="required" value="'.$_SESSION["datenaissance"].'">
    email* <input type="text" name="email" id="email" required="required" value="'.$_SESSION["email"].'">
    emailconsultant* <input type="text" name="emailconsultant" id="emailconsultant" required="required" value="'.$_SESSION["emailconsultant"].'">
    reseau* <input type="text" name="reseau" id="reseau" required="required" value="'.$_SESSION["reseau"].'">
    engagement* <input type="text" name="engagement" id="engagement" required="required" value="'.$_SESSION["engagement"].'">
    duree* <input type="text" name="duree" id="duree" required="required" value="'.$_SESSION["duree"].'">
    <p>Mes savoirs être*</p>
    autonome<input type="checkbox" name="savoiretre[]" id="autonome" value="autonome"' . (in_array("autonome", $_SESSION["savoiretre"]) ? 'checked="checked"' : '') . '>
    passionne<input type="checkbox" name="savoiretre[]" id="passionne" value="passionne"' . (in_array("passionne", $_SESSION["savoiretre"]) ? 'checked="checked"' : '') . '>
    reflechi<input type="checkbox" name="savoiretre[]" id="reflechi" value="reflechi"' . (in_array("reflechi", $_SESSION["savoiretre"]) ? 'checked="checked"' : '') . '>
    alecoute<input type="checkbox" name="savoiretre[]" id="alecoute" value="alecoute"' . (in_array("alecoute", $_SESSION["savoiretre"]) ? 'checked="checked"' : '') . '>
    organise<input type="checkbox" name="savoiretre[]" id="organise" value="organise"' . (in_array("organise", $_SESSION["savoiretre"]) ? 'checked="checked"' : '') . '>
    fiable<input type="checkbox" name="savoiretre[]" id="fiable" value="fiable"' . (in_array("fiable", $_SESSION["savoiretre"]) ? 'checked="checked"' : '') . '>
    patient<input type="checkbox" name="savoiretre[]" id="patient" value="patient"' . (in_array("confiance", $_SESSION["savoiretre"]) ? 'checked="checked"' : '') . '>
    responsable<input type="checkbox" name="savoiretre[]" id="responsable" value="responsable"' . (in_array("responsable", $_SESSION["savoiretre"]) ? 'checked="checked"' : '') . '>
    sociable<input type="checkbox" name="savoiretre[]" id="sociable" value="sociable"' . (in_array("sociable", $_SESSION["savoiretre"]) ? 'checked="checked"' : '') . '>
    optimiste<input type="checkbox" name="savoiretre[]" id="optimiste" value="optimiste"' . (in_array("optimiste", $_SESSION["savoiretre"]) ? 'checked="checked"' : '') . '>
    <input type="submit" value="Envoyer">
</form>
';


?>



