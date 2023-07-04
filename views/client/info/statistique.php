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
                        <li class="breadcrumb-item"><a href="<?= URL ?>client/info/<?= $client ?>">Infos</a>
                        </li>
                        <li class="breadcrumb-item"><?= $clients->getNomClient()?></li>
                        <li class="breadcrumb-item"><?= $clients->getPrenomClient()?></li>
                    </ul>
                </div>
            </div>
            <!-- Page header end -->
            <!-- Page body start -->
            <div class="page-body">
                <div class="card">
                    <div class="card-block">
                        <a href="<?= URL ?>client/info/<?= $client ?>/statistique_frequence">
                            <button class="btn btn-outline-primary btn-lg btn-block rounded-circle m-1" >Frequence couture</button>
                        </a>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12" style="min-height: 200px;">
                                <div id="chart_div" ></div>
                            </div>
                        </div>
<!--                        <button class="btn btn-outline-primary btn-lg btn-block rounded-circle m-1" disabled>Frequence modele</button>-->
<!--                        <div class="row">-->
<!--                            <div class="col-lg-12 col-md-12 col-sm-12">-->
<!--                                <div id="chart_div1" ></div>-->
<!--                            </div>-->
<!--                        </div>-->

                        <a href="<?= URL ?>client/info/<?= $client ?>/statistique_recette">
                            <button class="btn btn-outline-primary btn-lg btn-block rounded-circle m-1">Recette/ depense</button>
                        </a>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div id="chart_div2" ></div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="card">
                    <div class="card-block">
                        <a href="<?= URL ?>client/info/<?= $client ?>/statistique_modele">
                            <button class="btn btn-outline-primary btn-lg btn-block rounded-circle m-1" >Liste des modeles</button>
                        </a>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="dt-responsive table-responsive">
                                    <table id="simpletable" class="table table-striped table-bordered nowrap">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Modèle</th>
                                            <th>Profit</th>
                                            <th>Charge</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (!empty($liste_modele) && $liste_modele != NULL ): ?>
                                            <?php $i= 1; foreach ($liste_modele as $modele): ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td> <?= $modele['modele'] ?> </td>
                                                    <td> <?= $modele['profit'] ?> </td>
                                                    <td> <?= $modele['charge'] ?> </td>
                                                </tr>
                                            <?php $i++; endforeach; ?>
                                        <?php  endif; ?>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Modèle</th>
                                            <th>Profit</th>
                                            <th>Charge</th>
                                            <th></th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
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
<!-- data-table js -->
<script src="<?= URL ?>public/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= URL ?>public/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= URL ?>public/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= URL ?>public/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<!--Google chart gstatic-->
<script type="text/javascript" src="<?= URL ?>public/bower_components/google/gstatic_loader.js"></script>
<!--<script type="text/javascript" src="--><?//= URL ?><!--public/chart/client/frequence_couture.js"></script>-->
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ["Année ",  "Chiffre d'Affaire Client","Chiffre d'Affaire Entreprise"],
                <?php for ($i=0; $i < count($data); $i++): ?>
                    ['<?= $data[$i]['mois'] ?>',        <?= $data[$i]['montant'] ?>,  <?= $data[$i]['chiffre'] ?>],
                <?php endfor; ?>
            ]);

            var options = {
                title: 'Fréquence de Couture',
                curveType: 'function',
                legend: { position: 'top' }
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

            chart.draw(data, options);
        }
    </script>

    <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['<?= date("Y") ?>', "Chiffre d'affaire", 'Dépense'],
          <?php foreach ($array_recette as $item): ?>
            ["<?= $item['mois'] ?>",  <?= $item['profit'] ?>,      <?= $item['charge'] ?>],
            <?php endforeach; ?>
        ]);

        var options = {
            title: 'Recette/Dépense',
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


