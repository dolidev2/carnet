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
                    <button class="btn btn-outline-info btn-lg" data-toggle="modal" data-target="#stock-Modal">Ajouter <i class="fa fa-user-plus"></i></button>
                    <a href="<?= URL ?>stock/periode">
                        <button class="btn btn-outline-success btn-lg">Période</button>
                    </a>
                    <span>Liste des entrées et sorties </span>
                </div>
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="<?= URL ?>accueil">
                                <i class="icofont icofont-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item"><a href="<?= URL ?>caisse">Paramètre</a>
                        </li>
                        <li class="breadcrumb-item"><a href="<?= URL ?>caisse">Caisse</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Page-header end -->
            <!-- Page-body start -->
            <div class="page-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-block">
                                <form method="post"  action="<?= URL ?>caisse/periode_av">
                                    <div class="row mb-3">
                                        <h5  class="col-sm-4 offset-sm-4 form-label">
                                            Période du programme
                                            <?php if (isset($debut) && isset($fin)): ?>
                                                <span><?= date("d-m-Y",strtotime($debut))  ?></span> au
                                                <span><?= date("d-m-Y",strtotime($fin))  ?></span>
                                            <?php endif; ?>
                                        </h5>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 col-md-4">
                                            <div class="row form-group">
                                                <label class="col-sm-4 form-label">Date de début</label>
                                                <input type="date" id="nom" name="dt_debut" class="form-control col-sm-8" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <div class="row form-group">
                                                <label class="col-sm-4 form-label">Date de fin</label>
                                                <input type="date" id="nom" name="dt_fin" class="form-control col-sm-8" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <div class="row form-group">
                                                <div class="col-sm-12">
                                                    <button class="btn btn-primary" type="submit">Valider</button>
                                                    <button class="btn btn-danger" type="reset">Annuler</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <!-- Zero config.table start -->
                        <div class="mb-1 col-sm-6" >
                            <?php if ($_SESSION['agence_role'] =='Principale' ):
                                if ( $_SESSION['role']=='super_admin')  :?>
                                    <button class="btn btn-primary" id="btn_entre" >Entrée</button>
                                <?php endif;
                                if($_SESSION['role'] == 'super_admin'): ?>
                                    <button class="btn btn-success mb-3 mt-3" id="btn_etat">Etat</button>
                                <?php endif;
                            else:
                                if ( $_SESSION['role']=='admin' || $_SESSION['role']=='super_admin')  :?>
                                    <button class="btn btn-primary" id="btn_entre" >Entrée</button>
                                    <button class="btn btn-success mb-3 mt-3" id="btn_etat">Etat</button>
                                <?php endif;
                            endif; ?>
                        </div>
                        <div class="card" id="table_etat">
                            <?php if ($_SESSION['agence_role'] =='Principale'):
                                if( isset($somme_entre) && !empty($somme_entre) && isset($somme_sorti) && !empty($somme_sorti) && $_SESSION['role'] == 'super_admin'): ?>
                                    <button class="btn m-1"><?= ($somme_entre - $somme_sorti) ?></button>
                                <?php endif;
                            else:
                                if ( $_SESSION['role']=='admin' ||
                                    $_SESSION['role']=='super_admin' && isset($somme_entre) && !empty($somme_entre) && isset($somme_sorti) &&
                                    !empty($somme_sorti))  :?>
                                    <button class="btn m-1"><?= ($somme_entre - $somme_sorti) ?></button>
                                <?php endif;
                            endif;
                            ?>
                            <h5>Liste des entrées/sorties</h5>

                            <div class="card-block">
                                <div class="dt-responsive table-responsive">
                                    <table id="simpletable" class="table table-striped table-bordered nowrap">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Type</th>
                                            <th>Somme</th>
                                            <th>Motif</th>
                                            <th>Date</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (isset($caisses) && !empty($caisses)): ?>
                                            <?php $i=1; foreach ($caisses as $caisse):?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td>
                                                        <?php if($caisse['type_caisse'] == 'entre'): ?>
                                                            <button class="btn btn-success">Entrée</button>
                                                        <?php else: ?>
                                                            <button class="btn btn-danger">Sortie</button>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= $caisse['somme_caisse'] ?></td>
                                                    <td><?= $caisse['desc_caisse'] ?></td>
                                                    <td><?= date("d-m-Y", strtotime($caisse['creat_caisse'])) ?></td>
                                                    <td>
                                                        <button class="btn btn-success btn-md text-light" data-toggle="modal" data-target="#update-btn-<?=$caisse['id_caisse']  ?>"><i class="icofont icofont-pencil-alt-5"></i></button>
                                                        <form class="d-inline" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer ?');" action="<?= URL ?>caisse/sv/<?=$caisse['id_caisse'] ?>" >
                                                            <button id="btn-delete-form" class="btn btn-danger btn-md" type="submit"><i class="icofont icofont-trash"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="update-btn-<?=$caisse['id_caisse']  ?>" tabindex="-1">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Ajouter une entrée/sortie</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body p-b-0">
                                                                <form id="form-up-caisse">
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <div>
                                                                                <label class="form-control-label">Somme</label>
                                                                                <input type="number" id="sommeup" value="<?=$caisse['somme_caisse']  ?>" class="form-control" placeholder="Entrez la somme ">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <div>
                                                                                <label class="form-control-label">Motif</label>
                                                                                <input type="text" id="descup" value="<?=$caisse['desc_caisse']  ?>" class="form-control" placeholder="Entrez le motif">
                                                                                <input type="hidden" id="idup" value="<?=$caisse['id_caisse']  ?>" >
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <div>
                                                                                <label class="form-control-label">Type</label>
                                                                                <select name="" id="typeup" class="form-control">
                                                                                    <?php if ($caisse['type_caisse'] == 'entre'): ?>
                                                                                        <option value="<?=$caisse['type_caisse']?>">Entrée</option>
                                                                                    <?php else: ?>
                                                                                        <option value="<?=$caisse['type_caisse']?>">Sortie</option>
                                                                                    <?php endif; ?>
                                                                                    <option value="entre">Entrée</option>
                                                                                    <option value="sortie">Sortie</option>
                                                                                </select>
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
                                                <?php $i++; endforeach; ?>
                                        <?php endif; ?>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Type</th>
                                            <th>Somme</th>
                                            <th>Motif</th>
                                            <th>Date</th>
                                            <th></th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Entre Table    -->
                        <div class="card" id="table_entre">
                            <?php if ($_SESSION['agence_role'] =='Principale'):
                                if( isset($somme_entre) && !empty($somme_entre) && $_SESSION['role'] == 'super_admin'): ?>
                                    <button class="btn m-1"><?= $somme_entre ?></button>
                                <?php endif;
                            else:
                                if ( $_SESSION['role']=='admin' || $_SESSION['role']=='super_admin' && isset($somme_entre) && !empty($somme_entre)) :?>
                                    <button class="btn m-1"><?= $somme_entre ?></button>
                                <?php endif;
                            endif;
                            ?>
                            <h5>Liste des entrées</h5>
                            <div class="card-block">
                                <div class="dt-responsive table-responsive">
                                    <table id="simpletable" class="table table-striped table-bordered nowrap">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Type</th>
                                            <th>Somme</th>
                                            <th>Motif</th>
                                            <th>Date</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (isset($entres) && !empty($entres)): ?>
                                            <?php $i=1; foreach ($entres as $caisse):?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td>
                                                        <?php if($caisse['type_caisse'] == 'entre'): ?>
                                                            <button class="btn btn-success">Entrée</button>
                                                        <?php else: ?>
                                                            <button class="btn btn-danger">Sortie</button>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= $caisse['somme_caisse'] ?></td>
                                                    <td><?= $caisse['desc_caisse'] ?></td>
                                                    <td><?= date("d-m-Y", strtotime($caisse['creat_caisse'])) ?></td>
                                                    <td>
                                                        <?php if($_SESSION['role'] == 'super_admin'): ?>
                                                        <form class="d-inline" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer ?');" action="<?= URL ?>caisse/sv/<?=$caisse['id_caisse'] ?>" >
                                                            <button id="btn-delete-form" class="btn btn-danger btn-md" type="submit"><i class="icofont icofont-trash"></i></button>
                                                        </form>
                                                        <?php endif;?>
                                                    </td>
                                                </tr>
                                                <?php $i++; endforeach; ?>
                                        <?php endif; ?>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Type</th>
                                            <th>Somme</th>
                                            <th>Motif</th>
                                            <th>Date</th>
                                            <th></th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- End Entre Table     -->
                        <!-- Sortie Table      -->
                        <div class="card" id="table_sortie">
                            <?php if ($_SESSION['agence_role'] =='Principale'):
                                if( isset($somme_sorti) && !empty($somme_sorti) && $_SESSION['role'] == 'super_admin'): ?>
                                    <button class="btn m-1"><?=$somme_sorti ?></button>
                                <?php endif;
                            else:
                                if ( $_SESSION['role']=='admin' || $_SESSION['role']=='super_admin' && isset($somme_sorti) && !empty($somme_sorti)) :?>
                                    <button class="btn m-1"><?=$somme_sorti ?></button>
                                <?php endif;
                            endif;
                            ?>
                            <h5>Liste des sorties</h5>
                            <div class="card-block">
                                <div class="dt-responsive table-responsive">
                                    <table id="simpletable" class="table table-striped table-bordered nowrap">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Type</th>
                                            <th>Somme</th>
                                            <th>Motif</th>
                                            <th>Date</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (isset($sorties) && !empty($sorties)): ?>
                                            <?php $i=1; foreach ($sorties as $caisse):?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td>
                                                        <?php if($caisse['type_caisse'] == 'entre'): ?>
                                                            <button class="btn btn-success">Entrée</button>
                                                        <?php else: ?>
                                                            <button class="btn btn-danger">Sortie</button>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= $caisse['somme_caisse'] ?></td>
                                                    <td><?= $caisse['desc_caisse'] ?></td>
                                                    <td><?= date("d-m-Y", strtotime($caisse['creat_caisse'])) ?></td>
                                                    <td>
                                                        <?php if($_SESSION['role'] == 'super_admin'): ?>
                                                        <form class="d-inline" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer ?');" action="<?= URL ?>caisse/sv/<?=$caisse['id_caisse']?>" >
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
                                            <th>Type</th>
                                            <th>Somme</th>
                                            <th>Motif</th>
                                            <th>Date</th>
                                            <th></th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- End Sorti Table Etat     -->
                        <!-- Default ordering table start -->
                    </div>
                    <!--Modal-->
                    <div class="modal fade" id="sign-in-modal" tabindex="-1">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ajouter une entrée/sortie</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body p-b-0">
                                    <form id="form-add-caisse">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div>
                                                    <label class="form-control-label">Somme</label>
                                                    <input type="number" id="somme" class="form-control" placeholder="Entrez la somme ">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div>
                                                    <label class="form-control-label">Motif</label>
                                                    <input type="text" id="desc" class="form-control" placeholder="Entrez le motif">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div>
                                                    <label class="form-control-label">Type</label>
                                                    <select name="" id="type" class="form-control">
                                                        <option value="entre">Entrée</option>
                                                        <option value="sortie">Sortie</option>
                                                    </select>
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
                    <!--End modal-->
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
            $('#table_entre').hide();
            $('#table_sortie').show();
            $('#table_etat').hide();
            document.getElementById("btn_entre").addEventListener("click", function (){
                $('#table_etat').hide();
                $('#table_sortie').hide();
                $('#table_entre').show();
            });
            document.getElementById("btn_sortie").addEventListener("click", function (){
                $('#table_etat').hide();
                $('#table_sortie').show();
                $('#table_entre').hide();
            });
            document.getElementById("btn_etat").addEventListener("click", function (){
                $('#table_etat').show();
                $('#table_sortie').hide();
                $('#table_entre').hide();
            });
            $('#form-add-caisse').submit( function(e)
            {
                var somme = $('#somme').val();
                var desc = $('#desc').val();
                var type = $('#type').val();

                $.post(
                    '<?= URL ?>caisse/av',
                    {
                        somme:somme, desc:desc, type:type
                    },
                    function(response)
                    {
                        swal({
                            title: "Bravo",
                            text: "Ligne de caisse ajoutée avec succès!",
                            icon: "success"
                        }).then(function() {
                            window.location ="<?= URL ?>caisse";
                        });
                    });
                return false;
            });

            $('#form-up-caisse').submit( function(e)
            {
                var somme = $('#sommeup').val();
                var desc = $('#descup').val();
                var type = $('#typeup').val();
                var id = $('#idup').val();

                $.post(
                    '<?= URL ?>caisse/mv',
                    {
                        somme:somme, desc:desc, type:type, id:id
                    },
                    function(response)
                    {
                        swal({
                            title: "Bravo",
                            text: "Ligne de caisse modifiée avec succès!",
                            icon: "success"
                        }).then(function() {
                            window.location ="<?= URL ?>caisse";
                        });
                    });
                return false;
            });
        });
    </script>

<?php
$footer = ob_get_clean();
require "views/partials/template.php";
?>