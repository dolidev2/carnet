<?php
ob_start();
?>
<link rel="stylesheet" type="text/css" href="<?= URL ?>public/bower_components/owl.carousel/css/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="<?= URL ?>public/bower_components/owl.carousel/css/owl.theme.default.css">
<?php
$header = ob_get_clean();
ob_start();
?>
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Detail sur le tissu du client</h4>

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
                    <li class="breadcrumb-item"><a href="<?= URL ?>client/info/<?= $client->getIdClient()?>">Tissu</a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?= URL ?>client/info/<?= $client->getIdClient()?>/tissu_modifier/<?= $tissu->getIdTissu() ?>">Infos</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page header end -->
        <!-- Page body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Basic Form Inputs card start -->
                    <div class="card">
                        <div class="card-block">
                            <h4 class="sub-title">Info Client</h4>
                            <div class="row">
                                <div class="form-control col-sm-6">
                                    <label class="col-form-label">Nom</label>
                                    <input type="text" class="form-control" value="<?= $client->getNomClient()?>" readonly>
                                </div>
                                <div class=" form-control col-sm-6">
                                    <label class="col-form-label">Prénom</label>
                                    <input type="text"  class="form-control" value="<?= $client->getPrenomClient()?>" readonly>
                                </div>
                                <div class="form-control col-sm-6">
                                    <label class="col-form-label">Numéro mesure</label>
                                    <input type="text" class="form-control" value="<?= $client->getNumeroMesure()?>" readonly>
                                </div>
                                <div class=" form-control col-sm-6">
                                    <label class="col-form-label">Type</label>
                                    <input type="text"  class="form-control" value="<?= $client->getTypeClient()?>" readonly>
                                </div>
                                <div class="form-control col-sm-6">
                                    <label class="col-form-label">Contact</label>
                                    <input type="text" class="form-control" value="<?= $client->getContactClient()?>" readonly>
                                </div>
                                <div class="form-control col-sm-6">
                                    <label class="col-form-label">Adresse</label>
                                    <input type="text"  class="form-control" value="<?= $client->getAdresseClient()?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <!-- Basic Form Inputs card start -->
                    <div class="card">
                        <div class="card-block">
                            <h4 class="sub-title"></h4>
                                <div class="form-group row">
                                    <div class="col-sm-12 col-md-12">
                                        <div class="row form-group">
                                            <label class="form-label">Nom</label>
                                            <input type="text" id="nom" name="nom" value="<?= $tissu->getNomTissu() ?>" class="form-control " readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="row form-group">
                                            <label class="form-label">Description</label>
                                            <input type="text" id="desc" name="desc" value="<?= $tissu->getDescTissu() ?>" class="form-control " readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="row form-group">
                                            <label class="form-label">Quantité</label>
                                            <input type="text" id="desc" name="desc" value="<?= $tissu->getQuantiteTissu() ?>" class="form-control " readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card">
                                            <div class="owl-carousel carousel-nav owl-theme">
                                                <?php
                                                $images = $this->tissuImageManager->getImagesTissu($tissu);
                                                if(!empty($images)): ?>
                                                    <?php foreach ($images as $img): ?>
                                                        <div>
                                                            <img class="d-block img-fluid w-300" height="200" src="<?= URL ?>public/image/tissu/<?= $nomDossierclient ?>/<?= $img->getImageTissu() ?>" >
                                                        </div>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <!-- Basic Form Inputs card end -->
                </div>
            </div>
        </div>
        <!-- Page body end -->
    </div>
</div>
<?php $content = ob_get_clean();
ob_start();
?>
<!-- owl carousel 2 js -->
<script type="text/javascript" src="<?= URL ?>public/bower_components/owl.carousel/js/owl.carousel.min.js"></script>
<script type="text/javascript" src="<?= URL ?>public/assets/js/owl-custom.js"></script>
<?php
$footer = ob_get_clean();
require "views/partials/template.php";
?>
