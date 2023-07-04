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
    <html>
    <head>
        <style>
            html {
                height: 100%;
            }
            body {
                position: relative;
                min-height: 100%;
                margin: 0;
                padding: 0;
            }
            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            td, th {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }

            tr:nth-child(even) {
                background-color: #dddddd;
            }
            p{
                position: absolute;
                bottom: 0;
                left: 0;
                text-align: center;
            }
            h3{
                text-align: center;
                text-transform: uppercase;
                border: 1px solid black;
            }
        </style>
        <link rel="stylesheet" href="<?= URL ?>public/assets/css/pdf.css" media="all" />
        <title>
            Chiffre Affaire Période Agence
        </title>
    </head>
    <body>
    <div id="logo">
        <img src="<?= URL ?>public/image/logo/logo.jpeg">
    </div>

    <div>
        <h1>
            Chiffre Affaire  <?= $client->getNomClient()?>  <?= $client->getPrenomClient()  ?>  <?= $client->getContactClient() ?>
            du <?= date("d/m/Y",strtotime($debut))?> au  <?= date("d/m/Y",strtotime($fin))?>
        </h1>
    </div>
    <h3>Tableau des entrées</h3>
    <table>
        <thead>
        <tr>
            <th></th>
            <th class="desc">Date</th>
            <th class="desc">Somme</th>
            <th class="desc">Motif</th>
        </tr>
        </thead>
        <tbody>
        <?php   $total_entre=0; $i=1;
        if (isset($caisseEntre) && !empty($caisseEntre)):
            foreach ($caisseEntre as $caisse):?>
                    <tr>
                        <td><?= $i ?></td>
                        <td ><?= date("d-m-Y",strtotime($caisse['creat_caisse'])) ?></td>
                        <td class="desc"><?= $caisse['somme_caisse'] ?></td>
                        <td class="desc"><?= $caisse['desc_caisse'] ?></td>
                    </tr>
                    <?php $total_entre +=$caisse['somme_caisse']; $i++;
            endforeach;
        endif; ?>
        </tbody>
        <tfoot>
        <tr>
            <th colspan="3" class="desc">Montant total</th>
            <td class="total"><?= $total_entre  ?></td>
        </tr>
        </tfoot>
    </table>

    <h3>Tableau des sorties</h3>
    <table>
        <thead>
        <tr>
            <th></th>
            <th class="desc">Date</th>
            <th class="desc">Somme</th>
            <th class="desc">Motif</th>
        </tr>
        </thead>
        <tbody>
        <?php   $total_sortie=0; $i=1;
        if (isset($caisseSortie) && !empty($caisseSortie)):
            foreach ($caisseSortie as $caisse):
        ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td ><?= date("d-m-Y",strtotime($caisse['creat_caisse'])) ?></td>
                        <td class="desc"><?= $caisse['somme_caisse'] ?></td>
                        <td class="desc"><?= $caisse['desc_caisse'] ?></td>
                    </tr>
            <?php $total_sortie +=$caisse['somme_caisse']; $i++;
            endforeach;
        endif; ?>
        </tbody>
        <tfoot>
        <tr>
            <th colspan="3" class="desc">Montant total</th>
            <td class="total"><?= $total_sortie  ?></td>
        </tr>
        </tfoot>
    </table>

    <h3>Bilan</h3>
    <table>
        <thead>
        <tr>
            <th class="desc">Chiffre d'affaire</th>
            <th class="desc">Dépenses</th>
            <th class="desc">Recette</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="unit"><?= $total_entre  ?></td>
            <td class="unit"><?= $total_sortie  ?></td>
            <td class="unit"><?= $total_entre - $total_sortie  ?></td>
        </tr>
        </tbody>
    </table>

    <div>
        <span style="margin-right: 15%; text-decoration: underline; ">Direction</span>
    </div>
    <p> Imprimé le <?= date("d/m/Y H:i:s") ?>  par  <?= $user->getNomUser().' '.$user->getPrenomUser().' / '.$user->getRoleUser() .' / '.$agence->getNomAgence() ?></p>
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
$dompdf->stream('Chiffre Affaire Période Agence',array('Attachment'=>0));

