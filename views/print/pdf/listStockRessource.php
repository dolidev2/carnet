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
            Transaction ressource <?= $agence->getNomAgence()?> du <?= date("d/m/Y",strtotime($debut))  ?> au <?=date("d/m/Y",strtotime($fin)) ?>
        </h1>
    </div>
    <h3>Liste des mouvements sur le stocks</h3>
    <table>
        <thead>
        <tr>
            <th></th>
            <th class="desc">Ressource</th>
            <th class="desc"></th>
            <th class="desc">Description</th>
            <th class="desc"></th>
            <th class="desc"></th>

        </tr>
        </thead>
        <tbody>
        <?php
        if (isset($data) && !empty($data)):
            foreach ($data as $dt):
                ?>
                <tr>
                    <td></td>
                    <th class="desc"><?= $dt['ressource']['nom_res'] ?></th>
                    <td class="desc"></td>
                    <th class="desc"><?= $dt['ressource']['desc_res'] ?></th>
                    <td class="desc"></td>
                    <td class="desc"></td>
                </tr>
                <?php
                if (isset($dt['stock']) && !empty($dt['stock'])):
                    ?>
                    <tr>
                        <th></th>
                        <th class="desc">Description</th>
                        <th class="desc">Quantité</th>
                        <th class="desc">Prix en Gros</th>
                        <th class="desc">Prix au détail</th>
                        <th class="desc">Date</th>
                    </tr>
                    <?php
                    $j=1;
                    foreach ($dt['stock'] as $art):?>
                        <tr>
                            <td><?= $j ?></td>
                            <td class="desc"><?= $art['desc'] ?></td>
                            <td class="desc"><?= $art['quantite'] ?></td>
                            <td class="desc"><?= $art['prix_g'] ?></td>
                            <td class="desc"><?= $art['prix_d'] ?></td>
                            <td class="desc"><?= date("d/m/Y", strtotime($art['date'])) ?></td>
                        </tr>
                    <?php
                        $j++;
                    endforeach;
                    ?>
                    <tr>
                        <th></th>
                        <th class="desc" colspan="2">Bilan</th>
                        <th class="desc">Entré</th>
                        <th class="desc">Sortie</th>
                        <th class="desc">Différence</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th class="desc" colspan="2"></th>
                        <th class="desc"><?= $dt['entre'] ?></th>
                        <th class="desc"><?= $dt['sorti'] ?></th>
                        <th class="desc"><?= $dt['sorti']- $dt['entre']?></th>
                    </tr>
                <?php
                endif;
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

