<?php

class CompteJeune {
    public $id = -1;
    public $mdp = "";
    public $nom = "";
    public $prenom = "";
    public $email = "";
    public $emailconultant = "";
    public $datenaissance = "";
    public $reseau = "";
    public $engagement = "";
    public $duree = "";
    public $savoiretre = [];
    public $savoiretreref = [];
    public $idref = [];
    public $statutdemande = [];
    public $commentaire = [];
    public $statutdemandeconsultant = 0;
    public $messagestatutdemandeconsultant = "Demande non envoyée au consultant";
    public $complet = 0;
}


class CompteReferent {
    public $id = -1;
    public $nom = "";
    public $prenom = "";
    public $email = "";
    public $datenaissance = "";
    public $reseau = "";
    public $presentation = "";
    public $duree = "";
    public $idjeune = [];
}
?>