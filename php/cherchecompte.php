<?php


function chercheCompteJeune ($bdd, $email) {
    $nombrecomptes = count($bdd->comptejeune);
    for ($i = 0; $i < $nombrecomptes; $i++) {
        if ($bdd->comptejeune[$i]->email == $email)
        return $i;
    }
    return -1;
}
function chercheCompteReferent ($bdd, $email) {
    $nombrecomptes = count($bdd->compteref);
    for ($i = 0; $i < $nombrecomptes; $i++) {
        if ($bdd->compteref[$i]->email == $email)
        return $i;
    }
    return -1;
}




?>