<?php
require_once __DIR__ . '/mpdf/vendor/autoload.php';

$htmlFilePath = 'chemin/vers/le/fichier.html'; // la tu mets le chemin vers la page web, donc le site
$pdfFilePath = 'chemin/de/sortie/fichier.pdf'; // ici tu mets le chemin que tu veux pour la sortie en pdf

$mpdf = new \Mpdf\Mpdf(); // le reste c'est le code pour faire la conversion en utlisant la bibliothèque mpdf que jai mis avec ce fichier
$mpdf->SetImportUse();
$mpdf->SetDocTemplate($htmlFilePath, true);
$mpdf->Output($pdfFilePath, \Mpdf\Output\Destination::FILE);

echo "Conversion terminée. Le fichier PDF a été généré.";
?>
