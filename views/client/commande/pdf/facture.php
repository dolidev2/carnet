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
    <title><?= $client->getNomClient() ?></title>
    <link rel="stylesheet" href="<?= URL ?>public/assets/css/pdf.css" media="all" />
</head>
<body>
<header class="clearfix">
    <div id="logo">
        <img src="<?= URL ?>public/image/logo/logo.png">
    </div>
    <h1>FA-<?= $commande->getDescCommande() ?></h1>
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
        <div><span>CLIENT</span> <?= $client->getNomClient() . ' ' .$client->getPrenomClient() ?></div>

        <?php if($client->getTypeClient() == 'entreprise'): ?>
            <div><span>DELAI D'EXECUTION:</span> <?= date("d-m-Y",strtotime($commande->getRdvCommande()))?></div>
            <div><span>IFU</span> <?= $client->getIfuClient() ?></div>
            <div><span>RCCM</span> <?= $client->getRccmClient() ?></div>
            <div><span>BOITE POSTALE</span> <?= $client->getBoitePostalClient()?></div>
            <div><span>DIVISION FISCALE</span> <?= $client->getDivisionFiscaleClient() ?></div>
            <div><span>REGIME D'IMPOSITION</span> <?= $client->getRegimeImpositionClient()?></div>
        <?php endif; ?>
        <div><span>ADRESSE</span><?= $client->getAdresseClient() ?> </div>
        <div><span>CONTACT</span><?= $client->getContactClient() ?></div>
        <?php if($client->getTypeClient() != 'entreprise'):?>
            <div><span>DATE DE RDV:</span> <?=  date("d/m/Y",strtotime($commande->getRdvCommande()))?></div>
        <?php endif;?>
       
    </div>
</header>
<main>
    <table>
        <thead>
        <tr>
            <th class="desc">DESIGNATION</th>
            <th>PRIX</th>
            <th>QUANTITE</th>
            <?php if($remise_existe):?>
            <th>REMISE</th>
            <?php else: ?>
            <th></th>
            <?php endif; ?>
            <th>TOTAL</th>
        </tr>
        </thead>
        <tbody>
            <?php if(!empty($data_cmd)):
                    $sommeCharge = 0;
                    $sommeOeuvre =0;
                    $sommeTissu =0;
                    $i=1;
                    //Couture
                    foreach($data_cmd as $cmd):
                        $remise = ($cmd['remise'] != 0)? ($cmd['remise']): '' ;
                        $sommeOeuvre += $cmd['prix']*$cmd['qte'];
                        $sommeCharge += $cmd['somme_charge']+ $cmd['remise'];
                        if ($i == 1):
            ?>
                            <tr> <td colspan="5"  class="unit" style="text-align: center; text-decoration: underline;">COUTURE</td></tr>
                        <?php endif; ?>
                        <tr>
                            <td class="desc"><?= strtoupper($cmd['modele']) ?></td>
                            <td class="unit"><?= $cmd['prix'] ?></td>
                            <td class="qty"><?= $cmd['qte'] ?></td>
                            <td class="qty"><?= $remise ?></td>
                            <td class="total"><?= (($cmd['qte']*$cmd['prix'])-$cmd['remise'] )?></td>
                        </tr>
            <?php
                   $i++; endforeach;
                   $k=1;
                   foreach($data_cmd as $cmd){
                       //Charge de production
                       if( $client->getTypeClient() == 'entreprise'):
                           if(!empty($cmd['charge'])):
                               if ($k == 1):
                                   ?>
                                   <tr> <td colspan="5"  class="unit" style="text-align: center; text-decoration: underline;">CHARGE DE PRODUCTION</td></tr>
                                   <?php
                                   foreach ($cmd['charge'] as $charge):  ?>
                                       <tr>
                                           <td class="desc" ><?=strtoupper($charge['ressource']) ?></td>
                                           <td class="unit"><?= $charge['prix'] ?></td>
                                           <td class="qty"></td>
                                           <td class="qty"></td>
                                           <td class="total"></td>
                                       </tr>
                                   <?php endforeach; ?>
                                   <tr>
                                       <td class="desc" colspan="4"> Total charge</td>
                                       <td class="total"><?= $cmd['somme_charge'] ?></td>
                                   </tr>
                               <?php endif;
                           $k++; endif;
                       endif;
                   }
                    //Achat de tissu
                    $j=1;
                    foreach ($data_cmd as $cmd):
                     if($cmd['tissu_qte'] != 0):
                        $sommeTissu += $cmd['tissu_prix'];
                        if ($j == 1):
                            ?>
                            <tr> <td class="unit" colspan="5"  class="unit" style="text-align: center;text-decoration: underline;">ACHAT DE TISSU</td></tr>
                        <?php endif; ?>
                        <tr>
                            <td class="desc" ><?= $j.' '.$cmd['tissu'] ?></td>
                            <td class="unit"></td>
                            <td class="qty"><?= $cmd['tissu_qte'] ?></td>
                            <td class="qty"></td>
                            <td class="total"><?= $cmd['tissu_prix'] ?></td>
                        </tr>
                    <?php $j++;endif;
                    endforeach;
                      if( $client->getTypeClient() == 'entreprise'):  ?>
                        <tr> <td colspan="5"  class="unit" style="text-align: center; text-decoration: underline;">MAIN D'OEUVRE</td></tr>
                        <tr>
                            <td class="desc" colspan="4">MAIN D'OEUVRE</td>
                            <td class="total"><?= ($sommeOeuvre - $sommeCharge) ?></td>
                        </tr>
            <?php endif;?>

            <tr>
                <td colspan="4">TOTAL</td>
                <td class="total"><?= (($sommeOeuvre+$sommeTissu)-$sommeCharge)?></td>
            </tr>
            <?php   endif; ?> ?>
        </tbody>
    </table>
    <div id="notices">
        <div>DIRECTION</div>
    </div>
</main>
<footer>
    Imprimé le <?= date("d/m/Y H:i:s") ?> par <?= $user->getNomUser() . ' ' .$user->getPrenomUser().' / '.$user->getRoleUser().' / '.$agence->getNomAgence() ?>
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
$dompdf->stream('Facture '. $client->getNomClient().' '. $client->getPrenomClient(),array('Attachment'=>0));
