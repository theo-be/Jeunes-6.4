<?php
session_start();
// recuperation des donnees du formulaire d'inscription

// verification des donnees d'entree
if (!(isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["datenaissance"]) && isset($_POST["email"]) && isset($_POST["reseau"]) && isset($_POST["engagement"]) && isset($_POST["duree"]) && isset($_POST["savoiretre"]))
/*|| $_POST["nom"] == "" || $_POST["prenom"] == "" || $_POST["datenaissance"] == "" || $_POST["email"] == ""*/) {
    // erreur donnees manquantes
    echo "ERREUR : données manquantes\n";
} else {
    $bdd = fopen("../data/bdd.txt", "a+");

    // fprintf($bdd, "%s,%s,%s,%s,%s,%s,%s\n", $_POST["nom"], $_POST["prenom"], $_POST["datenaissance"], $_POST["email"], $_POST["reseau"], $_POST["engagement"], $_POST["duree"]);









    // foreach ($_POST as $key => $elmt) {
    //     echo "$key => $elmt - ";
    // }

    // $se = $_POST["savoiretre"];
    // echo var_dump($se);

    // foreach ($se as $val) {
    //     echo $val;
    // }

    fclose($bdd);

    $_SESSION["statut_client"] = "jeune";
}

header("Location: ../web/jeune.php");
?>