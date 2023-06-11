


//connexion et inscription

if (document.getElementById("connexion")) {
    document.getElementById("connexion").style.display = "none";
    var bouton = document.getElementById("conn");
    bouton.addEventListener("click", function () {
        document.getElementById("connexion").style.display = "block";
        document.getElementById("inscription").style.display = "none";
    });
}
if (document.getElementById("inscription")) {
    // document.getElementById("inscription").style.display = "none";
    var bouton = document.getElementById("insc");
    bouton.addEventListener("click", function () {
        document.getElementById("inscription").style.display = "block";
        document.getElementById("connexion").style.display = "none";
    });
}


// bouton ajax ajout de référent


if (document.getElementById("ajouterreferent")) {
    document.getElementById("ajouterreferent").addEventListener("click", function () {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var div = document.createElement("div");
                div.innerHTML = "<p>Ajouter une demande de referencement :</p>";
                div.innerHTML += "<p>Informations du référent</p>";
                div.id = "boitedetaildemande";
                div.innerHTML += this.responseText;
                document.getElementById("popup").appendChild(div);
                document.getElementById("popup").style.display = "block";
                document.getElementById("pageprincipale").style.display = "none";
                // document.write(this.responseText);
            }
        }
        xhttp.open("GET", "/php/formulaireinscriptionreferent.php");
        xhttp.send();
    });
}



// bouton ajax modification du compte

if (document.getElementById("modifiercompte")) {
    document.getElementById("modifiercompte").addEventListener("click", function () {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var div = document.createElement("div");
                div.id = "boitedetaildemande";
                div.innerHTML = this.responseText;
                document.getElementById("popup").appendChild(div);
                document.getElementById("popup").style.display = "block";
                document.getElementById("pageprincipale").style.display = "none";
                // console.log(this.responseText)
                // document.write(this.responseText);
            }
        }
        xhttp.open("GET", "/php/formulaireinscriptioncomplet.php");
        xhttp.send();
    });
}
// bouton ajax détail d'une demande de référencement

if (document.getElementsByClassName("detaildemande")) {
    var boutons = document.getElementsByClassName("detaildemande");
    for (var i = 0; i < boutons.length; i++) {
        boutons[i].addEventListener("click", function (e) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    var div = document.createElement("div");
                    div.id = "boitedetaildemande";
                    div.innerHTML = this.responseText;
                    document.getElementById("popup").appendChild(div);
                    document.getElementById("popup").style.display = "block";
                    document.getElementById("pageprincipale").style.display = "none";
                    // console.log(this.responseText);
                    // document.write(this.responseText);
                }
            }
            xhttp.open("GET", `/php/formulaireinscriptionreferent.php?prerempli=1&email=${this.id}`);
            xhttp.send();
        });
    }
}


// bouton qui alterne l'affichage entre le popup et la page principale

if (document.getElementById("fermerpopup")) {
    document.getElementById("popup").style.display = "none";
    document.getElementById("fermerpopup").addEventListener("click", function () {
        document.getElementById("popup").removeChild(document.getElementById("boitedetaildemande"));
        document.getElementById("popup").style.display = "none";
        document.getElementById("pageprincipale").style.display = "block";
    });
}

// bouton impression pdf
if (document.getElementById("pdf")) {
    document.getElementById("pdf").addEventListener("click", () => {
        print();
    })
}
