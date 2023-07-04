<?php
$header = '';
ob_start();
?>
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Detail du modèle</h4>

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
                    <li class="breadcrumb-item"><a href="<?= URL ?>modele/detail/<?= $modele->getIdModele()?>">Détail</a>
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
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label">Nom</label>
                                        <input type="text" id="nom" name="nom" value="<?= $modele->getNomModele() ?>" class="form-control " readonly>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label">Description</label>
                                        <input type="text" id="desc" name="desc" value="<?= $modele->getDescModele() ?>" class="form-control " readonly>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label">Prix</label>
                                        <input type="text" id="desc" name="desc" value="<?= $modele->getPrixModele() ?>" class="form-control " readonly>
                                    </div>
                                </div>
                                <?php if(!empty($data_modele_comp)):?>
                                <div class="col-sm-12">
                                    <fieldset id="comp">
                                        <legend>Composition du modèle</legend>
                                        <?php
                                        foreach ($data_modele_comp as $comp):
                                            ?>
                                            <div class="form-group">
                                                <label class="form-label">Modele</label>
                                                <input type="text" value="  <?= $comp->getNomModele().' <=> '. $comp->getDescModele().' <=> '.$modele->getPrixModele() ?>" class="form-control" readonly>
                                            </div>
                                        <?php endforeach;?>
                                    </fieldset>
                                </div>
                                <?php endif;?>

                                <?php if (empty($data_modele_comp)): ?>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label">Côut montage</label>
                                        <input type="text" id="desc" name="desc" value="<?= $modele->getCoutModele() ?>" class="form-control " readonly>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label">Côut découpage</label>
                                        <input type="text" id="desc" name="desc" value="<?= $modele->getCoutDecoupModele() ?>" class="form-control " readonly>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Recto</label>
                                        <img src="<?= URL ?>/public/image/modele/<?= $modele->getRectoModele() ?>" alt="" class="img-thumbnail" width="200" height="200">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Verso</label>
                                        <img src="<?= URL ?>/public/image/modele/<?= $modele->getVersoModele() ?>" alt="" class="img-thumbnail" width="200" height="200">
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
$header = '';
$footer = '';

require "views/partials/template.php";
?>
