<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>referent</title>
    <link href="referent.css" rel="stylesheet">
</head>
<body>
<br><br>
    <div class="textereferent">
    Confirmez cette expérience et ce que vous avez
    </div>
    <div class="textereferent2">
    pu constater au contact de ce jeune.
    </div>


    <br><br><br>


    <div class="boxreferent" >
    <div class="referent">
    NOM:<br>
     PRENOM:<br>
     DATE DE NAISSANCE:<br>
     Mail:<br>
     Réseau social:<br><br>
     PRESENTATION:<br>
     DUREE:<br>
        </div>
    </div>




        <div class="boxdroite-referent">


      <div class="messavoirs-referent">
        <b>SES SAVOIRS ETRE</b>
      </div>

      <div class="boxconfirme-referent">
          <b>Je confirme sa(son)*</b>
      </div>


      <form>
      <div class="coche-referent">
        <input type="checkbox" id="Confiance" class="case-coche"><label for="Confiance">Confiance</label><br>
        <input type="checkbox" id="Bienveillance" class="case-coche"><label for="Bienveillance">Bienveillance</label><br>
        <input type="checkbox" id="Respect" class="case-coche"><label for="Respect">Respect</label><br>
        <input type="checkbox" id="Honnêteté" class="case-coche"><label for="Honnêteté">Honnêteté</label><br>
        <input type="checkbox" id="Tolérance" class="case-coche"><label for="Tolérance">Tolérance</label><br>
        <input type="checkbox" id="Juste" class="case-coche"><label for="Juste">Juste</label><br>
        <input type="checkbox" id="Impartial" class="case-coche"><label for="Impartial">Impartial</label><br>
        <input type="checkbox" id="Travail" class="case-coche"><label for="Travail">Travail</label><br>
      </div>

      <div class="choix">
          *faire 4 choix maximum
        </div>

      <button type="button" onclick="validerFormulaire()" class="valider" >Valider</button>
      
        </form>
    </div>



    <div class="boxgauche-referent">

    <div class="boxcommentaire-referent">
        COMMENTAIRES
    </div>

    <div class="commentaire-referent">
      <i>Martin s'est très <br>rapidement intégré à <br>notre équipe !</i>
    </div>


    </div>
</body>
</html>