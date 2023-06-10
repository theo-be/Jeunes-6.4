

<?php 
    session_start();
    require_once "../php/verifsession.php";
    require_once "../php/cherchecompte.php";
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/css/header.css" >
    <title>Jeune</title>
</head>
<body>


    <?php

        require "../php/header.php";

        $contenufichier = file_get_contents("../data/bdd.json");
        $bdd = json_decode($contenufichier, false);
            
        if ($_SESSION["statut_client"] == "visiteur") {
            echo "Vous devez vous inscrire ou vous connecter";
            echo '
            <form action="/php/inscription.php" method="post" id="inscription">
                nom<input type="text" name="nom" id="nom" required="required">
                prenom<input type="text" name="prenom" id="prenom" required="required">
                date de naissance<input type="text" name="datenaissance" id="datenaissance" required="required">
                email<input type="text" name="email" id="email" required="required">
                mdp<input type="password" name="mdp" id="mdp" required="required">
                mdpconfirm<input type="password" name="mdpc" id="mdpc" required="required">
                <input type="submit" value="Envoyer">
            </form>
            ';
            echo '
            <form action="/php/connexion.php" method="post" id="connexion">
                email<input type="text" name="email" id="email" required="required">
                mdp<input type="password" name="mdp" id="mdp" required="required">
                <input type="submit" value="Envoyer">
            </form>
            ';
            echo '
                <button id="conn">Connexion</button>
            ';

            // message d'erreur pour les formulaires
            echo '<p>';
            echo $_SESSION["messageerreur"];
            echo '</p>';

        } elseif ($_SESSION["statut_client"] == "jeune") {
            
            $indexjeune = chercheCompteJeuneParId($bdd, $_SESSION["idcompte"]);
            echo '
                <a href="/php/deconnexion.php">Deconnexion</a>
            ';
            if (!$_SESSION["comptecomplet"]) {
                // compte incomplet
                echo "<p>Votre compte n'est pas complet, noua avons besoin d'informations supplémentaires:</p>";
                require "../php/formulaireinscriptioncomplet.php";
                
                // message d'erreur pour les formulaires
                echo '<p>';
                echo $_SESSION["messageerreur"];
                echo '</p>';

            } else {
                // compte complet

                // bouton modifier son compte
                echo '
                <button id="modifiercompte">Modifier les informations de mon compte</button>
                ';

                // affichage de l'etat de la demande pour le consultant
                echo '
                <div>Statut de la demande : '.($bdd->comptejeune[$indexjeune]->messagestatutdemandeconsultant).'</div>
                ';


                // afficher la liste des referents

                for ($i = 0; $i < count($bdd->comptejeune[$indexjeune]->idref); $i++) {
                    $referent = $bdd->compteref[$bdd->comptejeune[$indexjeune]->idref[$i]];
                    echo 
                    '
                    <div>
                        <p>referent</p>
                        <span>'.$referent->prenom.'</span> <span>'.$referent->nom.'</span> <span>'.$referent->email.'</span>
                        <span>Statut de la demande de référencement : '.$bdd->comptejeune[$indexjeune]->statutdemande[$i].'</span>';

                        // si le référent a accepté ou refusé la demande, on ne peut plus le modifier
                        if ($bdd->comptejeune[$indexjeune]->statutdemande[$i] != "Demande validée par le référent"
                         && $bdd->comptejeune[$indexjeune]->statutdemande[$i] != "Demande refusée par le référent")
                        echo '<button class="modifierref" id="' . $referent->email . '">Modifier les informations du référent</button>';
                    echo '</div>
                    ';
                }

                if ($bdd->comptejeune[$indexjeune]->statutdemandeconsultant == 0 || $bdd->comptejeune[$indexjeune]->statutdemandeconsultant == 3) {
                    echo '
                    <button id="ajouterreferent">Ajouter une demande de référencement</button>
                    ';
                    echo '
                    <a href="/php/demandeconsultation.php" id="envoyerconsultant">Envoyer la demande au consultant</a>
                    ';
                }

                // echo "<p>Ajouter une demande de referencement :</p>";
                // echo "<p>Informations du référent</p>";

                // demande de ref
                // require "../php/formulaireinscriptionreferent.php";
            }
        }


    ?>
    
    <script src="/js/jeune.js"></script>

</body>
</html>

<?php
/*

            <form action="/php/inscription.php" method="post">
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



        



formulaire demande de referencement

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

*/

?>



<!-- 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="/css/jeune.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/header.css" >
</head>
<body>
 
  
    <?php require "../php/header.php"; ?>
      
      <br><br>
    <div class="textejeune">
      Décrivez votre expérience et mettez en avant ce que vous en avez retiré.
    </div>
  <br><br><br><br>
    <div class="boxjeune" >
    <div class="Jeune">
    NOM:..............................................................................<br>
     PRENOM:...............................................................<br>
     DATE DE NAISSANCE:....................................................<br>
     Mail:.................................................................<br>
     Réseau social:........................................................<br><br>
     MON ENGAGEMENT:.......................................................<br>
     DUREE:................................................................<br>
        </div>
     
    
    </div>
    <div class="boxradio-jeune">
      <div class="messavoirs-jeune">
        <b>Mes savoirs être</b>
      </div>
      <div class="boxdroite-jeune">
          <b>Je suis*</b>
      </div>
      <form>
      <div class="coche-jeune">
        <input type="checkbox" id="Autonome" class="case-coche"><label for="item1">Autonome</label><br>
        <input type="checkbox" id="Passionné" class="case-coche"><label for="item1">Passionné</label><br>
        <input type="checkbox" id="Réfléchi" class="case-coche"><label for="item1">Réfléchi</label><br>
        <input type="checkbox" id="A l'écoute" class="case-coche"><label for="item1">A l'écoute</label><br>
        <input type="checkbox" id="Organisé" class="case-coche"><label for="item1">Organisé</label><br>
        <input type="checkbox" id="Fiable" class="case-coche"><label for="item1">Fiable</label><br>
        <input type="checkbox" id="Patient" class="case-coche"><label for="item1">Patient</label><br>
        <input type="checkbox" id="Responsable" class="case-coche"><label for="item1">Responsable</label><br>
        <input type="checkbox" id="Sociable" class="case-coche"><label for="item1">Sociable</label><br>
        <input type="checkbox" id="Optimiste" class="case-coche"><label for="item1">Optimiste</label><br>
      </div>

      <div class="choix">
          *faire 4 choix maximum
        </div>
      <button type="button" onclick="validerFormulaire()" class="valider" >Valider</button>
      
        </form>
    </div>

  
</body>
</html> -->