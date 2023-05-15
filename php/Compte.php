<?php

class CompteJeune {
    public $id = 0;
    public $mdp = "";
    public $nom = "";
    public $prenom = "";
    public $email = "";
    public $datenaissance = "";
    public $reseau = "";
    public $engagement = "";
    public $duree = "";
    public $savoiretre = [];
    public $idref = [];
    public $complet = 0;
}


class CompteReferent {
    public $id = 0;
    public $nom = "";
    public $prenom = "";
    public $email = "";
    public $datenaissance = "";
    public $reseau = "";
    public $presentation = "";
    public $duree = "";
    public $savoiretre = [];
    public $idjeune = [];
}
?>