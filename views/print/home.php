<?php
$header ='
<style>
li{
    font-size: 14px;
    line-height: 2.5;
}
li:hover{
    background-color: green;
    color: white;
    font-weight: bold;
    font-size: 20px;
}
</style>
';
ob_start();
?>
    <!--body-->
    <div class="main-body">
        <div class="page-wrapper">
            <!-- Page-header start -->
            <div class="page-header">
                <div class="page-header-title">
                    <span>Impression des documents</span>
                </div>
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="<?= URL ?>accueil">
                                <i class="icofont icofont-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item"><a href="<?= URL ?>personnel">Paramètre</a>
                        </li>
                        <li class="breadcrumb-item"><a href="<?= URL ?>personnel">Impression</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Page-header end -->
            <!-- Page-body start -->
            <div class="page-body">
                <div class="row">
                    <div class="col-sm-12">
                        <!-- Zero config.table start -->
                        <div class="card">
                            <div class="card-block">
                                <ul id=" print_css">
                                    <li data-toggle="modal" data-target="#chiffre-affaire-periode">
                                        Chiffre d'affaire par période et par agence
                                    </li>
                                    <li data-toggle="modal" data-target="#recap-client-periode">
                                        Récapitulatif des récettes/dépenses client par période
                                    </li>
                                    <li data-toggle="modal" data-target="#classement-client-periode">
                                        Classement client par période
                                    </li>
                                    <li data-toggle="modal" data-target="#recap-modele-periode">
                                            Classement modèle par période et par agence
                                    </li>
                                    <li data-toggle="modal" data-target="#recap-personnel-periode">
                                            Classement personnel par période
                                    </li>
                                    <li data-toggle="modal" data-target="#recap-tissu-periode">
                                            Récapitulatif des récettes/dépenses tissu acheté par période et par agence
                                    </li>
                                    <li data-toggle="modal" data-target="#liste-rdv-periode">
                                        Liste des RDV par période et par agence
                                    </li>
                                    <li data-toggle="modal" data-target="#liste-caisse-periode-agence">
                                        Liste des transactions caisse par période et par agence
                                    </li>
                                    <li data-toggle="modal" data-target="#liste-rdv-periode-agence">
                                        Liste des RDV réportés par période et par agence
                                    </li>
                                    <li data-toggle="modal" data-target="#liste-stock-periode-agence">
                                        Liste des transactions stock par période et par agence
                                    </li>
                                    <li data-toggle="modal" data-target="#liste-commande-client-periode">
                                        Liste des commandes client par période
                                    </li>
                                    <li data-toggle="modal" data-target="#liste-client-periode-agence">
                                        Liste des clients par période et par agence
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Zero config.table end -->
                        <!-- Default ordering table start -->
                    </div>
                </div>
                <!--Modal-->


                <!-- Chiffre d'affaire par periode   -->
                <div class="modal fade" id="chiffre-affaire-periode" tabindex="-1">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Chiffre d'affaire par periode</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body p-b-0">
                                <form action="<?= URL ?>impression/chiffreAffairePeriode" method="post">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="agence" class="form-control-label"> Agence</label>
                                            <select name="agence" id="agence" class="form-control">
                                                <?php foreach ($agences as $agence):?>
                                                    <option value="<?= $agence->getIdAgence() ?>"><?= $agence->getNomAgence() ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="debut" class="form-control-label"> Date de debut</label>
                                            <input type="date" name="dt_debut" class="form-control">
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="debut" class="form-control-label"> Date de fin</label>
                                            <input type="date" name="dt_fin" class="form-control">
                                        </div>
                                    </div>


                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Valider</button>
                                <button type="reset" class="btn btn-default" data-dismiss="modal">Annuler</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Chiffre d'affaire par periode   -->


                <!--  Récapitulatif des récettes/dépenses client par période   -->
                <div class="modal fade" id="recap-client-periode" tabindex="-1">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Récapitulatif des récettes/dépenses client par période</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body p-b-0">
                                <form action="<?= URL ?>impression/chiffreAffairePeriodeClient" method="post">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="client" class="form-control-label"> Client</label>
                                            <select name="client" id="client" class="form-control">
                                                <?php foreach ($clients as $client):?>
                                                    <option value="<?= $client->getIdClient() ?>"><?= $client->getNomClient().' <=> '.$client->getPrenomClient().' <=> '.$client->getContactClient().' <=> '.$client->getNumeroMesure() ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="debut" class="form-control-label"> Date de debut</label>
                                            <input type="date" name="dt_debut" class="form-control">
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="fin" class="form-control-label"> Date de fin</label>
                                            <input type="date" name="dt_fin" class="form-control">
                                        </div>
                                    </div>


                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Valider</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--  Récapitulatif des récettes/dépenses client par période   -->

                <!--   Récapitulatif des récettes/dépenses modèle par période   -->
                <div class="modal fade" id="recap-modele-periode" tabindex="-1">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Classement modèle par période</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body p-b-0">
                                <form action="<?= URL ?>impression/classementPeriodModele" method="post">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="agence" class="form-control-label"> Agence</label>
                                            <select name="agence" id="agence" class="form-control">
                                                <?php foreach ($agences as $agence):?>
                                                    <option value="<?= $agence->getIdAgence() ?>"><?= $agence->getNomAgence() ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="debut" class="form-control-label"> Date de debut</label>
                                            <input type="date" name="dt_debut" class="form-control">
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="fin" class="form-control-label"> Date de fin</label>
                                            <input type="date" name="dt_fin" class="form-control">
                                        </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Valider</button>
                                <button type="reset" class="btn btn-default" data-dismiss="modal">Annuler</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--  Récapitulatif des récettes/dépenses modèle par période   -->

                <!--   Récapitulatif des récettes/dépenses personnel par période   -->
                <div class="modal fade" id="recap-personnel-periode" tabindex="-1">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Classement personnel par période</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body p-b-0">
                                <form action="<?= URL ?>impression/classementPeriodPersonnel" method="post">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="agence" class="form-control-label"> Agence</label>
                                            <select name="agence" id="agence" class="form-control">
                                                <?php foreach ($agences as $agence):?>
                                                    <option value="<?= $agence->getIdAgence() ?>"><?= $agence->getNomAgence() ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="debut" class="form-control-label"> Date de debut</label>
                                            <input type="date" name="dt_debut" class="form-control">
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="fin" class="form-control-label"> Date de fin</label>
                                            <input type="date" name="dt_fin" class="form-control">
                                        </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Valider</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--  Récapitulatif des récettes/dépenses personnel par période   -->

                <!--   Classement des clients par période   -->
                <div class="modal fade" id="classement-client-periode" tabindex="-1">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Classement des clients par période</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body p-b-0">
                                <form action="<?= URL ?>impression/classementPeriodClient" method="post">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="agence" class="form-control-label"> Agence</label>
                                            <select name="agence" id="agence" class="form-control">
                                                <?php foreach ($agences as $agence):?>
                                                    <option value="<?= $agence->getIdAgence() ?>"><?= $agence->getNomAgence() ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="debut" class="form-control-label"> Date de debut</label>
                                            <input type="date" name="dt_debut" class="form-control">
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="fin" class="form-control-label"> Date de fin</label>
                                            <input type="date" name="dt_fin" class="form-control">
                                        </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Valider</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--  Classement des clients par période  -->

                <!--  Liste des RDV par période   -->
                <div class="modal fade" id="liste-rdv-periode" tabindex="-1">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Liste des RDV par période</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body p-b-0">
                                <form action="<?= URL ?>impression/rdvPeriod" method="post">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="agence" class="form-control-label"> Agence</label>
                                            <select name="agence" id="agence" class="form-control">
                                                <?php foreach ($agences as $agence):?>
                                                    <option value="<?= $agence->getIdAgence() ?>"><?= $agence->getNomAgence() ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="debut" class="form-control-label"> Date de debut</label>
                                            <input type="date" name="dt_debut" class="form-control">
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="fin" class="form-control-label"> Date de fin</label>
                                            <input type="date" name="dt_fin" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Valider</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--  Liste des RDV par période  -->

                <!--  Liste des RDV par période   -->
                <div class="modal fade" id="liste-caisse-periode-agence" tabindex="-1">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Liste des transactions caisse par période et par agence</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body p-b-0">
                                <form action="<?= URL ?>impression/caissePeriod" method="post">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="agence" class="form-control-label"> Agence</label>
                                            <select name="agence" id="agence" class="form-control">
                                                <?php foreach ($agences as $agence):?>
                                                    <option value="<?= $agence->getIdAgence() ?>"><?= $agence->getNomAgence() ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="debut" class="form-control-label"> Date de debut</label>
                                            <input type="date" name="dt_debut" class="form-control">
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="fin" class="form-control-label"> Date de fin</label>
                                            <input type="date" name="dt_fin" class="form-control">
                                        </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Valider</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--  Liste des transactions caisse par période et par agence  -->

                <!-- Récapitulatif des récettes/dépenses tissu acheté par période  -->
                <div class="modal fade" id="recap-tissu-periode" tabindex="-1">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Récapitulatif des récettes/dépenses tissu acheté par période</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body p-b-0">
                                <form action="<?= URL ?>impression/classementPeriodClientTissu" method="post">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="agence" class="form-control-label"> Agence</label>
                                            <select name="agence" id="agence" class="form-control">
                                                <?php foreach ($agences as $agence):?>
                                                    <option value="<?= $agence->getIdAgence() ?>"><?= $agence->getNomAgence() ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="debut" class="form-control-label"> Date de debut</label>
                                            <input type="date" name="dt_debut" class="form-control">
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="fin" class="form-control-label"> Date de fin</label>
                                            <input type="date" name="dt_fin" class="form-control">
                                        </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Valider</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Récapitulatif des récettes/dépenses tissu acheté par période    -->

                <!-- Liste des RDV réportés par période et par agence  -->
                <div class="modal fade" id="liste-rdv-periode-agence" tabindex="-1">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Liste des RDV réportés par période et par agence</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body p-b-0">
                                <form action="<?= URL ?>impression/rdvReportePeriod" method="post">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="agence" class="form-control-label"> Agence</label>
                                            <select name="agence" id="agence" class="form-control">
                                                <?php foreach ($agences as $agence):?>
                                                    <option value="<?= $agence->getIdAgence() ?>"><?= $agence->getNomAgence() ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="debut" class="form-control-label"> Date de debut</label>
                                            <input type="date" name="dt_debut" class="form-control">
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="fin" class="form-control-label"> Date de fin</label>
                                            <input type="date" name="dt_fin" class="form-control">
                                        </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Valider</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Liste des RDV réportés par période et par agence    -->

                <!-- Liste des transaction stock par période et par agence  -->
                <div class="modal fade" id="liste-stock-periode-agence" tabindex="-1">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Liste des transactions stock par période et par agence</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body p-b-0">
                                <form action="<?= URL ?>impression/listStockRessource" method="post">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <select name="agence" id="agence" class="form-control">
                                                <?php foreach ($agences as $agence):?>
                                                    <option value="<?= $agence->getIdAgence() ?>"><?= $agence->getNomAgence() ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="debut" class="form-control-label"> Date de debut</label>
                                            <input type="date" name="dt_debut" class="form-control">
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="fin" class="form-control-label"> Date de fin</label>
                                            <input type="date" name="dt_fin" class="form-control">
                                        </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Valider</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Liste des transaction stock par période et par agence   -->

                <!-- Liste des commandes client par période -->
                <div class="modal fade" id="liste-commande-client-periode" tabindex="-1">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Liste des commandes client par période</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body p-b-0">
                                <form action="<?= URL ?>impression/commandeClientPeriod" method="post">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="ressource" class="form-control-label">Client</label>
                                            <select name="client" id="client" class="form-control">
                                                <?php foreach ($clients as $client):?>
                                                    <option value="<?= $client->getIdClient() ?>"><?= $client->getNomClient().' <=> '.$client->getPrenomClient().' <=> '.$client->getNumeroMesure() ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="debut" class="form-control-label"> Date de debut</label>
                                            <input type="date" name="dt_debut" class="form-control">
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="fin" class="form-control-label"> Date de fin</label>
                                            <input type="date" name="dt_fin" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Valider</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Liste des commandes client par période   -->

                <!-- Liste des clients par période et par agence -->
                <div class="modal fade" id="liste-client-periode-agence" tabindex="-1">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Liste des client par période et par agence</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body p-b-0">
                                <form action="<?= URL ?>impression/listClientPeriodAgence" method="post">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="agence" class="form-control-label">Agence</label>
                                            <select name="agence" id="agence" class="form-control">
                                                <?php foreach ($agences as $agence):?>
                                                    <option value="<?= $agence->getIdAgence() ?>"><?= $agence->getNomAgence() ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="debut" class="form-control-label"> Date de debut</label>
                                            <input type="date" name="dt_debut" class="form-control">
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="fin" class="form-control-label"> Date de fin</label>
                                            <input type="date" name="dt_fin" class="form-control">
                                        </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Valider</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Liste des client par période et par agence   -->
                <!--End Modal-->

            </div>
            <!-- Page-body end -->
        </div>
    </div>
    <!--end Body-->
<?php $content = ob_get_clean() ;
$footer = '';
require "views/partials/template.php";
?>