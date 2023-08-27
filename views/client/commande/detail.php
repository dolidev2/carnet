<?php ob_start();
?>
<!-- Data Table Css -->
<link rel="stylesheet" type="text/css" href="<?= URL ?>public/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="<?= URL ?>public/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">
<?php
$header = ob_get_clean();
ob_start();
?>
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Détail de la commande</h4>
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
                    <li class="breadcrumb-item"><a href="<?= URL ?>client/info/<?= $client->getIdClient() ?>">Commande</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Détail</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page header end -->
        <!-- Page body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-md-6 col-sm-12">
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
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- Basic Form Inputs card start -->
                            <div class="card">
                                <div class="card-block">
                                    <h4 class="sub-title">Info Commande</h4>
                                    <div class="row">
                                        <div class="form-control col-sm-6">
                                            <label class="col-form-label">Description</label>
                                            <input type="text" class="form-control" value="<?= $commande->getDescCommande()?>" readonly>
                                        </div>
                                        <div class=" form-control col-sm-6">
                                            <label class="col-form-label">Date de création</label>
                                            <input type="text"  class="form-control" value="<?= date("d-m-Y", strtotime($commande->getCreatCommande())) ?>" readonly>
                                        </div>
                                        <div class="form-control col-sm-6">
                                            <label class="col-form-label">Date de RDV</label>
                                            <input type="text" class="form-control" value="<?= date("d-m-Y", strtotime($commande->getRdvCommande())) ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <!-- Basic Form Inputs card start -->
                    <a class="m-5" href="<?= URL ?>client/info/<?= $client->getIdClient() ?>/facture/<?=  $commande->getIdCommande() ?>" target="_blank">
                        <button class="btn btn-primary btn-block btn-lg">Facture</button>
                    </a>

                    <div class="card">
                        <div class="card-block">
                            <div class="table-responsive card-block">
                                <a href="<?= URL ?>client/info/<?= $client->getIdClient() ?>/commande_composition/<?=  $commande->getIdCommande() ?>" target="_blank">
                                    <button class="btn btn-info btn-inline">Composition</button>
                                </a>
                                <button class="btn btn-primary btn-inline" id="btn-affecter" data-toggle="modal" data-target="#report-Modal">Report</button>
                                <a href="<?= URL ?>client/info/<?= $client->getIdClient() ?>/commande_satisfaction/<?=  $commande->getIdCommande() ?>" target="_blank">
                                    <button class="btn btn-warning btn-inline">Satisfaction</button>
                                </a>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="row">#</th>
                                        <th>Modèle</th>
                                        <th>Tissu</th>
                                        <th>Statut</th>
                                        <th>Quantité</th>
                                        <th>Prix modèle</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($data)): ?>
                                        <?php $i=1; foreach ($data as $dt): ?>
                                        <tr>
                                            <th scope="row"><?= $i?></th>
                                            <td><?= $dt['modele_nom'] ?></td>
                                            <td><?= $dt['tissu'] ?></td>
                                            <td>
                                                <?php if ($dt['statut'] == 0): ?>
                                                    <button class="btn btn-success">En cours</button>
                                                <?php else: ?>
                                                   <button class="btn btn-danger">Terminé</button>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= $dt['qte'] ?></td>
                                            <td><?= $dt['modele_prix'] ?></td>
                                            <td><?= $dt['prix'] ?></td>
                                            <td>
                                                <a href="" target="_blank">
                                                    <button class="btn btn-success btn-md"><i class="icofont icofont-printer"></i></button>
                                                </a>
                                                <form class="d-inline" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer ?');" action="<?= URL ?>client/info/<?= $client->getIdClient() ?>/commande_svd/<?=  $commande->getIdCommande() ?>/<?=  $dt['id'] ?>" >
                                                    <button class="btn btn-danger btn-md"><i class="icofont icofont-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php $i++; endforeach; ?>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                                <!-- Modal     -->
                                <div class="modal fade" id="report-Modal" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Message de report de Rdv</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="<?= URL ?>client/info/<?= $client->getIdClient() ?>/commande_report/<?=  $commande->getIdCommande() ?>" method="get">
                                                    <div class="form-outline">
                                                        <label class="form-label" for="textAreaExample">Description</label>
                                                        <textarea class="form-control" id="textAreaExample1" rows="4" name="description"></textarea>
                                                    </div>
                                                    <div class="form-outline ">
                                                        <label class="col-sm-2 col-form-label">Date</label>
                                                        <input type="date" class="form-control" name="date" >
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button  class="btn btn-primary waves-effect " type="submit">Valider</button>
                                                <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Annuler</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!--  End Modal     -->
                            </div>
                        </div>
                    </div>
                    <!-- Basic Form Inputs card end -->
                </div>
            </div>
        </div>
        <!-- Page body end -->
    </div>
</div>
<?php $content = ob_get_clean();
ob_start();
?>
<!-- data-table js -->
<script src="<?= URL ?>public/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= URL ?>public/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= URL ?>public/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= URL ?>public/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<?php
$footer = ob_get_clean();
require "views/partials/template.php";
?>
