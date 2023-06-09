<!DOCTYPE html>
<html>
<head>
    <title> Jeunes 6.4 </title>
    <link rel="stylesheet" type="text/css" href="header.css" >
</head>
<body>
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

    session_start(); // Déterminez la condition pour la page en cours
    if ($_SERVER['PHP_SELF'] === '/jeune.php') {  // Je regarde si la page courante est celle du jeune, du referent ou du consultant
        $style1 = 'jeune';  // comme je suis dans le jeune je dois modifier lapparence du bandeau
        $style2 = 'default_2'; // la partie referent et consultant ne sont pas impacte donc je les laisse comme ils sont
        $style3 = 'default_3';
        echo '<div class="contenu_banniere">';
        echo '<img class="bloc1" src="LOGOS JEUNES.png" alt="Logo Jeune" />'; 
        echo '<div class="bloc2">';
        echo '<div class="bloc3"> Jeune </div>';  
        echo '<span class="bloc4"> Je donne de la valeur à mon engagement </span>';
        echo '</div>';
        echo '</div>';
        echo '<div class="page">';
        echo '<span class="<?php echo $style1; ?>"> Jeune </span>'; // jaffecte les styles requis par la condition au jeune, refernt et consultant
        echo '<span class="<?php echo $style2; ?>"> Référent </span>';
        echo '<span class="<?php echo $style3; ?>"> Consultant </span>';
        echo '<span class="partenaires"> Partenaires </span>'; // la partie partenaires reste la meme dans chaque categorie je nai donc pas besoin de la modifier
        echo '</div>';
    }
    else if($_SERVER['PHP_SELF'] === '/referent.php'){ // je refais la meme verification avec la partie referent 
        $style1 = 'default_1';
        $style2 = 'referent';
        $style3 = 'default_3';
        echo '<div class="contenu_banniere">';
        echo '<img class="bloc1" src="LOGOS JEUNES.png" alt="Logo Jeune" />'; 
        echo '<div class="bloc2">';
        echo '<div class="bloc3"> Référent </div>';  
        echo '<span class="bloc4"> Je confirme la valeur de ton engagement </span>';
        echo '</div>';
        echo '</div>';
        echo '<div class="page">';
        echo '<span class="<?php echo $style1; ?>"> Jeune </span>';
        echo '<span class="<?php echo $style2; ?>"> Référent </span>';
        echo '<span class="<?php echo $style3; ?>"> Consultant </span>';
        echo '<span class="partenaires"> Partenaires </span>';
        echo '</div>';
    }
    else if($_SERVER['PHP_SELF'] === '/consultant.php'){ // enfin je fais la derniere verification pour la partie consultant
        $style1 = 'default_1';
        $style2 = 'default_2';
        $style3 = 'consultant';
        echo '<div class="contenu_banniere">';
        echo '<img class="bloc1" src="LOGOS JEUNES.png" alt="Logo Jeune" />'; 
        echo '<div class="bloc2">';
        echo '<div class="bloc3"> Consultant </div>';  
        echo '<span class="bloc4"> Je donne de la valeur à ton engagement </span>';
        echo '</div>';
        echo '</div>';
        echo '<div class="page">';
        echo '<span class="<?php echo $style1; ?>"> Jeune </span>';
        echo '<span class="<?php echo $style2; ?>"> Référent </span>';
        echo '<span class="<?php echo $style3; ?>"> Consultant </span>';
        echo '<span class="partenaires"> Partenaires </span>';
        echo '</div>';
    }
    ?>
</body>
</html>
