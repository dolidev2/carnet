<?php
    $header = '';
    ob_start();
?>
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Modifier le modèle</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= URL ?>accueil">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?= URL ?>modele">Modèle</a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?= URL ?>modele/modifier/<?=$modele->getIdModele() ?>">Modifier</a>
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
                            <h4 class="sub-title"></h4>
                            <form method="post" action="<?= URL ?>modele/mv/<?= $modele->getIdModele() ?>"
                                  enctype="multipart/form-data">
                                <div class="form-group">
                                    <div class="">
                                        <div class="form-group">
                                            <label class=" form-label">Nom</label>
                                            <input type="text" id="nom" name="nom"
                                                   value="<?=$modele->getNomModele() ?>"
                                                   class="form-control col-sm-8">
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="form-group">
                                            <label class=" form-label">Description</label>
                                            <input type="text" id="desc" name="desc"
                                                   value="<?= $modele->getDescModele() ?>"
                                                   class="form-control col-sm-8">
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="form-group">
                                            <label class=" form-label">Prix</label>
                                            <input type="number" id="prix" name="prix"
                                                   value="<?= $modele->getPrixModele() ?>"
                                                   class="form-control col-sm-8">
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="form-group">
                                            <label class=" form-label">Côut montage</label>
                                            <input type="number" id="cout" name="cout"
                                                   value="<?= $modele->getCoutModele() ?>"
                                                   class="form-control col-sm-8">
                                        </div>
                                    </div>
                                        <div class="">
                                            <div class="form-group">
                                                <label class=" form-label">Côut découpage</label>
                                                <input type="number" id="coutd" name="coutd"
                                                       value="<?=  $modele->getCoutDecoupModele() ?>"
                                                       class="form-control col-sm-8">
                                            </div>
                                        </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class=" form-label">Recto</label>
                                            <input type="file" id="recto" name="recto"
                                                   class="form-control col-sm-8">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <img src="<?= URL ?>/public/image/modele/<?= $modele->getRectoModele() ?>"
                                                     alt="" class="img-thumbnail" width="200" height="200">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class=" form-label">Verso</label>
                                            <input type="file" id="verso" name="verso"
                                                   class="form-control col-sm-8">
                                            <input type="hidden" id="modele" name="modele"
                                                   value="<?= $modele->getIdModele() ?>"
                                                   class="form-control col-sm-8">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <img src="<?= URL ?>/public/image/modele/<?= $modele->getVersoModele() ?>"
                                                     alt="" class="img-thumbnail" width="200" height="200">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class=" offset-sm-8">
                                        <button class="btn btn-outline-primary mb-2" type="submit">Modifier</button>
                                        <button class="btn btn-outline-danger mb-2" type="reset">Annuler</button>
                                    </div>
                                </div>
                            </form>
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
    $footer = '';

    require "views/partials/template.php";
?>
