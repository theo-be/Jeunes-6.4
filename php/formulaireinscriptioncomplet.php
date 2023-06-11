
<div class="textejeune">
    Décrivez votre expérience et mettez en avant ce que vous en avez retiré.
</div>


<?php

// formulaire complet d'inscription du jeune

if (!isset($_SESSION)) session_start();

echo '
<form action="/php/inscriptionjeune.php" method="post">
    <div class="boxjeune" >
        <div class="Jeune">
            <label for="nom">Nom</label>* <input type="text" name="nom" id="nom" required="required" value="'.$_SESSION["nom"].'"><br>
            <label for="prenom">Prénom</label>* <input type="text" name="prenom" id="prenom" required="required" value="'.$_SESSION["prenom"].'"><br>
            <label for="datenaissance">Date de naissance</label>* <input type="text" name="datenaissance" id="datenaissance" required="required" value="'.$_SESSION["datenaissance"].'"><br>
            <label for="email">Email</label>* <input type="text" name="email" id="email" required="required" value="'.$_SESSION["email"].'"><br>
            <label for="emailconsultant">Email du consultant</label>* <input type="text" name="emailconsultant" id="emailconsultant" required="required" value="'.$_SESSION["emailconsultant"].'"><br>
            <label for="reseau">Réseau</label>* <input type="text" name="reseau" id="reseau" required="required" value="'.$_SESSION["reseau"].'"><br>
            <label for="engagement">Engagement</label>* <input type="text" name="engagement" id="engagement" required="required" value="'.$_SESSION["engagement"].'"><br>
            <label for="duree">Durée</label>* <input type="text" name="duree" id="duree" required="required" value="'.$_SESSION["duree"].'"><br>
        </div>
    </div>
    <div class="boxdroite-jeune">
        <div class="messavoirs-jeune">
        <b>MES SAVOIRS ETRE</b>
        </div>
        <div class="boxconfirme-jeune">
            <b>Je suis*</b>
        </div>
        <div class="coche-jeune">
            <label for="autonome">Autonome</label><input type="checkbox" name="savoiretre[]" class="case-coche" id="autonome" value="autonome"' . (in_array("autonome", $_SESSION["savoiretre"]) ? 'checked="checked"' : '') . ' onclick="limitCheckboxSelection()">
            <label for="passionne">Passionné</label><input type="checkbox" name="savoiretre[]" class="case-coche" id="passionne" value="passionne"' . (in_array("passionne", $_SESSION["savoiretre"]) ? 'checked="checked"' : '') . ' onclick="limitCheckboxSelection()">
            <label for="reflechi">Réfléchi</label><input type="checkbox" name="savoiretre[]" class="case-coche" id="reflechi" value="reflechi"' . (in_array("reflechi", $_SESSION["savoiretre"]) ? 'checked="checked"' : '') . ' onclick="limitCheckboxSelection()">
            <label for="alecoute">A l\'écoute</label><input type="checkbox" name="savoiretre[]" class="case-coche" id="alecoute" value="alecoute"' . (in_array("alecoute", $_SESSION["savoiretre"]) ? 'checked="checked"' : '') . ' onclick="limitCheckboxSelection()">
            <label for="organise">Organisé</label><input type="checkbox" name="savoiretre[]" class="case-coche" id="organise" value="organise"' . (in_array("organise", $_SESSION["savoiretre"]) ? 'checked="checked"' : '') . ' onclick="limitCheckboxSelection()">
            <label for="fiable">Fiable</label><input type="checkbox" name="savoiretre[]" class="case-coche" id="fiable" value="fiable"' . (in_array("fiable", $_SESSION["savoiretre"]) ? 'checked="checked"' : '') . ' onclick="limitCheckboxSelection()">
            <label for="patient">Patient</label><input type="checkbox" name="savoiretre[]" class="case-coche" id="patient" value="patient"' . (in_array("confiance", $_SESSION["savoiretre"]) ? 'checked="checked"' : '') . ' onclick="limitCheckboxSelection()">
            <label for="responsable">Responsable</label><input type="checkbox" name="savoiretre[]" class="case-coche" id="responsable" value="responsable"' . (in_array("responsable", $_SESSION["savoiretre"]) ? 'checked="checked"' : '') . ' onclick="limitCheckboxSelection()">
            <label for="sociable">Sociable</label><input type="checkbox" name="savoiretre[]" class="case-coche" id="sociable" value="sociable"' . (in_array("sociable", $_SESSION["savoiretre"]) ? 'checked="checked"' : '') . ' onclick="limitCheckboxSelection()">
            <label for="optimiste">Optimiste</label><input type="checkbox" name="savoiretre[]" class="case-coche" id="optimiste" value="optimiste"' . (in_array("optimiste", $_SESSION["savoiretre"]) ? 'checked="checked"' : '') . ' onclick="limitCheckboxSelection()">
        </div>
        <div class="choix">
            *Faire 4 choix maximum
        </div>
        <input type="submit" class="valider" value="Valider">
    </div>
</form>
';


?>
