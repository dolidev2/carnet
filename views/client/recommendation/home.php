<?php ob_start();
?>
<style>
    /*arbre généalogique début*/
    .tree ul {
        padding-top: 20px;
        position: relative;
        transition: all 0.5s;
        -webkit-transition: all 0.5s;
        -moz-transition: all 0.5s;
    }
    .tree li {
        float: left;
        text-align: center;
        list-style-type: none;
        position: relative;
        padding: 20px 5px 0 5px;
        -webkit-transition: all 0.5s;
        -moz-transition: all 0.5s;
        transition: all 0.5s;
    }

    /*We will use ::before and ::after to draw the connectors*/

    .tree li::before, .tree li::after{
        content: '';
        position: absolute; top: 0; right: 50%;
        border-top: 1px solid #ccc;
        width: 50%; height: 20px;
    }
    .tree li::after{
        right: auto; left: 50%;
        border-left: 1px solid #ccc;
    }

    /*We need to remove left-right connectors from elements without
    any siblings*/
    .tree li:only-child::after, .tree li:only-child::before {
        display: none;
    }

    /*Remove space from the top of single children*/
    .tree li:only-child{ padding-top: 0;}

    /*Remove left connector from first child and
    right connector from last child*/
    .tree li:first-child::before, .tree li:last-child::after{
        border: 0 none;
    }
    /*Adding back the vertical connector to the last nodes*/
    .tree li:last-child::before{
        border-right: 1px solid #ccc;
        border-radius: 0 5px 0 0;
    }
    .tree li:first-child::after{
        border-radius: 5px 0 0 0;
    }

    /*Time to add downward connectors from parents*/
    .tree ul ul::before{
        content: '';
        position: absolute; top: 0; left: 50%;
        border-left: 1px solid #ccc;
        width: 0; height: 20px;
    }

    .tree li a{
        border: 1px solid #ccc;
        padding: 5px 10px;
        text-decoration: none;
        color: #666;
        font-family: arial, verdana, tahoma;
        font-size: 11px;
        display: inline-block;

        border-radius: 5px;

        -webkit-transition: all 0.5s;
        -moz-transition: all 0.5s;
        transition: all 0.5s;
    }

    /*Time for some hover effects*/
    /*We will apply the hover effect the the lineage of the element also*/
    .tree li a:hover, .tree li a:hover+ul li a {
        background: #c8e4f8; color: #000; border: 1px solid #94a0b4;
    }
    /*Connector styles on hover*/
    .tree li a:hover+ul li::after,
    .tree li a:hover+ul li::before,
    .tree li a:hover+ul::before,
    .tree li a:hover+ul ul::before{
        border-color:  #94a0b4;
    }

    /*arbre généalogique fin*/
</style>
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
                    <li class="breadcrumb-item"><a href="<?= URL ?>client/info/<?= $client->getIdClient()?>">Infos</a>
                    </li>
                    <li class="breadcrumb-item"><?= $client->getNomClient()?></li>
                    <li class="breadcrumb-item"><?= $client->getPrenomClient()?></li>
                </ul>
            </div>
        </div>
        <!-- Page header end -->
        <!-- Page body start -->
        <div class="page-body">
            <!-- Basic Form Inputs card start -->
            <div class="card">
                <div class="card-body">
                    <div class="contour">
                        <p><span class="titretexte1">Arbre généalogique :</span></p>
                        <?php if (!empty($parent)): ?>
                            <button class="btn btn-primary"><?= $parent->getNomClient().' '. $parent->getPrenomClient() ?></button>
                        <?php endif; ?>
                        <div class="tree">
                            <ul>
                                <li> <a href="#"><?= $client->getNomClient().' '.$client->getPrenomClient() ?></a>
                                    <ul>
                                        <?php if (!empty($enfants)): ?>
                                            <?php foreach ($enfants as $client): ?>
                                                <li>
                                                    <a href="#">
                                                        <?php echo $client["enfant"]['nom'].' '.$client["enfant"]['prenom'] ?>
                                                    </a>
                                                    <?php if (!empty($client['petit'])): ?>
                                                        <ul>
                                                        <?php foreach ($client['petit'] as $petit): ?>
                                                            <li>
                                                                <a href="#">
                                                                    <?php echo $petit['nom'].' '.$petit['prenom'] ?>
                                                                </a>
                                                            </li>
                                                        <?php endforeach;?>
                                                        </ul>
                                                     <?php endif; ?>
                                                </li>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Basic Form Inputs card end -->
        </div>
    </div>
    <!-- Page body end -->
</div>
</div>


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


