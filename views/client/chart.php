<?php
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
                        <li class="breadcrumb-item"><a href="<?= URL ?>client/modifier">Infos</a>
                        </li>
                        <li class="breadcrumb-item">Nom</li>
                        <li class="breadcrumb-item">Prenoms</li>
                    </ul>
                </div>
            </div>
        <!-- Page header end -->
        <!-- Page body start -->
            <div class="page-body">
                <div class="card">
                    <div class="card-block">
                        <button class="btn btn-outline-primary btn-lg btn-block rounded-circle m-1" disabled>Frequence couture</button>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12" style="min-height: 200px;">
                                <div id="chart_div" ></div>
                            </div>
                        </div>

                        <button class="btn btn-outline-primary btn-lg btn-block rounded-circle m-1" disabled>Frequence modele</button>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div id="chart_div1" ></div>
                            </div>
                        </div>

                        <button class="btn btn-outline-primary btn-lg btn-block rounded-circle m-1" disabled>Recette/ depense</button>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div id="chart_div2" ></div>
                            </div>
                        </div>
                        <button class="btn btn-outline-primary btn-lg btn-block rounded-circle m-1" disabled>Liste des modeles</button>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="dt-responsive table-responsive">
                                    <table id="simpletable" class="table table-striped table-bordered nowrap">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Montant</th>
                                            <th>Description</th>
                                            <th>Date de RDV</th>
                                            <th>Statut</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>System Architect</td>
                                            <td>Edinburgh</td>
                                            <td>61Edinburgh</td>
                                            <td>2011/04/25</td>
                                            <td>$320,800</td>
                                            <td>
                                                <a href="">
                                                    <button class="btn btn-warning btn-md text-light"><i class="fa fa-money"></i></i></button>
                                                </a>
                                                <a href="">
                                                    <button class="btn btn-success btn-md text-light"><i class="icofont icofont-pencil-alt-5"></i></button>
                                                </a>
                                                <a href="">
                                                    <button class="btn btn-info btn-md"><i class="icofont icofont-plus-circle"></i></button>
                                                </a>
                                                <a href="">
                                                    <button class="btn btn-danger btn-md"><i class="icofont icofont-trash"></i></button>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Garrett Winters</td>
                                            <td>Accountant</td>
                                            <td>Tokyo</td>
                                            <td>63</td>
                                            <td>2011/07/25</td>
                                            <td>
                                                <a href="">
                                                    <button class="btn btn-warning btn-md text-light"><i class="fa fa-money"></i></i></button>
                                                </a>
                                                <a href="">
                                                    <button class="btn btn-success btn-md text-light"><i class="icofont icofont-pencil-alt-5"></i></button>
                                                </a>
                                                <a href="">
                                                    <button class="btn btn-info btn-md"><i class="icofont icofont-plus-circle"></i></button>
                                                </a>
                                                <a href="">
                                                    <button class="btn btn-danger btn-md"><i class="icofont icofont-trash"></i></button>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Ashton Cox</td>
                                            <td>Junior Technical Author</td>
                                            <td>San Francisco</td>
                                            <td>66</td>
                                            <td>2009/01/12</td>
                                            <td>
                                                <a href="">
                                                    <button class="btn btn-warning btn-md text-light"><i class="fa fa-money"></i></i></button>
                                                </a>
                                                <a href="">
                                                    <button class="btn btn-success btn-md text-light"><i class="icofont icofont-pencil-alt-5"></i></button>
                                                </a>
                                                <a href="">
                                                    <button class="btn btn-info btn-md"><i class="icofont icofont-plus-circle"></i></button>
                                                </a>
                                                <a href="">
                                                    <button class="btn btn-danger btn-md"><i class="icofont icofont-trash"></i></button>
                                                </a>
                                            </td>
                                        </tr>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Montant</th>
                                            <th>Description</th>
                                            <th>Date de RDV</th>
                                            <th>Statut</th>
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
    <script type="text/javascript" src="<?= URL ?>public/chart/client/frequence_couture.js">
    </script>
    <script type="text/javascript" src="<?= URL ?>public/chart/client/frequence_modele.js">
    </script>
    <script type="text/javascript" src="<?= URL ?>public/chart/client/recette_depense.js">
    </script>
<?php
$footer = ob_get_clean();
require "views/partials/template.php";
