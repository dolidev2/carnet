<?php
// include autoloader
require 'public/vendor/autoload.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;

// instantiate and use the dompdf class
$options = new Options();
$options->set('defaultFont', 'Colibri');
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled',true);
$dompdf = new Dompdf($options);

ob_start();
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?= $client->getNomClient() . ' ' .$client->getPrenomClient() ?></title>
        <!-- Favicon icon -->
        <link rel="icon" href="<?= URL ?>public/image/logo/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="<?= URL ?>public/assets/css/pdf.css" media="all" />
    </head>
    <body>
    <header class="clearfix">
        <div id="logo">
            <img src="<?= URL ?>public/image/logo/logo.jpeg">
        </div>
        <h1>COMMANDE <?= $commande->getDescCommande() ?></h1>
        <div id="company" class="clearfix">
            <div><?= $_SESSION['agence_nom'] ?></div>
            <div><?= $_SESSION['agence_adresse'] ?></div>
            <div><?= $_SESSION['agence_contact'] ?></div>
            <div><a href="#"><?= $_SESSION['agence_email'] ?></a></div>
        </div>
        <div id="project">
            <div><span>CLIENT</span> <?= $client->getNomClient() . ' ' .$client->getPrenomClient() ?></div>
            <div><span>ADRESSE</span><?= $client->getAdresseClient() . ' ' .$client->getContactClient()?></div>
            <div><span>DATE</span> <?= date("d-m-Y") ?></div>
        </div>
    </header>
    <h1>RETOUR CLIENT</h1>
    <main>
        <div>
            <h1 style="text-align: left;"> Dans l'optique d'améliorer la qualité de nos prestations, nous vous demandons de nous faire savoir sur une échelle de 1 à 5 votre satisfaction. Vos éventuelles observations et recommandations sont également attendues .
                Nous vous rassurons que nous tiendrons compte de vos suggestions pour une meilleure prise en charge de vos besoins.
              </h1>
            <h2>  Merci pour la confiance et la fidélité à GFI.</h2>
        </div>

    </main>
    <footer>
        Imprimé le <?= date("d-m-Y H:i:s"). ' par '.$user->getNomUser().' '.$user->getPrenomUser().' / '.$user->getRoleUser().' / '.$agence->getNomAgence()?>
    </footer>
    </body>
    </html>
<?php
$html = ob_get_clean();
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream($client->getNomClient() . ' ' . $client->getPrenomClient(),array('Attachment'=>0));
