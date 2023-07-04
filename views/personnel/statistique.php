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
                    <!--                    <a href="--><?//= URL ?><!--personnel/ajouter"><button class="btn btn-outline-info btn-lg">Ajouter <i class="fa fa-user-plus"></i></button></a>-->
                    <!--                    <span>Liste du personnels</span>-->
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
                                <form method="post"  action="<?= URL ?>personnel/statistque_annee/<?= $personnel->getIdPers() ?>">
                                    <div class="row mb-3">
                                        <h5  class="col-sm-4 offset-sm-4 form-label">Choisir l'année</h5>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 col-md-4">
                                            <div class="row form-group">
                                                <label class="col-sm-4 form-label">Année</label>
                                                <input type="number" min="1900" max="10000" step="1" value="<?=date("Y") ?>" name="dt_debut" class="form-control col-sm-8">
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
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <button class="btn btn-outline-primary btn-lg btn-block rounded-circle m-1">Recette/ depense <?= date("Y") ?></button>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div id="chart_div2" style="min-height:70vh;" ></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if(isset($year) && !empty($year)): ?>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <button class="btn btn-outline-primary btn-lg btn-block rounded-circle m-1">Recette/ depense  <?= $year ?></button>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div id="chart_div" style="min-height:70vh;" ></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

            </div>
            <!-- Page-body end -->
        </div>
    </div>
    <!--end Body-->
<?php $content = ob_get_clean() ;

ob_start();
?>
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
<?php if(isset($year) && !empty($year)): ?>
    <script type="text/javascript" >
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Mois', 'Production', 'Côut'],
                <?php foreach ($data_annee as $dt): ?>
                ["<?= $dt['mois'] ?>", <?= $dt['prod'] ?>, <?= $dt['cout'] ?>],
                <?php endforeach; ?>
            ]);

            var options = {
                title: 'Capacité de travail',
                curveType: 'function',
                legend: { position: 'bottom' }
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

            chart.draw(data, options);
        }
    </script>
<?php endif; ?>
<?php
$footer = ob_get_clean();
require "views/partials/template.php";
?>