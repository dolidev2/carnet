<?php ob_start(); ?>

<div class="main-body">
    <div class="page-wrapper">
        <!-- Page header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Modifier le personnel</h4>

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
                    <li class="breadcrumb-item"><a href="<?= URL ?>personnel/modifier">Modifier</a>
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
                            <form method="post" action="<?= URL ?>personnel/mv/<?= $personnel->getIdPers() ?>" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nom</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="nom" value="<?= $personnel->getNomPers() ?>"  class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Prénom</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="prenom" value="<?= $personnel->getPrenomPers() ?>"  class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Contact</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="contact" value="<?= $personnel->getContactPers() ?>"  class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Adresse</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="adresse" value="<?= $personnel->getAdressePers() ?>"  class="form-control">
                                    </div>
                                </div>
                                <?php if ($_SESSION['agence_role'] =='Principale' && $_SESSION['role']=='admin'):?>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Agence</label>
                                    <div class="col-sm-10">
                                        <select name="agence" id="" class="form-control" required>
                                            <?php if(!empty($agences)):
                                                foreach($agences as $agence):
                                                    if ($agence->getIdAgence() == $personnel->getAgence()):
                                            ?>
                                                        <option value="<?= $agence->getIdAgence() ?>" selected><?= $agence->getNomAgence() ?></option>
                                                    <?php endif; ?>
                                                    <option value="<?= $agence->getIdAgence() ?>"><?= $agence->getNomAgence() ?></option>
                                            <?php
                                                    endforeach;
                                                endif;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Cnib recto</label>
                                    <div class="col-sm-5">
                                        <input type="file" name="recto"   class="form-control">
                                    </div>
                                    <div class="col-sm-5">
                                        <img src="<?= URL ?>public/image/personnel/<?= $personnel->getCnibRectoPers() ?>" alt="" class="img-thumbnail" width="200" height="200" data-toggle="modal" data-target="#large-<?= $personnel->getIdPers() ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Cnib verso</label>
                                    <div class="col-sm-5">
                                        <input type="file" name="verso" class="form-control">
                                        <input type="hidden" name="id_pers" value="<?= $personnel->getIdPers() ?>"  class="form-control">
                                    </div>
                                    <div class="col-sm-5">
                                        <img src="<?= URL ?>public/image/personnel/<?= $personnel->getCnibVersoPers() ?>" alt="" class="img-thumbnail" width="200" height="200" data-toggle="modal" data-target="#large-Modal<?= $personnel->getIdPers() ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 offset-sm-8">
                                        <button class="btn btn-outline-primary mb-2"  type="submit">Modifier</button>
                                        <button class="btn btn-outline-danger mb-2" type="reset">Annuler</button>
                                    </div>
                                </div>

                            </form>
                        <!-- Modal-->
                            <div class="modal fade" id="large-<?= $personnel->getIdPers() ?>" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <img src="<?= URL?>public/image/personnel/<?= $personnel->getCnibRectoPers() ?>" class="img-thumbnail" width="400" height="300">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Fermer</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- End Modal-->
                            <!-- Modal-->
                            <div class="modal fade" id="large-Modal<?= $personnel->getIdPers() ?>" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <img src="<?= URL?>public/image/personnel/<?= $personnel->getCnibRectoPers() ?>" class="img-thumbnail" width="400" height="300">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Fermer</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Modal-->
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
