<?php


function chercheCompte ($bdd, $email) {
    $nombrecomptes = count($bdd->comptes);
    for ($i = 0; $i < $nombrecomptes; $i++) {
        if ($bdd->comptes[$i]->email == $email)
        return $i;
    }
    return -1;
}




?>