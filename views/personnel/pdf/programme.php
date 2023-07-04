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
                clear: left;
            }

            td, th {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }

            tr:nth-child(even) {
                background-color: #dddddd;
            }
            #logo{
                display: inline-block;
                float: left;

            }
            #collabo{
                float: right;
                margin-bottom: 100px;
            }
            #tache{
                text-align: center;
            }
            div footer {
                position: absolute; bottom: 0; left: 0; right: 0
            }

        </style>
    </head>
    <body>
    <div  id="logo">
        <img src="<?= URL ?>public/image/logo/logo.jpeg" width="100" height="100">
    </div>
    <div  id="collabo">
      <h4>
          <span><?= $personnel->getNomPers()?></span><br>
          <span><?= $personnel->getPrenomPers()?></span><br>
          <span><?=  $personnel->getContactPers()?></span><br>
      </h4>
    </div>

    <table>
        <tr>
            <th colspan="6" id="tache">Liste des tâches à effectuer  du <?= date("d/m/Y", strtotime($debut)).' au '.date("d/m/Y", strtotime($fin)) ?></th>

        </tr>
        <thead>
            <tr>
                <th>#</th>
                <th>Client</th>
                <th>Commande</th>
                <th>Modèle</th>
                <th>Type</th>
                <th>Quantité</th>
            </tr>
        </thead>

        <tbody>
        <?php if (!empty($taches)) :?>
            <?php $i=1; foreach ($taches as $tache): ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= $tache['nom_client'].' '.$tache['prenom_client'] ?></td>
                    <td><?= $tache['desc_commande'] ?></td>
                    <td><?= $tache['nom_modele'] ?></td>
                    <td><?= $tache['desc_prod'] ?></td>
                    <td><?= $tache['quantite_prod'] ?></td>
                </tr>
            <?php $i++; endforeach; ?>
        <?php endif; ?>


        </tbody>
    </table>
    <br>
    <div>
        <span style="float: left; text-decoration: underline">Direction</span>
        <span style="float: right; text-decoration: underline "> Collaborateur</span>
    </div>

    <div>
        <footer>
                <p> Imprimé le <?= date("d/m/Y H:i:s") ?> par <?= $user->getNomUser().' '.$user->getPrenomUser().' / '.$user->getRoleUser()  ?></p>
        </footer>
    </div>
    </body>
    </html>
<?php
$html = ob_get_clean();
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream('Programme_'.$personnel->getNomPers().'_'.$personnel->getNomPers(),array('Attachment'=>0));

