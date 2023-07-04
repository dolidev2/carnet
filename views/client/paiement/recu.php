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
        <title><?= $client->getNomClient().' '.$client->getPrenomClient() ?></title>
        <link rel="stylesheet" href="<?= URL ?>public/assets/css/pdf.css" media="all" />
    </head>
    <body>
    <header class="clearfix">
        <div id="logo">
            <img src="<?= URL ?>public/image/logo/logo.jpeg">
        </div>
        <h1>RECU DE PAIEMENT <?= $commande->getDescCommande() ?></h1>
        <div id="company" class="clearfix">
            <div><?= $_SESSION['agence_nom'] ?></div>
            <div><?= $_SESSION['agence_adresse'] ?></div>
            <div><?= $_SESSION['agence_contact'] ?></div>
            <div><?= $_SESSION['agence_ifu'] ?></div>
            <div><?= $_SESSION['agence_rccm'] ?></div>
            <div><?= $_SESSION['agence_ri'] ?></div>
            <div><?= $_SESSION['agence_df'] ?></div>
            <div><?= $_SESSION['agence_bp'] ?></div>
            <div><a href="#"><?= $_SESSION['agence_email'] ?></a></div>
        </div>
        <div id="project">
            <!--            <div><span>PROJECT</span> Website development</div>-->
            <div><span>CLIENT</span> <?= $client->getNomClient().' '.$client->getPrenomClient() ?></div>
            <div><span>ADRESSE</span><?= $client->getAdresseClient().' '.$client->getContactClient()?></div>
            <div><span>DATE</span> <?= date("d-m-Y") ?></div>
        </div>
    </header>
    <main>
        <table>
            <thead>
            <tr>
                <th colspan="2" class="desc">DESCRIPTION</th>
                <th>SOMME</th>
                <th>TYPE</th>
                <th>DATE</th>
            </tr>
            </thead>
            <tbody>
            <?php $som=0; foreach ($paies as $p): ?>
                <tr>
                    <td colspan="2" class="desc"><?= $p->getDescPaie() ?></td>
                    <td class="unit"><?=$p->getSommePaie() ?></td>
                    <td class="qty"><?= $p->getTypePaie() ?></td>
                    <td class="total"><?= date("d-m-Y", strtotime($p->getCreatPaie())) ?></td>
                </tr>
                <?php $som += $p->getSommePaie() ;  endforeach; ?>
            <tr>
                <td colspan="4">Montant versé</td>
                <td class="total"><?= $som ?></td>
            </tr>
            <tr>
                <td colspan="4">Reliquat</td>
                <td class="total"><?= ($somme - $som) ?></td>
            </tr>

            </tbody>
        </table>
        <div id="notices">
            <div>DIRECTION</div>
            <!--            <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>-->
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
$dompdf->stream('RECU '. $client->getNomClient() . ' ' . $client->getPrenomClient(),array('Attachment'=>0));