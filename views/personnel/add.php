<?php ob_start(); ?>

<div class="main-body">
    <div class="page-wrapper">
        <!-- Page header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Ajouter un personnel</h4>
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
                    <li class="breadcrumb-item"><a href="<?= URL ?>personnel/ajouter">Ajouter</a>
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
                            <form method="post" action="<?= URL ?>personnel/av" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nom</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="nom" placeholder="Entrer le nom " class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Prénoms</label>
                                    <div class="col-sm-10">
                                        <input type="text"  name="prenom" class="form-control" placeholder="Entrer le prénom ">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Contact</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="contact" placeholder="Entrer le contact">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Adresse</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="adresse" placeholder="Entrer l'adresse">
                                    </div>
                                </div>
                                <?php if ($_SESSION['agence_role'] =='Principale' && $_SESSION['role']=='admin'):?>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Agence</label>
                                    <div class="col-sm-10">
                                        <select name="agence" id="" class="form-control" required>
                                            <?php if(!empty($agences)):
                                                foreach($agences as $agence):
                                           ?>
                                                    <option value="<?= $agence->getIdAgence() ?>"><?= $agence->getNomAgence() ?></option>
                                                <?php
                                                endforeach;
                                            endif;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <?php endif;?>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Cnib recto</label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control" name="recto" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Cnib verso</label>
                                    <div class="col-sm-10">
                                        <input type="file" name="verso" class="form-control">
                                        <input type="hidden" name="agence" value="<?= $_SESSION['agence'] ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 offset-sm-8">
                                        <button class="btn btn-outline-primary mb-2"  type="submit">Ajouter</button>
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
$header = '';
$footer = '';
require "views/partials/template.php";
?>
