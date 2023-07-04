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
            Classement Tissu acheté
        </title>
    </head>
    <body>
    <div id="logo">
        <img src="<?= URL ?>public/image/logo/logo.jpeg">
    </div>

    <div>
        <h1>
            Récapitulatifs des tissus achetés <?= $agence->getNomAgence()?> du <?= date("d/m/Y",strtotime($debut))  ?> au <?=date("d/m/Y",strtotime($fin)) ?>
        </h1>
    </div>
    <h3>Récapitulatifs des tissus achetés</h3>
    <table>
        <thead>
        <tr>
            <th></th>
            <th class="desc">Nom & Prénoms & Contact</th>
            <th class="desc">Nom tissu</th>
            <th class="desc">Prix</th>
            <th class="desc">Quantité</th>
            <th class="desc">Commission</th>
        </tr>
        </thead>
        <tbody>
        <?php   $i=1;
        if (isset($tissus) && !empty($tissus)):
            foreach ($tissus as $ts):
                ?>
                <tr>
                    <td><?= $i ?></td>
                    <td class="desc"><?= $ts['nom_client']." ".$ts['prenom_client']." ".$ts['contact_client'] ?></td>
                    <td class="desc"><?= $ts['nom_tissu'] ?></td>
                    <td class="desc"><?= $ts['prix_tissu'] ?></td>
                    <td class="desc"><?= $ts['quantite_tissu'] ?></td>
                    <td class="desc"><?= $ts['commission_tissu'] ?></td>
                </tr>
                <?php $i++;
            endforeach;
        endif; ?>
        </tbody>
    </table>

    <br>
    <br>
    <br>
    <h3>Classement par clients des tissus achetés</h3>
    <table>
        <thead>
        <tr>
            <th></th>
            <th class="desc">Nom & Prénoms & Contact</th>
            <th class="desc">Total Prix</th>
            <th class="desc">Total Commission</th>
        </tr>
        </thead>
        <tbody>
        <?php   $i=1;
        if (isset($clients) && !empty($clients)):
            foreach ($clients as $cl):
                ?>
                <tr>
                    <td><?= $i ?></td>
                    <td class="desc"><?= $cl['nom_client']." ".$cl['prenom_client']." ".$cl['contact_client'] ?></td>
                    <td class="desc"><?= $cl['total'] ?></td>
                    <td class="desc"><?= $cl['commission'] ?></td>
                </tr>
                <?php $i++;
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
$dompdf->stream('Classement Modèle Période Agence',array('Attachment'=>0));

