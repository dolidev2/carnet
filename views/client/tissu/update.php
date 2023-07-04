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
                <h4>Modifier le tissu du client</h4>

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
                    <li class="breadcrumb-item"><a href="<?= URL ?>client/info/<?= $client->getIdClient()?>/tissu_modifier/<?= $tissu->getIdTissu() ?>">Modifier</a>
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
                            <form id="form-up-tissu" method="post" action="<?= URL ?>client/info/<?= $client->getIdClient() ?>/tissu_mv/<?= $tissu->getIdTissu() ?>" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <div class="row form-group">
                                            <label class="form-label">Nom</label>
                                            <input type="text" id="nom" name="nom" value="<?= $tissu->getNomTissu() ?>" class="form-control"  pattern="[0-9a-zA-Z_- ]*">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="row form-group">
                                            <label class="form-label">Description</label>
                                            <input type="text" id="desc" name="desc" value="<?= $tissu->getDescTissu() ?>" class="form-control"  >
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="row form-group">
                                            <label class="form-label">Quantité</label>
                                            <input type="number"  step="0.1" id="qte" name="qte" value="<?= $tissu->getQuantiteTissu() ?>" class="form-control"  >
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="row form-group">
                                            <label class="form-label">Prix</label>
                                            <input type="number" id="prix" name="prix" value="<?= $tissu->getPrixTissu() ?>" class="form-control"  >
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="row form-group">
                                            <label class="form-label">Commission</label>
                                            <input type="number" id="com" name="com" value="<?= $tissu->getCommissionTissu() ?>" class="form-control"  >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row form-group">
                                            <label class="form-label">Image</label>
                                            <input type="file" id="image" name="image[]" class="form-control"  multiple>
                                            <input type="hidden" id="client" name="client" value="<?= $client->getIdClient() ?>" class="form-control ">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <?php
                                        $images = $this->tissuImageManager->getImagesTissu($tissu);
                                        $color = (!empty($images))? 'primary': 'danger';
                                        ?>
                                        <button type="button" class="btn btn-<?= $color ?> waves-effect" data-toggle="modal" data-target="#large-Modal">Image</button>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-4 offset-sm-8">
                                        <button class="btn btn-outline-primary mb-2"  type="submit">Modifier</button>
                                        <button class="btn btn-outline-danger mb-2" type="reset">Annuler</button>
                                    </div>
                                </div>
                            </form>

                            <div class="modal fade" id="large-Modal" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Images du tissu</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="owl-carousel carousel-nav owl-theme">
                                                <?php if(!empty($images)): ?>
                                                    <?php foreach ($images as $img): ?>
                                                        <div>
                                                            <img class="d-block img-fluid w-300" height="200" src="<?= URL ?>public/image/tissu/<?= $nomDossierclient ?>/<?= $img->getImageTissu() ?>" >
                                                        </div>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Fermer</button>
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
