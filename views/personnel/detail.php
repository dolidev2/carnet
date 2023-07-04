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
                        <li class="breadcrumb-item"><a href="<?= URL ?>personnel">Détail</a>
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
                        <div class="card">
                            <div class="card-block">
                                <form method="post"  action="<?= URL ?>personnel/periode/<?= $personnel->getIdPers() ?>">
                                    <div class="row mb-3">
                                        <h5  class="col-sm-4 offset-sm-4 form-label">Période du travail</h5>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 col-md-4">
                                            <div class="row form-group">
                                                <label class="col-sm-4 form-label">Date de début</label>
                                                <input type="date" id="nom" name="dt_debut" class="form-control col-sm-8">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <div class="row form-group">
                                                <label class="col-sm-4 form-label">Date de fin</label>
                                                <input type="date" id="nom" name="dt_fin" class="form-control col-sm-8">
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
                        <a href="<?= URL ?>personnel/avance/<?= $personnel->getIdPers() ?>"><button class="btn btn-primary mb-3">Avance</button></a>
                        <a href="<?= URL ?>personnel/paiement/<?= $personnel->getIdPers() ?>"><button class="btn btn-info mb-3">Paiement</button></a>
                        <a href="<?= URL ?>personnel/production/<?= $personnel->getIdPers() ?>"><button class="btn btn-warning mb-3">Production</button></a>
                        <div class="card">
                            <div class="card-block">
                                <div class="dt-responsive table-responsive">
                                    <table id="simpletable" class="table table-striped table-bordered nowrap">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Modèle</th>
                                            <th>Commande</th>
                                            <th>Type</th>
                                            <th>Côut</th>
                                            <th>Quantité</th>
                                            <th>Durée</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(!empty($programmes)): ?>
                                            <?php
                                                $i=1;
                                                foreach ($programmes as $programme):
                                                    $cout = ($programme['desc_prod']=='Montage')? $programme['cout_modele'] :$programme['cout_decoup_modele'];
                                                    $fin =  date_create($programme['mod_prod']);
                                                    $debut =  date_create($programme['creat_prod']);
                                                    $jour = date_diff($fin, $debut);
                                                    $nb = ( $jour->days != 0 )? $jour->days : 1;
                                                    $response = ($programme['statut_prod'] != 0)? $nb.' jours': 'En cours';
                                            ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= date("d-m-Y", strtotime($programme['creat_prod'])) ?></td>
                                                    <td><?= $programme['nom_modele'] ?></td>
                                                    <td>
                                                        <span><?= $programme['desc_commande'] ?></span> <br>
                                                        <span><?= $programme['nom_client'] ?></span><br>
                                                        <span><?= $programme['prenom_client'] ?></span><br>
                                                        <span><?= $programme['contact_client'] ?></span><br>
                                                    </td>
                                                    <td><?= $programme['desc_prod'] ?></td>
                                                    <td><?= $cout ?></td>
                                                    <td><?= $programme['quantite_prod'] ?></td>
                                                    <td><?= $response ?></td>
                                                    <td>
                                                        <a href="<?= URL ?>personnel/charge/<?=$programme['id_prod']  ?>">
                                                            <button class="btn btn-info btn-md"><i class="icofont icofont-plus-circle"></i></button>
                                                        </a>
                                                        <button class="btn btn-success btn-md text-light" data-toggle="modal" data-target="#mod-Modal<?= $programme['id_prod'] ?>"><i class="icofont icofont-pencil-alt-5"></i></button>
                                                        <?php if($_SESSION['role'] == 'super_admin'): ?>
                                                            <form class="d-inline" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer ?');" action="<?= URL ?>personnel/supprimer_production/<?= $programme['id_prod'] ?>" >
                                                                <button class="btn btn-danger btn-md"><i class="icofont icofont-trash"></i></button>
                                                            </form>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                    <!--Modal Modifier-->
                                                    <div class="modal fade" id="mod-Modal<?= $programme['id_prod'] ?>" tabindex="-1" role="dialog">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Modifier infos Production</h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="post" action="<?= URL ?>personnel/modifier_production/<?= $programme['id_prod'] ?>">
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Type</label>
                                                                            <div class="col-sm-8">
                                                                                <select name="type_prod" id="type_prod" class="form-control">
                                                                                    <?php if ($programme['desc_prod'] == $montage): ?>
                                                                                        <option value="<?= $montage ?>" selected><?= $programme['desc_prod'] ?></option>
                                                                                    <?php else: ?>
                                                                                        <option value="<?= $decoup ?>" selected ><?= $programme['desc_prod'] ?></option>
                                                                                    <?php endif; ?>
                                                                                    <option value="<?= $montage ?>" ><?= $montage ?></option>
                                                                                    <option value="<?= $decoup ?>" ><?= $decoup ?></option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Quantité</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="number" step="0.01"  name="quantite_prod" id="quantite_prod" value="<?= $programme['quantite_prod']  ?>" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Prime Rendement</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="number"  step="0.01" name="rend_prod" id="rend_prod" value="<?= $programme['rend_prod']  ?>" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Somme</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="number"  step="0.01" name="somme_prod" id="somme_prod" value="<?= $programme['somme_prod']  ?>" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Statut Production</label>
                                                                            <div class="col-sm-8">
                                                                                <select name="statut_prod" id="statut_prod" class="form-control">
                                                                                    <?php if ($programme['statut_prod'] == $actif): ?>
                                                                                        <option value="<?= $actif ?>" selected>Terminé</option>
                                                                                    <?php else: ?>
                                                                                        <option value="<?= $inactif ?>" selected>En cours</option>
                                                                                    <?php endif; ?>
                                                                                    <option value="<?= $actif ?>" >Terminé</option>
                                                                                    <option value="<?= $inactif ?>" >En cours</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Date de début</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="date"  name="debut" id="debut" value="<?= $programme['creat_prod']  ?>" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Date de fin</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="date"  name="fin" id="fin" value="<?= $programme['mod_prod']  ?>" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <button type="submit" class="btn-block btn btn-primary waves-effect waves-light ">Modifier</button>
                                                                    </form>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Annuler</button>
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
                                            <th>Date</th>
                                            <th>Modèle</th>
                                            <th>Commande</th>
                                            <th>Type</th>
                                            <th>Côut</th>
                                            <th>Quantité</th>
                                            <th>Durée</th>
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
                <div class="row">
                    <div class="col-sm-12">
                        <a href="<?= URL ?>personnel/statistique/<?= $personnel->getIdPers() ?>">
                            <button class="btn btn-outline-primary btn-lg btn-block rounded-circle m-1">Recette/ depense</button>
                        </a>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div id="chart_div2" style="min-height:70vh;" ></div>
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
    <script type="text/javascript" src="<?= URL ?>public/bower_components/google/gstatic_loader.js"></script>
    <script type="text/javascript" >
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Mois', 'Production', 'Côut'],
                <?php foreach ($data as $dt): ?>
                ["<?= $dt['mois'] ?>", <?= $dt['prod'] ?>, <?= $dt['cout'] ?>],
                <?php endforeach; ?>
            ]);

            var options = {
                title: 'Capacité de travail',
                curveType: 'function',
                legend: { position: 'bottom' }
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_div2'));

            chart.draw(data, options);
        }
    </script>
<?php
$footer = ob_get_clean();
require "views/partials/template.php";
?>