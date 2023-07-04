<?php
ob_start();
$header ='';
?>
    <div class="main-body">
        <div class="page-wrapper">
            <!-- Page header start -->
            <div class="page-header">
                <div class="page-header-title">
                    <h4>Infos client</h4>
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
                        <li class="breadcrumb-item"><a href="<?= URL ?>client/modifier">Infos</a>
                        </li>
                        <li class="breadcrumb-item"><?= $clients->getNomClient() ?></li>
                        <li class="breadcrumb-item"><?= $clients->getPrenomClient() ?></li>
                    </ul>
                </div>
            </div>
            <!-- Page header end -->
            <!-- Page body start -->
            <div class="page-body">
                <div class="card">
                    <div class="card-block">
                        <form method="post"  action="<?= URL ?>client/info/<?= $client ?>/statistique_recette_annee ?>">
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
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12" style="min-height: 500px;">
                                <div id="chart_div2" ></div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12" style="min-height: 500px;">
                                <div id="chart_div" ></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
$content = ob_get_clean();
?>
<?php
ob_start();
?>
    <!--Google chart gstatic-->
    <script type="text/javascript" src="<?= URL ?>public/bower_components/google/gstatic_loader.js"></script>
    <!--<script type="text/javascript" src="--><?//= URL ?><!--public/chart/client/frequence_couture.js"></script>-->
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['<?= date("Y") ?>', "Chiffre d'affaire", 'Charge'],
                <?php foreach ($array_recette as $item): ?>
                ["<?= $item['mois'] ?>",  <?= $item['profit'] ?>,      <?= $item['charge'] ?>],
                <?php endforeach; ?>
            ]);

            var options = {
                title: "Recette/Dépense <?= date("Y") ?> ",
                curveType: 'function',
                legend: { position: 'bottom' }
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_div2'));

            chart.draw(data, options);
        }
    </script>
<?php if (isset($year) &&!empty($year)): ?>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['<?= date("Y") ?>', "Chiffre d'affaire", 'Charge'],
                <?php foreach ($data as $item): ?>
                ["<?= $item['mois'] ?>",  <?= $item['profit'] ?>,      <?= $item['charge'] ?>],
                <?php endforeach; ?>
            ]);

            var options = {
                title: 'Recette/Dépense <?= $year ?>',
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

