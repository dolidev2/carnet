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
                width: 100%;
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
            Liste des transactions sur le stock
        </title>
    </head>
    <body>
    <div id="logo">
        <img src="<?= URL ?>public/image/logo/logo.jpeg">
    </div>

    <div>
        <h1>
            Liste des clients <?= $agence->getNomAgence()?>
            du <?= date("d/m/Y",strtotime($debut))  ?> au <?=date("d/m/Y",strtotime($fin)) ?>
        </h1>
    </div>
    <h3>Liste des clients </h3>
    <table>
        <thead>
        <tr>
            <th class="desc"></th>
            <th class="desc">Nom</th>
            <th class="desc">Prénoms</th>
            <th class="desc">Numéro mesure</th>
            <th class="desc">Contact</th>
            <th class="desc">Type</th>
            <th class="desc">Date</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (isset($clients) && !empty($clients)):
            $i=1;
            foreach ($clients as $client):
                ?>
                <tr>
                    <td class="desc"><?= $i ?></td>
                    <td class="desc"><?= $client['nom_client'] ?></td>
                    <td class="desc"><?= $client['prenom_client'] ?></td>
                    <td class="desc"><?= $client['numero_mesure'] ?></td>
                    <td class="desc"><?= $client['contact_client'] ?></td>
                    <td class="desc"><?= $client['type_client'] ?></td>
                    <td class="desc"><?= date("d/m/Y",strtotime($client['creat_client'])); ?></td>
                </tr>
                <?php
                $i++;
            endforeach;
        endif; ?>
        </tbody>
    </table>
    <div>
        <span style="margin-right: 15%; text-decoration: underline; ">Direction</span>
    </div>
    <p> Imprimé le <?= date("d/m/Y H:i:s") ?> par <?= $user->getNomUser().' '.$user->getPrenomUser().' / '.$user->getRoleUser() .' / '.$agenceUser->getNomAgence() ?></p>
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
$dompdf->stream('Transaction stock ressource',array('Attachment'=>0));

