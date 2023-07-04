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
        <title><?= $personnel->getNomPers() . ' ' .$personnel->getPrenomPers() ?></title>
        <!-- Favicon icon -->
        <link rel="icon" href="<?= URL ?>public/image/logo/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="<?= URL ?>public/assets/css/pdf.css" media="all" />
    </head>
    <body>
    <header class="clearfix">
        <div id="logo">
            <img src="<?= URL ?>public/image/logo/logo.jpeg">
        </div>
        <h1>CAPACITE DE PRODUCTION</h1>
        <div id="company" class="clearfix">
            <div><?= $_SESSION['agence_nom'] ?></div>
            <div><?= $_SESSION['agence_adresse'] ?></div>
            <div><?= $_SESSION['agence_contact'] ?></div>
            <div><a href="#"><?= $_SESSION['agence_email'] ?></a></div>
        </div>
        <div id="project">
            <div><span>COLLABORATEUR</span> <?= $personnel->getNomPers() . ' ' .$personnel->getPrenomPers() ?></div>
            <div><span>CONTACT</span><?= $personnel->getContactPers() ?></div>
            <div><span>DATE</span> <?= date("d-m-Y") ?></div>
        </div>
    </header>
    <main>
        <table>
            <thead>
            <tr>
                <th colspan="2" class="desc">Modèle</th>
                <th>Quantité</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($modPers)):
                foreach ($modPers as $mod):?>
                    <tr>
                        <td colspan="2" class="desc"> <?= $mod['nom_modele'] ?></td>
                        <td><?= $mod['qte_mod_pers'] ?></td>
                    </tr>
            <?php endforeach;
                    endif; ?>

            </tbody>
        </table>
        <div id="notices">
            <div>DIRECTION</div>
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
$dompdf->stream($personnel->getNomPers() . ' ' .$personnel->getPrenomPers().' PRODUCTION',array('Attachment'=>0));
