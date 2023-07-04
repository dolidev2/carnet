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
                <a href="<?= URL ?>personnel/ajouter_production/<?= $personnel->getIdPers() ?>"><button class="btn btn-outline-info btn-lg">Ajouter <i class="fa fa-user-plus"></i></button></a>
                <a href="<?= URL ?>personnel/imprimer/<?= $personnel->getIdPers() ?>"><button class="btn btn-outline-dark btn-lg">Imprimer </button></a>
                <span>Capacité de production du personnel</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= URL ?>accueil">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?= URL ?>personnel">Personnel</a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?= URL ?>personnel">Production</a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?= URL ?>personnel"><?= $personnel->getNomPers() ?></a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?= URL ?>personnel"><?= $personnel->getPrenomPers() ?></a>
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
                                        <th>Modèle</th>
                                        <th>Quantité</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($modPers)): ?>
                                        <?php $i=1; foreach ($modPers as $mod):?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= $mod['nom_modele'] ?></td>
                                                <td><?= $mod['qte_mod_pers'] ?></td>
                                                <td>

                                                    <button class="btn btn-success btn-md text-light" data-toggle="modal" data-target="#large-<?= $mod['id_mod_pers'] ?>"><i class="icofont icofont-pencil-alt-5"></i></button>
                                                    <?php if($_SESSION['agence_role']== 'Principale' && $_SESSION['role'] == 'admin'): ?>
                                                    <form class="d-inline" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer ?');" action="<?= URL ?>personnel/svm/<?= $mod['id_mod_pers'] ?>" >
                                                        <button id="btn-delete-form" class="btn btn-danger btn-md" type="submit"><i class="icofont icofont-trash"></i></button>
                                                    </form>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>

                                            <!--Modal update-->
                                            <div class="modal fade" id="large-<?= $mod['id_mod_pers'] ?>" tabindex="-1" role="dialog">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h3>Modifier la capacité de production</h3>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= URL ?>personnel/mavm/<?= $mod['id_mod_pers'] ?>" method="post">
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div>
                                                                            <label class="form-control-label">Modèle</label>
                                                                            <select name="modele" id="" class="form-control" required>
                                                                                <?php if(!empty($modeles)):
                                                                                    foreach ($modeles as $modele):
                                                                                        if($modele->getIdModele() == $mod['modele']):
                                                                                ?>
                                                                                            <option value="<?= $modele->getIdModele() ?>" selected><?= $modele->getNomModele() ?></option>
                                                                                        <?php endif ?>
                                                                                        <option value="<?= $modele->getIdModele() ?>"><?= $modele->getNomModele() ?></option>
                                                                                <?php endforeach;
                                                                                endif; ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div>
                                                                            <label class="form-control-label">Quantité</label>
                                                                            <input type="number" step="0.01" name="qte_mod" id="" value="<?= $mod['qte_mod_pers'] ?>" class="form-control" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Modifier</button>
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--End Modal-->
                                        <?php $i++; endforeach; ?>
                                    <?php endif; ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Modèle</th>
                                        <th>Quantité</th>
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