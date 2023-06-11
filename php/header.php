
    <?php

    // Cette partie en commentaire est un test pour tester laffichage sans les sessions 

 /*   echo '<div class="contenu_banniere">';
    echo '<img class="bloc1" src="LOGOS JEUNES.png" alt="Logo Jeune" />'; 
    echo '<div class="bloc2">';
    echo '<div class="bloc3"> Jeune </div>';  
    echo '<span class="bloc4"> Pour faire de l\'engagement une valeur </span>';
    echo '</div>';
    echo '</div>';
    echo '<div class="page">';
    echo '<span class="jeune"> Jeune </span>';
    echo '<span> Référent </span>';
    echo '<span> Consultant </span>';
    echo '<span> Partenaires </span>';
    echo '</div>';
    
*/

    // session_start(); // Déterminez la condition pour la page en cours
    if (strstr($_SERVER['PHP_SELF'], '/web/jeune.php')) {  // Je regarde si la page courante est celle du jeune, du referent ou du consultant
        $style1 = 'headerjeune';  // comme je suis dans le jeune je dois modifier lapparence du bandeau
        $style2 = 'default_2'; // la partie referent et consultant ne sont pas impacte donc je les laisse comme ils sont
        $style3 = 'default_3';
        echo '<div class="contenu_banniere">';
        echo '<a href="/web/accueil.php" class="bloc1"><img src="/img/LOGOS JEUNES.png" alt="Logo Jeune" /></a>'; 
        echo '<div class="bloc2">';
        echo '<div class="bloc3"> Jeune </div>';  
        echo '<span class="bloc4"> Je donne de la valeur à mon engagement </span>';
        echo '</div>';
        echo '</div>';
        echo '<div class="page">';
        echo '<span class="'.$style1.'"><a href="/web/jeune.php"> Jeune</a> </span>'; // jaffecte les styles requis par la condition au jeune, refernt et consultant
        echo '<span class="'.$style2.'"> <a href="/web/referent.php">Référent</a> </span>';
        echo '<span class="'.$style3.'"> <a href="/web/consultant.php">Consultant</a> </span>';
        echo '<span class="partenaires"> <a href="/web/partenaires.php">Partenaires</a> </span>'; // la partie partenaires reste la meme dans chaque categorie je nai donc pas besoin de la modifier
        echo '</div>';
        
    }
    else if(strstr($_SERVER['PHP_SELF'], '/web/referent.php')){ // je refais la meme verification avec la partie referent 
        $style1 = 'default_1';
        $style2 = 'headerreferent';
        $style3 = 'default_3';
        echo '<div class="contenu_banniere">';
        echo '<a href="/web/accueil.php" class="bloc1"><img src="/img/LOGOS JEUNES.png" alt="Logo Jeune" /></a>'; 
        echo '<div class="bloc2">';
        echo '<div class="bloc3"> Référent </div>';  
        echo '<span class="bloc4"> Je confirme la valeur de ton engagement </span>';
        echo '</div>';
        echo '</div>';
        echo '<div class="page">';
        echo '<span class="'.$style1.'"><a href="/web/jeune.php"> Jeune</a> </span>';
        echo '<span class="'.$style2.'"> <a href="/web/referent.php">Référent</a> </span>';
        echo '<span class="'.$style3.'"> <a href="/web/consultant.php">Consultant</a> </span>';
        echo '<span class="partenaires"> <a href="/web/partenaires.php">Partenaires</a> </span>';
        echo '</div>';
    }
    else if(strstr($_SERVER['PHP_SELF'], '/web/consultant.php')){ // enfin je fais la derniere verification pour la partie consultant
        $style1 = 'default_1';
        $style2 = 'default_2';
        $style3 = 'headerconsultant';
        echo '<div class="contenu_banniere">';
        echo '<a href="/web/accueil.php" class="bloc1"><img src="/img/LOGOS JEUNES.png" alt="Logo Jeune" /></a>'; 
        echo '<div class="bloc2">';
        echo '<div class="bloc3"> Consultant </div>';  
        echo '<span class="bloc4"> Je donne de la valeur à ton engagement </span>';
        echo '</div>';
        echo '</div>';
        echo '<div class="page">';
        echo '<span class="'.$style1.'"><a href="/web/jeune.php"> Jeune</a> </span>';
        echo '<span class="'.$style2.'"> <a href="/web/referent.php">Référent</a> </span>';
        echo '<span class="'.$style3.'"> <a href="/web/consultant.php">Consultant</a> </span>';
        echo '<span class="partenaires"> <a href="/web/partenaires.php">Partenaires</a> </span>';
        echo '</div>';
    }
    else {
        echo '<div class="contenu_banniere">';
        echo '<a href="/web/accueil.php" class="bloc1"><img src="/img/LOGOS JEUNES.png" alt="Logo Jeune" /></a>'; 
        echo '<div class="bloc2">';
        echo '<div class="bloc3">Jeunes 6.4</div>';  
        echo '<span class="bloc4"> Pour faire de l\'engagement une valeur </span>';
        echo '</div>';
        echo '</div>';
        echo '<div class="page">';
        echo '<span class="default_1"><a href="/web/jeune.php"> Jeune</a> </span>';
        echo '<span class="default_2"> <a href="/web/referent.php">Référent</a> </span>';
        echo '<span class="default_3"> <a href="/web/consultant.php">Consultant</a> </span>';
        echo '<span class="partenaires"> <a href="/web/partenaires.php">Partenaires</a> </span>';
        echo '</div>';
    }
    ?>
