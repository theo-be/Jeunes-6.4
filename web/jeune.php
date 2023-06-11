

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
    <link rel="stylesheet" type="text/css" href="/css/referent.css" >
    <link rel="stylesheet" type="text/css" href="/css/header.css" >
    <link rel="stylesheet" type="text/css" href="/css/jeune.css" >
    <title>Jeune</title>
    <script>
     function limitCheckboxSelection() {
         // script qui limite le nombre de cases cochées à 4
            var checkboxes = document.getElementsByClassName("coche-jeune")[0].querySelectorAll('input[type="checkbox"]');
            var checkedCount = 0;

            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    checkedCount++;
                }
            }

            if (checkedCount >= 4) {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (!checkboxes[i].checked) {
                        checkboxes[i].disabled = true;
                    }
                }
            } else {
                for (var i = 0; i < checkboxes.length; i++) {
                    checkboxes[i].disabled = false;
                }
            }
        }
    </script>
</head>
<body>


    <?php

        require "../php/header.php";



            
        if ($_SESSION["statut_client"] != "jeune") {
            // formulaires d'inscription et de connexion
            echo '<div class="vous-devez">
            Vous devez vous inscrire ou vous connecter
           </div>
            
            <form action="/php/inscription.php" method="post" id="inscription">
            <div class="boxjeune" >
                <div class="Jeune">';
                // message derreur pour les formulaires
                echo '<div>';
                echo $_SESSION["messageerreur"];
                echo '</div>';
                echo '
                    <label for="nom">Nom</label>* <input type="text" name="nom" id="nom" required="required"><br>
                    <label for="prenom">Prénom</label>* <input type="text" name="prenom" id="prenom" required="required"><br>
                    <label for="datenaissance">Date de naissance</label>* <input type="text" name="datenaissance" id="datenaissance" required="required"><br>
                    <label for="email">Email</label>* <input type="text" name="email" id="email" required="required"><br>
                    <label for="mdp">Mot de passe</label>*<input type="password" name="mdp" id="mdp" required="required"><br>
                    <label for="mdpc">Confirmer le mot de passe</label>*<input type="password" name="mdpc" id="mdpc" required="required"><br>
                    <input type="submit" class="sinscrire" value="S\'inscrire">
                    <button id="conn" class="connexion-jeune">Connexion</button>
                </div>';
                
               
            
            echo '
            </div>
            </form>
            ';
            echo '
            <form action="/php/connexion.php" method="post" id="connexion">
                <div class="boxjeune" >
                    <div class="Jeune">';
                        // message derreur pour les formulaires
                        echo '<div>';
                        echo $_SESSION["messageerreur"];
                        echo '</div>';
                        echo '<label for="emailcon">Email</label>* <input type="text" name="email" id="emailcon" required="required"><br>
                        <label for="mdpcon">Mot de passe</label>*<input type="password" name="mdp" id="mdpcon" required="required"><br>
                        <input type="submit" class="sinscrire" value="Se connecter">
                        <button id="insc" class=connexion-jeune>Inscription</button>
                    </div>';
                
            echo '
                </div></form>
            ';

        } elseif ($_SESSION["statut_client"] == "jeune") {
            
            // cahrgement de la base de donees
            $contenufichier = file_get_contents("../data/bdd.json");
            $bdd = json_decode($contenufichier, false);
            
            $indexjeune = chercheCompteJeuneParId($bdd, $_SESSION["idcompte"]);
            echo '
                <a href="/php/deconnexion.php" class="deconnexion">Deconnexion</a>
            ';
            if (!$_SESSION["comptecomplet"]) {
                // compte incomplet
                // echo "<p>Votre compte n'est pas complet, noua avons besoin d'informations supplémentaires:</p>";
                require "../php/formulaireinscriptioncomplet.php";
                
                // message d'erreur pour les formulaires
                echo '<p>';
                echo $_SESSION["messageerreur"];
                echo '</p>';

            } else {
                // compte complet

                // message de bienvenue

                echo '<div class="pageprincipale" id="pageprincipale">';

                echo '<div class="bonjour">Bonjour '.$_SESSION["prenom"].' '. $_SESSION["nom"].'</div>';

                // bouton modifier son compte
                echo '
                <button class="modif" id="modifiercompte">Modifier les informations de mon compte</button>
                <button class="exporpdf" id="pdf">Exporter en pdf</button>
                ';

               echo '<div class="montrerlistereferents">Voici votre liste de référents';
               
               echo '</div>';

                // afficher la liste des referents

                echo '<div class="listereferents">';

                    for ($i = 0; $i < count($bdd->comptejeune[$indexjeune]->idref); $i++) {
                        $referent = $bdd->compteref[$bdd->comptejeune[$indexjeune]->idref[$i]];
                        echo 
                        '
                        <div class="boitereferent">
                            <div><span>'.$referent->prenom.'</span> <span>'.$referent->nom.'</span></div>
                            <div>'.$referent->email.'</div>
                            <div>Statut de la demande de référencement : '.$bdd->comptejeune[$indexjeune]->statutdemande[$i].'</div>
                            <button class="detaildemande" id="' . $referent->email . '">Affichier les détails</button>
                        </div>
                        ';
                    }

                echo '</div>';
                 // affichage de l'etat de la demande pour le consultant
                 echo '
                 <div class="statutdemande">Statut de la demande : '.($bdd->comptejeune[$indexjeune]->messagestatutdemandeconsultant).'</div>
                 ';
 

                if ($bdd->comptejeune[$indexjeune]->statutdemandeconsultant == 0) {
                    echo '
                    <button class="ajoutref" id="ajouterreferent">Ajouter une demande de référencement</button>
                    ';
                    echo '
                    <a href="/php/demandeconsultation.php" class="envoicon" id="envoyerconsultant">Envoyer la demande au consultant</a>
                    ';
                }

                echo '</div>';

                echo '<div id="popup">
                    <button class="fermer" id="fermerpopup">Fermer</button>
                </div>';


            }
        }


    ?>


    
    <script src="/js/jeune.js"></script>

</body>
</html>


