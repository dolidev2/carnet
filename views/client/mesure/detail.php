<?php
$header = '';
ob_start();
?>
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Infos sur la mesure du client</h4>

            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= URL ?>accueil">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?= URL ?>client">Client</a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?= URL ?>client/info/<?= $client->getIdClient()?>">Mesure</a>
                    </li>
                    <li class="breadcrumb-item"><a href=" ">Infos</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page header end -->
        <!-- Page body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Basic Form Inputs card start -->
                    <div class="card">
                        <div class="card-block">
                            <h4 class="sub-title">Info Client</h4>
                            <div class="row">
                                <div class="form-control col-sm-6">
                                    <label class="col-form-label">Nom</label>
                                    <input type="text" class="form-control" value="<?= $client->getNomClient()?>" readonly>
                                </div>
                                <div class=" form-control col-sm-6">
                                    <label class="col-form-label">Prénom</label>
                                    <input type="text"  class="form-control" value="<?= $client->getPrenomClient()?>" readonly>
                                </div>
                                <div class="form-control col-sm-6">
                                    <label class="col-form-label">Numéro mesure</label>
                                    <input type="text" class="form-control" value="<?= $client->getNumeroMesure()?>" readonly>
                                </div>
                                <div class=" form-control col-sm-6">
                                    <label class="col-form-label">Type</label>
                                    <input type="text"  class="form-control" value="<?= $client->getTypeClient()?>" readonly>
                                </div>
                                <div class="form-control col-sm-6">
                                    <label class="col-form-label">Contact</label>
                                    <input type="text" class="form-control" value="<?= $client->getContactClient()?>" readonly>
                                </div>
                                <div class="form-control col-sm-6">
                                    <label class="col-form-label">Adresse</label>
                                    <input type="text"  class="form-control" value="<?= $client->getAdresseClient()?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <a href="<?= URL ?>client/info/<?= $client->getIdClient() ?>/mesure_pdf/<?= $mesure->getIdMesure() ?>" target="_blank">
                        <button class="btn btn-success btn-md btn-block m-1">Mesure <i class="icofont icofont-printer"></i></button>
                    </a>
                    <!-- Basic Form Inputs card start -->
                    <div class="card">
                        <div class="card-block">

                            <h4 class="sub-title">Info Mesures</h4>
                            <div class="form-group">
                                <div class="col-sm-4">
                                    Date dernière modification
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" value="<?= date("d-m-Y",strtotime($mesure->getModMesure()))?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label">Sexe</label>
                                        <input type="text" id="sexe" value="<?= $mesure->getSexeMesure() ?>" class="form-control " readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Epaule</label>
                                        <?php if (!empty($mesureolds)):?>
                                               <table class="table table-bordered">
                                                    <tr>
                                                        <?php foreach ($mesureolds as $m):
                                                            if ($m->getEpauleMesure() != $mesure->getEpauleMesure()):
                                                            ?>
                                                            <td><?=$m->getEpauleMesure()?></td>
                                                        <?php
                                                        endif;
                                                        endforeach;?>
                                                    </tr>
                                               </table>
                                        <?php endif; ?>
                                        <input type="text" id="epaule" value="<?= $mesure->getEpauleMesure() ?>" class="form-control " readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Largeur épaule</label>
                                        <?php if (!empty($mesureolds)):?>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <?php foreach ($mesureolds as $m):
                                                        if ($m->getLEpauleMesure() != $mesure->getLEpauleMesure()):
                                                            ?>
                                                            <td><?=$m->getLEpauleMesure()?></td>
                                                        <?php
                                                        endif;
                                                    endforeach;?>
                                                </tr>
                                            </table>
                                        <?php endif; ?>
                                        <input type="text" id="l_epaule" value="<?= $mesure->getLEpauleMesure() ?>"  class="form-control " readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Carrure</label>
                                        <?php if (!empty($mesureolds)):?>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <?php foreach ($mesureolds as $m):
                                                        if ($m->getCarrureMesure() != $mesure->getCarrureMesure()):
                                                            ?>
                                                            <td><?=$m->getCarrureMesure()?></td>
                                                        <?php
                                                        endif;
                                                    endforeach;?>
                                                </tr>
                                            </table>
                                        <?php endif; ?>
                                        <input type="text" id="carrure" value="<?= $mesure->getCarrureMesure() ?>" class="form-control " readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Poitrine</label>
                                        <?php if (!empty($mesureolds)):?>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <?php foreach ($mesureolds as $m):
                                                        if ($m->getPoitrineMesure() != $mesure->getPoitrineMesure()):
                                                            ?>
                                                            <td><?=$m->getPoitrineMesure()?></td>
                                                        <?php
                                                        endif;
                                                    endforeach;?>
                                                </tr>
                                            </table>
                                        <?php endif; ?>
                                        <input type="text" id="poitrine" value="<?= $mesure->getPoitrineMesure() ?>" class="form-control " readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Dos</label>
                                        <?php if (!empty($mesureolds)):?>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <?php foreach ($mesureolds as $m):
                                                        if ($m->getDosMesure() != $mesure->getDosMesure()):
                                                            ?>
                                                            <td><?=$m->getDosMesure()?></td>
                                                        <?php
                                                        endif;
                                                    endforeach;?>
                                                </tr>
                                            </table>
                                        <?php endif; ?>
                                        <input type="text" id="dos" value="<?= $mesure->getDosMesure() ?>" class="form-control " readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Tour de taille</label>
                                        <?php if (!empty($mesureolds)):?>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <?php foreach ($mesureolds as $m):
                                                        if ($m->getTTailleMesure() != $mesure->getTTailleMesure()):
                                                            ?>
                                                            <td><?=$m->getTTailleMesure()?></td>
                                                        <?php
                                                        endif;
                                                    endforeach;?>
                                                </tr>
                                            </table>
                                        <?php endif; ?>
                                        <input type="text" id="t_taille" value="<?= $mesure->getTTailleMesure() ?>" class="form-control " readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Ceinture</label>
                                        <?php if (!empty($mesureolds)):?>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <?php foreach ($mesureolds as $m):
                                                        if ($m->getCeintureMesure() != $mesure->getCeintureMesure()):
                                                            ?>
                                                            <td><?=$m->getCeintureMesure()?></td>
                                                        <?php
                                                        endif;
                                                    endforeach;?>
                                                </tr>
                                            </table>
                                        <?php endif; ?>
                                        <input type="text" id="ceinture" value="<?= $mesure->getCeintureMesure() ?>" class="form-control " readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Bassin</label>
                                        <?php if (!empty($mesureolds)):?>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <?php foreach ($mesureolds as $m):
                                                        if ($m->getBassinMesure() != $mesure->getBassinMesure()):
                                                            ?>
                                                            <td><?=$m->getBassinMesure()?></td>
                                                        <?php
                                                        endif;
                                                    endforeach;?>
                                                </tr>
                                            </table>
                                        <?php endif; ?>
                                        <input type="text" id="bassin" value="<?= $mesure->getBassinMesure() ?>" class="form-control " readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Cuisse</label>
                                        <?php if (!empty($mesureolds)):?>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <?php foreach ($mesureolds as $m):
                                                        if ($m->getCuisseMesure() != $mesure->getCuisseMesure()):
                                                            ?>
                                                            <td><?=$m->getCuisseMesure()?></td>
                                                        <?php
                                                        endif;
                                                    endforeach;?>
                                                </tr>
                                            </table>
                                        <?php endif; ?>
                                        <input type="text" id="cuisse" value="<?= $mesure->getCuisseMesure() ?>" class="form-control " readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Tour de Genoux</label>
                                        <?php if (!empty($mesureolds)):?>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <?php foreach ($mesureolds as $m):
                                                        if ($m->getTGenouMesure() != $mesure->getTGenouMesure()):
                                                            ?>
                                                            <td><?=$m->getTGenouMesure()?></td>
                                                        <?php
                                                        endif;
                                                    endforeach;?>
                                                </tr>
                                            </table>
                                        <?php endif; ?>
                                        <input type="text" id="t_genou" value="<?= $mesure->getTGenouMesure() ?>" class="form-control " readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Bas</label>
                                        <?php if (!empty($mesureolds)):?>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <?php foreach ($mesureolds as $m):
                                                        if ($m->getBasMesure() != $mesure->getBasMesure()):
                                                            ?>
                                                            <td><?=$m->getBasMesure()?></td>
                                                        <?php
                                                        endif;
                                                    endforeach;?>
                                                </tr>
                                            </table>
                                        <?php endif; ?>
                                        <input type="text" id="bas" value="<?= $mesure->getBasMesure() ?>"  class="form-control " readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Cole</label>
                                        <?php if (!empty($mesureolds)):?>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <?php foreach ($mesureolds as $m):
                                                        if ($m->getColeMesure() != $mesure->getColeMesure()):
                                                            ?>
                                                            <td><?=$m->getColeMesure()?></td>
                                                        <?php
                                                        endif;
                                                    endforeach;?>
                                                </tr>
                                            </table>
                                        <?php endif; ?>
                                        <input type="text" id="cole" value="<?= $mesure->getColeMesure() ?>" class="form-control " readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Tour de Manche</label>
                                        <?php if (!empty($mesureolds)):?>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <?php foreach ($mesureolds as $m):
                                                        if ($m->getTMancheMesure() != $mesure->getTMancheMesure()):
                                                            ?>
                                                            <td><?=$m->getTMancheMesure()?></td>
                                                        <?php
                                                        endif;
                                                    endforeach;?>
                                                </tr>
                                            </table>
                                        <?php endif; ?>
                                        <input type="text" id="t_manche" value="<?= $mesure->getTMancheMesure() ?>" class="form-control " readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Poignet</label>
                                        <?php if (!empty($mesureolds)):?>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <?php foreach ($mesureolds as $m):
                                                        if ($m->getPoignetMesure() != $mesure->getPoignetMesure()):
                                                            ?>
                                                            <td><?=$m->getPoignetMesure()?></td>
                                                        <?php
                                                        endif;
                                                    endforeach;?>
                                                </tr>
                                            </table>
                                        <?php endif; ?>
                                        <input type="text" id="poignet" value="<?= $mesure->getPoignetMesure() ?>" class="form-control " readonly>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" >Longueur Manche</label>
                                        <?php if (!empty($mesureolds)):?>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <?php foreach ($mesureolds as $m):
                                                        if ($m->getLMancheMesure() != $mesure->getLMancheMesure()):
                                                            ?>
                                                            <td><?=$m->getLMancheMesure()?></td>
                                                        <?php
                                                        endif;
                                                    endforeach;?>
                                                </tr>
                                            </table>
                                        <?php endif; ?>
                                        <input type="text" id="l_manche" value="<?= $mesure->getLMancheMesure() ?>" class="form-control " readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Longueur Taille</label>
                                        <?php if (!empty($mesureolds)):?>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <?php foreach ($mesureolds as $m):
                                                        if ($m->getLTailleMesure() != $mesure->getLTailleMesure()):
                                                            ?>
                                                            <td><?=$m->getLTailleMesure()?></td>
                                                        <?php
                                                        endif;
                                                    endforeach;?>
                                                </tr>
                                            </table>
                                        <?php endif; ?>
                                        <input type="text" id="l_taille" value="<?= $mesure->getLTailleMesure() ?>" class="form-control " readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Longueur Chemise</label>
                                        <?php if (!empty($mesureolds)):?>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <?php foreach ($mesureolds as $m):
                                                        if ($m->getLChemiseMesure() != $mesure->getLChemiseMesure()):
                                                            ?>
                                                            <td><?=$m->getLChemiseMesure()?></td>
                                                        <?php
                                                        endif;
                                                    endforeach;?>
                                                </tr>
                                            </table>
                                        <?php endif; ?>
                                        <input type="text" id="l_chemise" value="<?= $mesure->getLChemiseMesure() ?>" class="form-control " readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Longueur Chemise Arabe</label>
                                        <?php if (!empty($mesureolds)):?>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <?php foreach ($mesureolds as $m):
                                                        if ($m->getLChemiseAMesure() != $mesure->getLChemiseAMesure()):
                                                            ?>
                                                            <td><?=$m->getLChemiseAMesure()?></td>
                                                        <?php
                                                        endif;
                                                    endforeach;?>
                                                </tr>
                                            </table>
                                        <?php endif; ?>
                                        <input type="text" id="l_chemise_a" value="<?= $mesure->getLChemiseAMesure() ?>" class="form-control " readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Longueur Gilet</label>
                                        <?php if (!empty($mesureolds)):?>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <?php foreach ($mesureolds as $m):
                                                        if ($m->getLGiletMesure() != $mesure->getLGiletMesure()):
                                                            ?>
                                                            <td><?=$m->getLGiletMesure()?></td>
                                                        <?php
                                                        endif;
                                                    endforeach;?>
                                                </tr>
                                            </table>
                                        <?php endif; ?>
                                        <input type="text" id="l_gilet" value="<?= $mesure->getLGiletMesure() ?>" class="form-control " readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" >Longueur Veste</label>
                                        <?php if (!empty($mesureolds)):?>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <?php foreach ($mesureolds as $m):
                                                        if ($m->getLVesteMesure() != $mesure->getLVesteMesure()):
                                                            ?>
                                                            <td><?=$m->getLVesteMesure()?></td>
                                                        <?php
                                                        endif;
                                                    endforeach;?>
                                                </tr>
                                            </table>
                                        <?php endif; ?>
                                        <input type="text" id="l_veste" value="<?= $mesure->getLVesteMesure() ?>" class="form-control " readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Longueur Genoux</label>
                                        <?php if (!empty($mesureolds)):?>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <?php foreach ($mesureolds as $m):
                                                        if ($m->getLGenouMesure() != $mesure->getLGenouMesure()):
                                                            ?>
                                                            <td><?=$m->getLGenouMesure()?></td>
                                                        <?php
                                                        endif;
                                                    endforeach;?>
                                                </tr>
                                            </table>
                                        <?php endif; ?>
                                        <input type="text" id="l_genou" value="<?= $mesure->getLGenouMesure() ?>" class="form-control " readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Longueur Pantalon</label>
                                        <?php if (!empty($mesureolds)):?>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <?php foreach ($mesureolds as $m):
                                                        if ($m->getLPantalonMesure() != $mesure->getLPantalonMesure()):
                                                            ?>
                                                            <td><?=$m->getLPantalonMesure()?></td>
                                                        <?php
                                                        endif;
                                                    endforeach;?>
                                                </tr>
                                            </table>
                                        <?php endif; ?>
                                        <input type="text" id="l_pantalon" value="<?= $mesure->getLPantalonMesure() ?>" class="form-control " readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Longueur Pantacourt</label>
                                        <?php if (!empty($mesureolds)):?>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <?php foreach ($mesureolds as $m):
                                                        if ($m->getPantacourtMesure() != $mesure->getPantacourtMesure()):
                                                            ?>
                                                            <td><?=$m->getPantacourtMesure()?></td>
                                                        <?php
                                                        endif;
                                                    endforeach;?>
                                                </tr>
                                            </table>
                                        <?php endif; ?>
                                        <input type="text" id="pantacourt" value="<?= $mesure->getPantacourtMesure() ?>" class="form-control " readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Entre Jambe</label>
                                        <?php if (!empty($mesureolds)):?>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <?php foreach ($mesureolds as $m):
                                                        if ($m->getEJambeMesure() != $mesure->getEJambeMesure()):
                                                            ?>
                                                            <td><?=$m->getEJambeMesure()?></td>
                                                        <?php
                                                        endif;
                                                    endforeach;?>
                                                </tr>
                                            </table>
                                        <?php endif; ?>
                                        <input type="text" id="e_jambe" value="<?= $mesure->getEJambeMesure() ?>" class="form-control " readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Frappe</label>
                                        <?php if (!empty($mesureolds)):?>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <?php foreach ($mesureolds as $m):
                                                        if ($m->getFrappeMesure() != $mesure->getFrappeMesure()):
                                                            ?>
                                                            <td><?=$m->getFrappeMesure()?></td>
                                                        <?php
                                                        endif;
                                                    endforeach;?>
                                                </tr>
                                            </table>
                                        <?php endif; ?>
                                        <input type="text" id="frappe" value="<?= $mesure->getFrappeMesure() ?>" class="form-control " readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Tour de tête</label>
                                        <?php if (!empty($mesureolds)):?>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <?php foreach ($mesureolds as $m):
                                                        if ($m->getTTeteMesure() != $mesure->getTTeteMesure()):
                                                            ?>
                                                            <td><?=$m->getTTeteMesure()?></td>
                                                        <?php
                                                        endif;
                                                    endforeach;?>
                                                </tr>
                                            </table>
                                        <?php endif; ?>
                                        <input type="text" id="t_tete" value="<?= $mesure->getTTeteMesure() ?>" class="form-control " readonly>
                                    </div>
                                    <div class="form-group" id="ep">
                                        <label class="form-label">Ecart pince poitrine</label>
                                        <?php if (!empty($mesureolds)):?>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <?php foreach ($mesureolds as $m):
                                                        if ($m->getEPPoitrineMesure() != $mesure->getEPPoitrineMesure()):
                                                            ?>
                                                            <td><?=$m->getEPPoitrineMesure()?></td>
                                                        <?php
                                                        endif;
                                                    endforeach;?>
                                                </tr>
                                            </table>
                                        <?php endif; ?>
                                        <input type="text" id="e_p_poitrine" value="<?= $mesure->getEPPoitrineMesure() ?>" class="form-control " readonly>
                                    </div>
                                    <div class="form-group" id="l_ju">
                                        <label class="form-label" >Longueur Jupe</label>
                                        <?php if (!empty($mesureolds)):?>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <?php foreach ($mesureolds as $m):
                                                        if ($m->getLJupeMesure() != $mesure->getLJupeMesure()):
                                                            ?>
                                                            <td><?=$m->getLJupeMesure()?></td>
                                                        <?php
                                                        endif;
                                                    endforeach;?>
                                                </tr>
                                            </table>
                                        <?php endif; ?>
                                        <input type="text" id="l_jupe" value="<?= $mesure->getLJupeMesure() ?>" class="form-control " readonly>
                                    </div>
                                    <div class="form-group" id="l_ha">
                                        <label class="form-label" >Longueur Robe</label>
                                        <?php if (!empty($mesureolds)):?>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <?php foreach ($mesureolds as $m):
                                                        if ($m->getLRobeMesure() != $mesure->getLRobeMesure()):
                                                            ?>
                                                            <td><?=$m->getLRobeMesure()?></td>
                                                        <?php
                                                        endif;
                                                    endforeach;?>
                                                </tr>
                                            </table>
                                        <?php endif; ?>
                                        <input type="text" id="l_robe" value="<?= $mesure->getLRobeMesure() ?>" class="form-control " readonly>
                                    </div>
                                    <div class="form-group" id="l_po">
                                        <label class="form-label">Hauteur Poitrine</label>
                                        <?php if (!empty($mesureolds)):?>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <?php foreach ($mesureolds as $m):
                                                        if ($m->getLPoitrineMesure() != $mesure->getLPoitrineMesure()):
                                                            ?>
                                                            <td><?=$m->getLPoitrineMesure()?></td>
                                                        <?php
                                                        endif;
                                                    endforeach;?>
                                                </tr>
                                            </table>
                                        <?php endif; ?>
                                        <input type="text" id="l_poitrine" value="<?= $mesure->getLPoitrineMesure() ?>" class="form-control "readonly>
                                    </div>
                                    <div class="form-group" id="l_ha">
                                        <label class="form-label">Longueur haut</label>
                                        <?php if (!empty($mesureolds)):?>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <?php foreach ($mesureolds as $m):
                                                        if ($m->getLHautMesure() != $mesure->getLHautMesure()):
                                                            ?>
                                                            <td><?=$m->getLHautMesure()?></td>
                                                        <?php
                                                        endif;
                                                    endforeach;?>
                                                </tr>
                                            </table>
                                        <?php endif; ?>
                                        <input type="text" id="l_haut" value="<?= $mesure->getLHautMesure() ?>" class="form-control " readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page body end -->
    </div>
</div>
<?php $content = ob_get_clean();
$header = '';

ob_start();
?>
<script>
    $(document).ready(function () {
        $('#ep').hide();
        $('#l_ju').hide();
        $('#l_ro').hide();
        $('#l_po').hide();
        $('#l_ha').hide();

        $('#sexe').change(function (e) {
            var sex = e.target.value;
            if (sex == 'Masculin') {
                $('#ep').hide();
                $('#l_ju').hide();
                $('#l_ro').hide();
                $('#l_po').hide();
                $('#l_ha').hide();
            }
            if (sex == 'Feminin') {
                $('#ep').show();
                $('#l_ju').show();
                $('#l_ro').show();
                $('#l_po').show();
                $('#l_ha').show();
            }
        });
    });
</script>
<?php

$footer = ob_get_clean();
require "views/partials/template.php";
?>
