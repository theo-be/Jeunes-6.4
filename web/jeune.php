<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>jeune</title>
    <link href="/css/jeune.css" rel="stylesheet">
    
    <title> limitCoche</title>
<script>
     function limitCheckboxSelection() {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
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

      
    <div class="textejeune">
      Décrivez votre expérience et mettez en avant ce que vous en avez retiré.
    </div>


  <br><br><br><br>


    <div class="boxjeune" >
    <div class="Jeune">
    NOM:<br>
     PRENOM:<br>
     DATE DE NAISSANCE:<br>
     Mail:<br>
     Réseau social:<br><br>
     MON ENGAGEMENT:<br>
     DUREE:<br>
</div>
    </div>

    <div class="boxdroite-jeune">


      <div class="messavoirs-jeune">
        <b>MES SAVOIRS ETRE</b>
      </div>

      <div class="boxconfirme-jeune">
          <b>Je suis*</b>
      </div>


      <form>
      <div class="coche-jeune">
        <input type="checkbox" id="Autonome" class="case-coche" onchange="limitCheckboxSelection()"><label for="Autonome">Autonome</label><br>
        <input type="checkbox" id="Passionné" class="case-coche" onchange="limitCheckboxSelection()"><label for="Passionné">Passionné</label><br>
        <input type="checkbox" id="Réfléchi" class="case-coche" onchange="limitCheckboxSelection()"><label for="Réfléchi">Réfléchi</label><br>
        <input type="checkbox" id="A l'écoute" class="case-coche" onchange="limitCheckboxSelection()"><label for="A l'écoute">A l'écoute</label><br>
        <input type="checkbox" id="Organisé" class="case-coche" onchange="limitCheckboxSelection()"><label for="Organisé">Organisé</label><br>
        <input type="checkbox" id="Fiable" class="case-coche" onchange="limitCheckboxSelection()"><label for="Fiable">Fiable</label><br>
        <input type="checkbox" id="Patient" class="case-coche" onchange="limitCheckboxSelection()"><label for="Patient">Patient</label><br>
        <input type="checkbox" id="Responsable" class="case-coche" onchange="limitCheckboxSelection()"><label for="Responsable">Responsable</label><br>
        <input type="checkbox" id="Sociable" class="case-coche" onchange="limitCheckboxSelection()"><label for="Sociable">Sociable</label><br>
        <input type="checkbox" id="Optimiste" class="case-coche" onchange="limitCheckboxSelection()"><label for="Optimiste">Optimiste</label><br>
      </div>

      <div class="choix">
          *faire 4 choix maximum
        </div>

      <button type="button" onclick="validerFormulaire()" class="valider" >Valider</button>
      
        </form>

    </div>
    
  
</body>
</html>