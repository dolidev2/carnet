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
                    <button class="btn btn-outline-info btn-lg" data-toggle="modal" data-target="#sign-in-modal">Ajouter </button>
                    <span>Liste des paiements</span>
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
                        <li class="breadcrumb-item"><a href="<?= URL ?>personnel/detail/<?= $personnel->getIdPers() ?>">Paiement</a>
                        </li>
                        <li class="breadcrumb-item"><a href="#"><?= $personnel->getNomPers() ?></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#"><?= $personnel->getPrenomPers() ?></a>
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
                                            <th>Date</th>
                                            <th>Date de début</th>
                                            <th>Date de fin</th>
                                            <th>Somme</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(!empty($paiements)): ?>
                                            <?php $i=1; foreach ($paiements as $paie):?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= date("d-m-Y", strtotime($paie->getCreatPersPaie())) ?></td>
                                                    <td><?= date("d-m-Y", strtotime($paie->getDebutPersPaie()))  ?></td>
                                                    <td><?= date("d-m-Y", strtotime($paie->getFinPersPaie())) ?></td>
                                                    <td><?= $paie->getSommePersPaie() ?></td>
                                                    <td>
                                                        <a href="<?= URL ?>personnel/pdf/<?= $paie->getPersonnel().'/'.$paie->getDebutPersPaie().'/'.$paie->getFinPersPaie().'/'.$paie->getIdPersPaie() ?>" target="_blank">
                                                            <button class="btn btn-info btn-md"><i class="icofont icofont-plus-circle"></i></button>
                                                        </a>
                                                        <?php if($_SESSION['agence_role']== 'Principale' && $_SESSION['role'] == 'admin'): ?>
                                                        <form class="d-inline" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer ?');" action="<?= URL ?>personnel/psv/<?= $paie->getIdPersPaie() ?>" >
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
                                            <th>Date</th>
                                            <th>Date de début</th>
                                            <th>Date de fin</th>
                                            <th>Somme</th>
                                            <th></th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Zero config.table end -->
                        <!-- Default ordering table start -->
                        <div class="modal fade" id="sign-in-modal" tabindex="-1">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Ajouter un paiement</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form id="form-add-pers-paie">
                                    <div class="modal-body p-b-0">
                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <div>
                                                    <label class="form-control-label">Date de début</label>
                                                    <input type="date" id="dt_debut" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <div>
                                                    <label class="form-control-label">Date de fin</label>
                                                    <input type="date" id="dt_fin" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Ajouter</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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
    <script src="<?= URL ?>public/assets/js/cdn/sweetarlert.js"></script>
    <script>
        $(document).ready(function (){
            $('#form-add-pers-paie').submit( function(e)
            {
                var somme = 0;
                var debut = $('#dt_debut').val();
                var fin = $('#dt_fin').val();

                $.post(
                    '<?= URL ?>personnel/pav/<?= $personnel->getIdPers()?>',
                    {
                        somme:somme, debut:debut, fin:fin
                    },
                    function(response)
                    {
                        window.location ="<?= URL ?>personnel/paiement/<?= $personnel->getIdPers() ?>";
                    });
                return false;
            });
        });

    </script>
<?php
$footer = ob_get_clean();
require "views/partials/template.php";
?>