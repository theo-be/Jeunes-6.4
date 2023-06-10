




if (document.getElementById("connexion")) {
    document.getElementById("connexion").style.display = "none";
    var bouton = document.getElementById("conn");
    bouton.addEventListener("click", function () {
        document.getElementById("connexion").style.display = "block";
        document.getElementById("inscription").style.display = "none";
    });
}

if (document.getElementById("modifiercompte")) {
    document.getElementById("modifiercompte").addEventListener("click", function () {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var div = document.createElement("div");
                div.innerHTML = this.responseText;
                document.body.appendChild(div);
                // console.log(this.responseText)
                // document.write(this.responseText);
            }
        }
        xhttp.open("GET", "/php/formulaireinscriptioncomplet.php");
        xhttp.send();
    });
}
if (document.getElementById("ajouterreferent")) {
    document.getElementById("ajouterreferent").addEventListener("click", function () {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var div = document.createElement("div");
                div.innerHTML = "<p>Ajouter une demande de referencement :</p>";
                div.innerHTML += "<p>Informations du référent</p>";
                div.innerHTML += this.responseText;
                document.body.appendChild(div);
                // document.write(this.responseText);
            }
        }
        xhttp.open("GET", "/php/formulaireinscriptionreferent.php");
        xhttp.send();
    });
}


if (document.getElementsByClassName("modifierref")) {
    var boutons = document.getElementsByClassName("modifierref");
    for (var i = 0; i < boutons.length; i++) {
        boutons[i].addEventListener("click", function (e) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    var div = document.createElement("div");
                    div.innerHTML = this.responseText;
                    document.body.appendChild(div);
                    // console.log(this.responseText);
                    // document.write(this.responseText);
                }
            }
            xhttp.open("GET", `/php/formulaireinscriptionreferent.php?prerempli=1&email=${this.id}`);
            xhttp.send();
        });
    }
}