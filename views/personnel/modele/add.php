<?php
$header = '';
ob_start(); ?>

<div class="main-body">
    <div class="page-wrapper">
        <!-- Page header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Infos personnel</h4>

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
                    <li class="breadcrumb-item"><a href="<?= URL ?>personnel/detail/<?= $personnel->getIdPers() ?>">Production</a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?= URL ?>personnel/ajouter_production">Ajouter</a>
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
                                        <input type="text" value="<?= $personnel->getNomPers() ?>" class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" value="<?= $personnel->getPrenomPers() ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <input type="text"  value="<?= $personnel->getContactPers() ?>" class="form-control"readonly >
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
                            <p>Capacité de production</p>
                        </div>
                        <div class="card-block">
                            <button   class="btn btn-block m-2 add_field_button"><i class="ion-plus"></i></button>
                            <form  method="post" action="<?= URL ?>personnel/avam/<?= $personnel->getIdPers() ?>">
                                <div class="input_fields_wrap">
                                    <div class="form-group">
                                        <label class="form-label">Modèle</label>
                                        <div class="">
                                            <select name="modele[]" id="modele"  class="form-control" required>
                                                <?php
                                                if (!empty($modeles)):
                                                    foreach ($modeles as $modele):
                                                        ?>
                                                        <option value="<?= $modele->getIdModele() ?>">
                                                            <?= $modele->getNomModele().' <=> '.$modele->getDescModele().' <=> '.$modele->getPrixModele() ?>
                                                        </option>
                                                    <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Quantité</label>
                                        <div class="">
                                            <input type="number" step="0.01" name="qte_mod[]" class="form-control" placeholder="Entrez la quantité" required>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit">Valider</button>
                                <button class="btn btn-danger" type="reset">Annuler</button>
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
<script src="<?= URL ?>public/assets/js/cdn/sweetarlert.js"></script>
<script>
    $(document).ready(function() {

        var max_fields      = 10; //maximum input boxes allowed
        var wrapper         = $(".input_fields_wrap"); //Fields wrapper
        var add_button      = $(".add_field_button"); //Add button ID
        var x = 1; //initlal text box count
        $(add_button).click(function(e){ //on add input button click
            e.preventDefault();
            if(x < max_fields){ //max input box allowed
                x++; //text box increment
                $(wrapper).append(
                    `<div>
                        <hr>
                        <div class="form-group">
                            <label class="form-label">Modèle</label>
                                <div class="">
                                    <select name="modele[]" id="modele"  class="form-control" required>
                                        <?php
                                            if (!empty($modeles)):
                                                foreach ($modeles as $modele):
                                        ?>
                                                    <option value="<?= $modele->getIdModele() ?>">
                                                        <?= $modele->getNomModele().' <=> '.$modele->getDescModele().' <=> '.$modele->getPrixModele() ?>
                                                    </option>
                                        <?php
                                                endforeach;
                                            endif;
                                        ?>
                                    </select>
                                </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Quantité</label>
                            <div class="">
                                <input type="number" name="qte_mod[]" class="form-control" placeholder="Entrez la quantité" required>
                            </div>
                        </div>
                        <button class="btn btn-danger remove_field"><i class="ion-trash-a"></i></button>
                    </div>
                    <hr>`
                ); //add input box
            }
        });
        $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent('div').remove(); x--;
        })
    });
</script>
<?php
$footer = ob_get_clean();
require "views/partials/template.php";
?>
