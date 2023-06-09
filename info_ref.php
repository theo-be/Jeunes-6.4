<!DOCTYPE html>
<html>
    <body>
        <?php
        if($_REQUEST["REQUEST_METHOD"] == "POST"){
            $nom = $POST["nomref"];
            $prenom = $POST["prenomref"];
            $mail = $POST["mailref"];
            echo '<div class="box">';
            echo '<p> Nom: $nom </p>';
            echo '<p> Prénom: $prenom </p>';
            echo '<p> Mail: $mail <p/>';
            echo '</div>';
        }
        ?>
        <form method="POST" action='$_SERVER["PHP_SELF"]'>
            <div class=box>
                <label for="nom">Nom:</label>
                <input type="text" id="nom" class="nom" required>
                <label for="prenom">Prénom:</label>
                <input type="text" id="prenom" class="prenom" required>
                <label for="mail">Mail:</label>
                <input type="mail" id="mail" class="mail" required>
                <button type="submit">Envoyer</button>
            </div>
        </form>
    </body>
</html>
