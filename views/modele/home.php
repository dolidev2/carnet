<?php ob_start();
?>
    <!-- Data Table Css -->
    <link rel="stylesheet" type="text/css"
          href="<?= URL ?>public/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css"
          href="<?= URL ?>public/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">
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
                    <a href="<?= URL ?>modele/ajouter">
                        <button class="btn btn-outline-info btn-lg">Ajouter <i class="fa fa-user-plus"></i></button>
                    </a>
                    <span>Liste des modèles</span>
                </div>
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="<?= URL ?>accueil">
                                <i class="icofont icofont-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item"><a href="<?= URL ?>modele">Modèles</a>
                        </li>
                        <li class="breadcrumb-item"><a href="<?= URL ?>modele">Consulter</a>
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
                                            <th>Nom</th>
                                            <th>Description</th>
                                            <th>Prix</th>
                                            <th>Côut</th>
                                            <th>Recto</th>
                                            <th>Verso</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (!empty($data_modeles)): ?>
                                            <?php $i = 1;
                                            foreach ($data_modeles as $modele):
                                                $color = $modele['comp'] ? 'bg-success' : '';
                                                $detail = array(
                                                    'id' => $modele['id'],
                                                    'comp' => $modele['comp']
                                                );
                                                ?>
                                                <tr class="<?= $color ?>">
                                                    <td><?= $i ?></td>
                                                    <td><?= $modele['nom'] ?></td>
                                                    <td><?= $modele['desc'] ?></td>
                                                    <td><?= $modele['prix'] ?></td>
                                                    <td><?= $modele['cout'] ?></td>
                                                    <td>
                                                        <img src="<?= URL ?>/public/image/modele/<?= $modele['recto'] ?>"
                                                             alt="" width="100" height="100" class="img-thumbnail"
                                                             data-toggle="modal"
                                                             data-target="#large-<?= $modele['id'] . '' . $i ?>"/>
                                                    </td>
                                                    <td>
                                                        <img src="<?= URL ?>/public/image/modele/<?= $modele['verso'] ?>"
                                                             alt="" width="100" height="100" class="img-thumbnail"
                                                             data-toggle="modal"
                                                             data-target="#large-modal<?= 'a' . $modele['id'] . '' . $i ?>"/>
                                                    </td>
                                                    <td>
                                                        <a href="<?= URL ?>/modele/modifier/<?= $modele['id'] ?>">
                                                            <button class="btn btn-success btn-md text-light"><i
                                                                        class="icofont icofont-pencil-alt-5"></i>
                                                            </button>
                                                        </a>
                                                        <a href="<?= URL ?>modele/detail/<?=$modele['id'] ?>">
                                                            <button class="btn btn-info btn-md"><i
                                                                        class="icofont icofont-plus-circle"></i>
                                                            </button>
                                                        </a>
                                                        <?php if ($_SESSION['agence_role'] == 'Principale' && $_SESSION['role'] == 'super_admin'): ?>
                                                            <form class="d-inline" method="post"
                                                                  onsubmit="return confirm('Voulez-vous vraiment supprimer ?');"
                                                                  action="<?= URL ?>modele/sv/<?= $modele['id'] ?>">
                                                                <button id="btn-delete-form"
                                                                        class="btn btn-danger btn-md" type="submit"><i
                                                                            class="icofont icofont-trash"></i>
                                                                </button>
                                                            </form>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <!-- Modal -->
                                                <div class="modal fade" id="large-<?= $modele['id'] . '' . $i ?>"
                                                     tabindex="-1" role="dialog">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <img src="<?= URL ?>public/image/modele/<?= $modele['recto'] ?>"
                                                                     class="img-responsive" width="780px">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button"
                                                                        class="btn btn-default waves-effect "
                                                                        data-dismiss="modal">Fermer
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal  -->
                                                <div class="modal fade" id="large-<?= $modele['id'] . '' . $i ?>"
                                                     tabindex="-1" role="dialog">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <img src="<?= URL ?>public/image/modele/<?= $modele['recto'] ?>"
                                                                     class="img-responsive" width="780px">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button"
                                                                        class="btn btn-default waves-effect "
                                                                        data-dismiss="modal">Fermer
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade"
                                                     id="large-modal<?= 'a' . $modele['id'] . '' . $i ?>"
                                                     tabindex="-1" role="dialog">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <img src="<?= URL ?>public/image/modele/<?= $modele['verso'] ?>"
                                                                     class="img-responsive" width="780px">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button"
                                                                        class="btn btn-default waves-effect "
                                                                        data-dismiss="modal">Fermer
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php $i++; endforeach; ?>
                                        <?php endif; ?>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Nom</th>
                                            <th>Description</th>
                                            <th>Prix</th>
                                            <th>Côut</th>
                                            <th>Recto</th>
                                            <th>Verso</th>
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