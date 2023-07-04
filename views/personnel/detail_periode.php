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
                   <span>
                        Période du travail:
                        <?= date("d-m-Y",strtotime($debut))  ?> au
                        <?= date("d-m-Y",strtotime($fin))  ?>
                    </span>
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
                                <a href="<?= URL ?>personnel/pdf/<?= $personnel->getIdPers().'/'.$debut.'/'.$fin.'/' ?>" target="_blank">
                                    <button class="btn btn-success">Paiement</button>
                                </a>
                                <form method="post"  action="<?= URL ?>personnel/periode/<?= $personnel->getIdPers() ?>">
                                    <div class="row mb-3">
                                        <h5  class="col-sm-6 offset-sm-4 form-label">
                                            Période du travail
                                            <span><?= date("d-m-Y",strtotime($debut))  ?></span> au
                                            <span><?= date("d-m-Y",strtotime($fin))  ?></span>
                                        </h5>
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
                                            <th>Côut</th>
                                            <th>Quantité</th>
                                            <th>Durée</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(!empty($programmes) && $programmes != NULL): ?>
                                            <?php
                                                $i=1;
                                                foreach ($programmes as $programme):
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
                                                    <td><?= $programme['cout_modele'] ?></td>
                                                    <td><?= $programme['quantite_prod'] ?></td>
                                                    <td><?= $response ?>
                                                    </td>

                                                    <td>

                                                        <a href="<?= URL ?>personnel/charge/<?= $programme['id_prod'] ?>">
                                                            <button class="btn btn-info btn-md"><i class="icofont icofont-plus-circle"></i></button>
                                                        </a>

                                                    </td>
                                                </tr>
                                                <?php $i++; endforeach; ?>
                                        <?php endif; ?>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Modèle</th>
                                            <th>Commande</th>
                                            <th>Côut</th>
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
                        <button class="btn btn-outline-primary btn-lg btn-block rounded-circle m-1" disabled>Recette/ depense</button>
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