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
        <style>
            td .unit{
                text-align:left;
            }
        </style>
    </head>

    <body>
    <header class="clearfix">
        <div id="logo">
            <img src="<?= URL ?>public/image/logo/logo.jpeg">
        </div>
        <h1>MESURES</h1>
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
    <main>
        <table>
            <thead>
                <tr>
                    <th colspan="2" class="desc">Désignation</th>
                    <th>Mesure</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($mesure->getEpauleMesure())): ?>
                    <tr>
                        <td colspan="2" class="desc">Epaule</td>
                        <td class="unit"><?= $mesure->getEpauleMesure() ?></td>
                    </tr>
                <?php endif; ?>

                <?php if (!empty($mesure->getLEpauleMesure())): ?>
                    <tr>
                        <td colspan="2" class="desc">Longueur Epaule</td>
                        <td class="unit"><?= $mesure->getLEpauleMesure() ?></td>
                    </tr>
                <?php endif; ?>

                <?php if (!empty($mesure->getBasMesure())): ?>
                    <tr>
                        <td colspan="2" class="desc">Bas</td>
                        <td class="unit"><?= $mesure->getBasMesure() ?></td>
                    </tr>
                <?php endif; ?>

                <?php if (!empty($mesure->getLMancheMesure())): ?>
                    <tr>
                        <td colspan="2" class="desc">Longueur Manche</td>
                        <td class="unit"><?= $mesure->getLMancheMesure() ?></td>
                    </tr>
                <?php endif; ?>

                <?php if (!empty($mesure->getPoitrineMesure())): ?>
                    <tr>
                        <td colspan="2" class="desc">Poitrine</td>
                        <td class="unit"><?= $mesure->getPoitrineMesure() ?></td>
                    </tr>
                <?php endif; ?>

                <?php if (!empty($mesure->getDosMesure())): ?>
                    <tr>
                        <td colspan="2" class="desc">Dos</td>
                        <td class="unit"><?= $mesure->getDosMesure() ?></td>
                    </tr>
                <?php endif; ?>

                <?php if (!empty($mesure->getBassinMesure())): ?>
                    <tr>
                        <td colspan="2" class="desc">Bassin</td>
                        <td class="unit"><?= $mesure->getBassinMesure() ?></td>
                    </tr>
                <?php endif; ?>

                <?php if (!empty($mesure->getLTailleMesure())): ?>
                    <tr>
                        <td colspan="2" class="desc">Longueur Taille</td>
                        <td class="unit"><?= $mesure->getLTailleMesure() ?></td>
                    </tr>
                <?php endif; ?>

                <?php if (!empty($mesure->getTGenouMesure())): ?>
                    <tr>
                        <td colspan="2" class="desc">Tour Genou</td>
                        <td class="unit"><?= $mesure->getTGenouMesure() ?></td>
                    </tr>
                <?php endif; ?>

                <?php if (!empty($mesure->getCeintureMesure())): ?>
                    <tr>
                        <td colspan="2" class="desc">Ceinture</td>
                        <td class="unit"><?= $mesure->getCeintureMesure() ?></td>
                    </tr>
                <?php endif; ?>

                <?php if (!empty($mesure->getPoignetMesure())): ?>
                    <tr>
                        <td colspan="2" class="desc">Poignet</td>
                        <td class="unit"><?= $mesure->getPoignetMesure() ?></td>
                    </tr>
                <?php endif; ?>

                <?php if (!empty($mesure->getTTailleMesure())): ?>
                    <tr>
                        <td colspan="2" class="desc">Tour Taille</td>
                        <td class="unit"><?= $mesure->getTTailleMesure() ?></td>
                    </tr>
                <?php endif; ?>

                <?php if (!empty($mesure->getTMancheMesure())): ?>
                    <tr>
                        <td colspan="2" class="desc">Tour Manche</td>
                        <td class="unit"><?= $mesure->getTMancheMesure() ?></td>
                    </tr>
                <?php endif; ?>

                <?php if (!empty($mesure->getColeMesure())): ?>
                    <tr>
                        <td colspan="2" class="desc">Cole</td>
                        <td class="unit"><?= $mesure->getColeMesure() ?></td>
                    </tr>
                <?php endif; ?>

                <?php if (!empty($mesure->getCuisseMesure())): ?>
                    <tr>
                        <td colspan="2" class="desc">Cuisse</td>
                        <td class="unit"><?= $mesure->getCuisseMesure() ?></td>
                    </tr>
                <?php endif; ?>

                <?php if (!empty($mesure->getLChemiseMesure())): ?>
                    <tr>
                        <td colspan="2" class="desc">Longueur Chemise</td>
                        <td class="unit"><?= $mesure->getLChemiseMesure() ?></td>
                    </tr>
                <?php endif; ?>

                <?php if (!empty($mesure->getLGiletMesure())): ?>
                    <tr>
                        <td colspan="2" class="desc">Longueur Gilet</td>
                        <td class="unit"><?= $mesure->getLGiletMesure() ?></td>
                    </tr>
                <?php endif; ?>

                <?php if (!empty($mesure->getLVesteMesure())): ?>
                    <tr>
                        <td colspan="2" class="desc">Longueur Veste</td>
                        <td class="unit"><?= $mesure->getLVesteMesure() ?></td>
                    </tr>
                <?php endif; ?>

                <?php if (!empty($mesure->getLGenouMesure())): ?>
                    <tr>
                        <td colspan="2" class="desc">Longueur Genou</td>
                        <td class="unit"><?= $mesure->getLGenouMesure() ?></td>
                    </tr>
                <?php endif; ?>

                <?php if (!empty($mesure->getLPantalonMesure())): ?>
                    <tr>
                        <td colspan="2" class="desc">Longueur Pantalon</td>
                        <td class="unit"><?= $mesure->getLPantalonMesure() ?></td>
                    </tr>
                <?php endif; ?>

                <?php if (!empty($mesure->getPantacourtMesure())): ?>
                    <tr>
                        <td colspan="2" class="desc">Longueur Pantacourt</td>
                        <td class="unit"><?= $mesure->getPantacourtMesure() ?></td>
                    </tr>
                <?php endif; ?>

                <?php if (!empty($mesure->getEJambeMesure())): ?>
                    <tr>
                        <td colspan="2" class="desc">Ecart Jambe</td>
                        <td class="unit"><?= $mesure->getEJambeMesure() ?></td>
                    </tr>
                <?php endif; ?>

                <?php if (!empty($mesure->getLChemiseAMesure())): ?>
                    <tr>
                        <td colspan="2" class="desc">Longueur Chemise Arabe</td>
                        <td class="unit"><?= $mesure->getLChemiseAMesure() ?></td>
                    </tr>
                <?php endif; ?>

                <?php if (!empty($mesure->getFrappeMesure())): ?>
                    <tr>
                        <td colspan="2" class="desc">Frappe</td>
                        <td class="unit"><?= $mesure->getFrappeMesure() ?></td>
                    </tr>
                <?php endif; ?>
                <?php if (!empty($mesure->getTTeteMesure())): ?>
                    <tr>
                        <td colspan="2" class="desc">Tour de tête</td>
                        <td class="unit"><?= $mesure->getTTeteMesure() ?></td>
                    </tr>
                <?php endif; ?>

                <?php if (!empty($mesure->getCarrureMesure())): ?>
                    <tr>
                        <td colspan="2" class="desc">Carrure</td>
                        <td class="unit"><?= $mesure->getCarrureMesure() ?></td>
                    </tr>
                <?php endif; ?>

                <?php if (!empty($mesure->getEPPoitrineMesure())): ?>
                    <tr>
                        <td colspan="2" class="desc">Ecart Pince Poitrine</td>
                        <td class="unit"><?= $mesure->getEPPoitrineMesure() ?></td>
                    </tr>
                <?php endif; ?>

                <?php if (!empty($mesure->getLJupeMesure())): ?>
                    <tr>
                        <td colspan="2" class="desc">Longueur Jupe</td>
                        <td class="unit"><?= $mesure->getLJupeMesure() ?></td>
                    </tr>
                <?php endif; ?>

                <?php if (!empty($mesure->getLRobeMesure())): ?>
                    <tr>
                        <td colspan="2" class="desc">Longueur Robe</td>
                        <td class="unit"><?= $mesure->getLRobeMesure() ?></td>
                    </tr>
                <?php endif; ?>

                <?php if (!empty($mesure->getLPoitrineMesure())): ?>
                    <tr>
                        <td colspan="2" class="desc">Hauteur Poitrine</td>
                        <td class="unit"><?= $mesure->getLPoitrineMesure() ?></td>
                    </tr>
                <?php endif; ?>

                <?php if (!empty($mesure->getLHautMesure())): ?>
                    <tr>
                        <td colspan="2" class="desc">Longueur Haut</td>
                        <td class="unit"><?= $mesure->getLHautMesure() ?></td>
                    </tr>
                <?php endif; ?>
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
$dompdf->stream($client->getNomClient() . ' ' . $client->getPrenomClient(),array('Attachment'=>0));
