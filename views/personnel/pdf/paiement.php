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
    </style>
    <link rel="stylesheet" href="<?= URL ?>public/assets/css/pdf.css" media="all" />
    <title>
        <?= $personnel->getNomPers() . ' ' .$personnel->getPrenomPers() ?>
    </title>
</head>
<body>
<div id="logo">
    <img src="<?= URL ?>public/image/logo/logo.jpeg">
</div>

<div>
    <h2>
        <span>
             Période de paiement du <?= date("d/m/Y",strtotime($debut))  ?> au <?=date("d/m/Y",strtotime($fin)) ?>
        </span>
        <span style="float: right;">
            <?= $personnel->getNomPers() . ' ' .$personnel->getPrenomPers().' '.$personnel->getContactPers() ?>
        </span>
    </h2>
</div>

<table>
    <thead>
        <tr>
            <th>Modèle</th>
            <th>Quantité</th>
            <th>Date</th>
            <th>Prime</th>
            <th>Côut</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
    <?php $som=0; if (isset($programmes) && !empty($programmes)): ?>
        <?php  foreach ($programmes as $p): ?>
        <tr>
            <td><?= $p['nom_modele'] ?></td>
            <td><?= $p['quantite_cmt'] ?></td>
            <td><?= date("d-m-Y",strtotime($p['creat_commande'])) ?></td>
            <td><?= $p['rend_prod'] ?></td>
            <td><?= $p['cout_modele'] ?></td>
            <td><?= (($p['quantite_prod'] * $p['somme_prod']) + ($p['quantite_prod']*$p['rend_prod'])) ?></td>
        </tr>
        <?php $som +=  (($p['quantite_prod'] * $p['somme_prod']) + ($p['quantite_prod']*$p['rend_prod'])); endforeach; ?>
    <?php endif; ?>
    </tbody>
    <tfoot>
    <tr>
        <th colspan="2">Montant à percevoir</th>
        <th colspan="2">Avance</th>
        <th colspan="2">Montant Net</th>
    </tr>
    <tr>
        <td colspan="2"><?= $som ?></td>
        <td colspan="2"><?= $tot ?></td>
        <td colspan="2"><?= ($som-$tot) ?></td>
    </tr>
    </tfoot>
</table>
<div>
    <span style="float: left; margin-right: 20%;">J'atteste que j'ai reçu la somme équivalente à ma prestation</span>
    <span style="margin-right: 15%; ">Direction</span>
    <span>Collaborateur</span>
</div>
    <p> Imprimé le <?= date("d/m/Y H:i:s") ?> par <?= $user->getNomUser().' '.$user->getPrenomUser().' / '.$user->getRoleUser() .' / '.$agence->getNomAgence() ?></p>
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
$dompdf->stream('Paiement',array('Attachment'=>0));

