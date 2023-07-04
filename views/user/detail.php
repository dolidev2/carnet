


<?php
ob_start();
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
                <span>Liste des actions posées</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= URL ?>accueil">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?= URL ?>utilisateur">Utilisateur</a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?= URL ?>utilisateur/detail/<?= $user->getIdUser() ?>">Détail</a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?= URL ?>utilisateur/detail/<?= $user->getIdUser() ?>"><?= $user->getNomUser() ?></a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?= URL ?>utilisateur/detail/<?= $user->getIdUser() ?>"><?= $user->getPrenomUser() ?></a>
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
                                        <th>Description</th>
                                        <th>Action</th>
                                        <th>Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(!empty($audits)): ?>
                                        <?php $i=1; foreach ($audits as $audit):?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= $audit['desc_audit'] ?></td>
                                                <td>
                                                    <?php if ($audit['action_audit'] == 'Ajout'):  ?>
                                                        <button class="btn btn-success">Ajout</button>
                                                    <?php elseif ($audit['action_audit'] == 'Modification'): ?>
                                                        <button class="btn btn-warning">Modification</button>
                                                    <?php elseif ($audit['action_audit'] == 'Suppression'): ?>
                                                        <button class="btn btn-danger">Suppression</button>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= date("d-m-Y", strtotime($audit['creat_audit']))  ?></td>
                                            </tr>
                                            <?php $i++; endforeach; ?>
                                    <?php endif; ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                        <th>Date</th>
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
<?php
$content = ob_get_clean() ;

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


