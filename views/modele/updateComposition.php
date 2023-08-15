<?php
    $header = '';
    ob_start();
?>
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Modifier le modèle composés</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= URL ?>accueil">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?= URL ?>modele">Modèle </a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?= URL ?>modele/modifier/<?= $modeleComposition->getIdModComp() ?>">Modifier</a>
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
                            <form method="post" action="<?= URL ?>modele/mv/<?= $modeleComposition->getIdModComp() ?>"
                                  enctype="multipart/form-data">
                                <button class="btn rounded bg-dark-primary btn-block m-2 add_field_button"><i class="ion-plus"></i></button>
                                <div class="form-group">
                                    <div class="form-group">
                                        <label class=" form-label">Nom</label>
                                        <input type="text" id="nom" name="nom"
                                               value="<?= $modeleComposition->getNomModComp() ?>"
                                               class="form-control col-sm-8">
                                    </div>
                                    <div class="form-group">
                                        <label class=" form-label">Description</label>
                                        <input type="text" id="desc" name="desc"
                                               value="<?= $modeleComposition->getDescModComp() ?>"
                                               class="form-control col-sm-8">
                                    </div>
                                    <div class="form-group">
                                        <label class=" form-label">Prix</label>
                                        <input type="number" id="prix" name="prix"
                                               value="<?=  $modeleComposition->getPrixModComp()  ?>"
                                               class="form-control col-sm-8">
                                    </div>
                                    <fieldset id="comp">
                                        <legend>Composition du modèle</legend>
                                        <div class="input_fields_wrap">

                                            <?php
                                            foreach ($CompoundModeles as $comp):
                                                ?>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label class="form-label">Modèle </label>
                                                        <div class="col-sm-12">
                                                            <select name="modeles[]" id="modeles"
                                                                    class="form-control" required>
                                                                <?php if (!empty($modeles)):
                                                                    foreach ($modeles as $modele):
                                                                        if ($comp['id_modele'] == $modele->getIdModele()):
                                                                            ?>
                                                                            <option value="<?= $modele->getIdModele() ?>"
                                                                                    selected>
                                                                                <?= $modele->getNomModele() . ' <=> ' . $modele->getDescModele() . ' <=> ' . $modele->getPrixModele() ?>
                                                                            </option>
                                                                        <?php endif; ?>
                                                                        <option value="<?= $modele->getIdModele() ?>">
                                                                            <?= $modele->getNomModele() . ' <=> ' . $modele->getDescModele() . ' <=> ' . $modele->getPrixModele() ?>
                                                                        </option>
                                                                    <?php
                                                                    endforeach;
                                                                endif;
                                                                ?>
                                                            </select>
                                                            <input type="hidden" name="lignes[]" value="<?= $comp['id_comp'] ?> "/>
                                                        </div>
                                                    </div>
                                                    <button class="btn mt-4 mb-4 btn-danger remove_field"><i class="ion-trash-a"></i></button>
                                                </div>

                                            <?php  endforeach; ?>
                                        </div>
                                    </fieldset>
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
                                                <img src="<?= URL ?>/public/image/modele/<?= $modeleComposition->getRectoModComp() ?>"
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
                                                   value="<?= $modeleComposition->getIdModComp() ?>"
                                                   class="form-control col-sm-8">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <img src="<?= URL ?>/public/image/modele/<?= $modeleComposition->getVersoModComp() ?>"
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
<?php
$content = ob_get_clean();
ob_start();
?>
<script>
    $(document).ready(function() {
        // $('#comp').hide();
        var max_fields      = 10; //maximum input boxes allowed
        var wrapper         = $(".input_fields_wrap"); //Fields wrapper
        var add_button      = $(".add_field_button"); //Add button ID
        var x = 1; //initlal text box count
        $(add_button).click(function(e){ //on add input button click

            e.preventDefault();
            if(x < max_fields){ //max input box allowed
                x++; //text box increment
                $(wrapper).append(
                    `<div class="row">
                        <div class="form-group ">
                            <label class="form-label">Modèle </label>
                            <div class="col-sm-12">
                                <select name="modeles_add[]"  id="modeles" class="form-control" required>
                                <?php
                    if(!empty($modeles)):
                    foreach ($modeles as $modele):
                    ?>
                                    <option value="<?= $modele->getIdModele() ?>">
                                        <?= $modele->getNomModele().' <=> '. $modele->getDescModele().' <=> '.$modele->getPrixModele() ?>
                                    </option>
                                <?php
                    endforeach;
                    endif;
                    ?>
                            </select>
                            </div>
                        </div>
                        <button class="btn mt-4 mb-4 btn-danger remove_field"><i class="ion-trash-a"></i></button>
                        <hr>
                    </div>`
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
