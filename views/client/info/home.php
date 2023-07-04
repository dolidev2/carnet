<?php ob_start();
?>
<!-- Data Table Css -->
<link rel="stylesheet" type="text/css" href="<?= URL ?>public/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="<?= URL ?>public/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">
<?php
$header = ob_get_clean();
    ob_start();
?>
<!--body-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <a href="<?= URL ?>client/ajouter"><button class="btn btn-outline-info btn-lg">Ajouter <i class="fa fa-user-plus"></i></button></a>
                <span>Liste des clients</span>
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
                    <li class="breadcrumb-item"><a href="<?= URL ?>client">Consulter</a>
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
                            <div class="dt-responsive table-responsive">
                                <table id="simpletable" class="table table-striped table-bordered nowrap">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date d'arrivée</th>
                                        <th>Nom</th>
                                        <th>Prénoms</th>
                                        <th>Contact</th>
                                        <th>Adresse</th>
                                        <th>Type</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (isset($clients)): ?>
                                        <?php $i=1; foreach ($clients as $client):?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= date("d-m-Y",strtotime($client->getCreatClient())) ?></td>
                                                <td><?= $client->getNomClient() ?></td>
                                                <td><?= $client->getPrenomClient() ?></td>
                                                <td><?= $client->getContactClient() ?></td>
                                                <td><?= $client->getAdresseClient() ?></td>
                                                <td><?= $client->getTypeClient() ?></td>
                                                <td>
                                                    <a href="<?= URL ?>/client/modifier/<?= $client->getIdClient() ?>">
                                                        <button class="btn btn-success btn-md text-light"><i class="icofont icofont-pencil-alt-5"></i></button>
                                                    </a>
                                                    <a href="<?= URL ?>client/info/<?=$client->getIdClient() ?>">
                                                        <button class="btn btn-info btn-md"><i class="icofont icofont-plus-circle"></i></button>
                                                    </a>
                                                    <?php if($_SESSION['role'] == 'super_admin'): ?>
                                                        <form class="d-inline" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer ?');" action="<?= URL ?>client/sv/<?= $client->getIdClient() ?>" >
                                                            <button id="btn-delete-form" class="btn btn-danger btn-md" type="submit"><i class="icofont icofont-trash"></i></button>
                                                        </form>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php $i++; endforeach; ?>
                                    <?php endif; ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Nom</th>
                                        <th>Prénoms</th>
                                        <th>Contact</th>
                                        <th>Adresse</th>
                                        <th>Type</th>
                                        <th></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Zero config.table end -->
                    <!-- Default ordering table start -->
                </div>
            </div>
        </div>
        <!-- Page-body end -->
    </div>
</div>
<!--end Body-->
<?php $content = ob_get_clean() ;

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