<?php
$header = '';
ob_start(); ?>

<div class="main-body">
    <div class="page-wrapper">
        <!-- Page header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Infos Production</h4>

            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= URL ?>accueil">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?= URL ?>">Charge</a>
                    </li>

                    <li class="breadcrumb-item"><a href="<?= URL ?>">Ajouter</a>
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
                            <form>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="">Client</label>
                                        <input type="text" value="<?= $prodDetail[0]['nom_client'].' '.$prodDetail[0]['prenom_client'].' '.$prodDetail[0]['contact_client'] ?>" class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="">Commande</label>
                                        <input type="text" value="<?= $prodDetail[0]['desc_commande'] ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        <label for="">Nom du modèle</label>
                                        <input type="text"  value="<?= $prodDetail[0]['nom_modele'] ?>" class="form-control"readonly>

                                    </div>
                                    <div class="col-sm-4">
                                        <label for="">Côut du modèle</label>
                                        <input type="text"  value="<?= $prodDetail[0]['cout_modele'] ?>" class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="">Quantité</label>
                                        <input type="text"  value="<?= $prodDetail[0]['quantite_cmt'] ?>" class="form-control"readonly >
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Basic Form Inputs card end -->
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <!-- Basic Form Inputs card start -->
                    <div class="card">
                        <div class="card-header">
                            <p>Modifier les charges de la production</p>
                        </div>
                        <div class="card-block">
                            <form id="form-add-cmd" method="post" action="<?= URL ?>charge/mv/<?= $prodDetail[0]['id_prod'] ?>">
                                <?php if(isset($data) && !empty($data)): ?>
                                <?php foreach ($data as $dt): ?>
                                <div class="input_fields_wrap">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Ressource</label>
                                        <div class="col-sm-10">
                                            <input type="hidden" name="charge[]" value="<?= $dt['id'] ?>">
                                            <select name="ressource[]"  id="modeles" class="form-control">
                                                <option value="<?=$dt['id_res'] ?>">
                                                    <?=$dt['ressource'] ?>
                                                </option>
                                                <?php
                                                if(!empty($ressources)):
                                                    foreach ($ressources as $ressource):
                                                        ?>
                                                        <option value="<?= $ressource->getIdRes() ?>">
                                                            <?= $ressource->getNomRes().' <=> '. $ressource->getDescRes() ?>
                                                        </option>
                                                    <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Description</label>
                                        <div class="col-sm-10">
                                            <input type="text"  name="desc[]"  value="<?= $dt['desc'] ?>" class="form-control" placeholder="Entrer la description">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Prix</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" name="prix[]"  value="<?= $dt['prix'] ?>" id="prix" placeholder="Entrer le prix">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Quantité</label>
                                        <div class="col-sm-10">
                                            <input type="number" step="0.01" class="form-control" name="qte[]"  value="<?= $dt['qte'] ?>" id="prix">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <?php endforeach; ?>
                                <button class="btn btn-primary" type="submit">Valider</button>
                                <button class="btn btn-danger" type="reset">Annuler</button>
                                <?php endif; ?>
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
ob_start();
?>

<?php
$footer = ob_get_clean();
require "views/partials/template.php";
?>
