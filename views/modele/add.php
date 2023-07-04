<?php
$header = '';
ob_start();
?>
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Ajouter un modèle</h4>

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
                    <li class="breadcrumb-item"><a href="<?= URL ?>modele/ajouter">Ajouter</a>
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
                            <h4 class="sub-title">Ajouter un modèle</h4>
                            <form id="form-add-modele" method="post" action="<?= URL ?>modele/av" enctype="multipart/form-data">
                                <button   class="btn btn-block m-2 add_field_button"><i class="ion-plus"></i></button>
                                <div class="form-group row">
                                    <div class="col-sm-6 ">
                                        <div class="form-group">
                                            <label class="form-label">Nom</label>
                                            <input type="text" id="nom" name="nom" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 ">
                                        <div class="form-group">
                                            <label class="form-label">Description</label>
                                            <input type="text" id="desc" name="desc" class="form-control ">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 ">
                                        <div class="form-group">
                                            <label class="form-label">Prix</label>
                                            <input type="number" id="prix" name="prix" class="form-control ">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 " id="cout_m">
                                        <div class="form-group">
                                            <label class="form-label">Côut montage</label>
                                            <input type="number" id="cout" name="cout" class="form-control ">
                                        </div>
                                    </div>
                                    <div class="col-sm-6" id="cout_d">
                                        <div class="form-group">
                                            <label class="form-label">Côut découpage</label>
                                            <input type="number" id="coutd" name="coutd" class="form-control ">
                                        </div>
                                    </div>
                                </div>
                                <fieldset id="comp">
                                <div class="input_fields_wrap">

                                </div>
                                </fieldset>
                                <div class="form-group row">
                                    <div class="col-sm-12 ">
                                        <div class="form-group">
                                            <label class="form-label">Recto</label>
                                            <input type="file" id="recto" name="recto" class="form-control ">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 ">
                                        <div class="form-group">
                                            <label class="form-label">Verso</label>
                                            <input type="file" id="verso" name="verso" class="form-control ">
                                        </div>
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
?>
<?php
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
            // $('#comp').show();
            $('#cout_m').hide();
            $('#cout_d').hide();

            e.preventDefault();
            if(x < max_fields){ //max input box allowed
                x++; //text box increment
                $(wrapper).append(
                    `<div>
                       <legend>Composition du modèle</legend>
                        <hr>
                        <div class="form-group row">
                            <label class="form-label">Modele</label>
                            <div class="col-sm-12">
                                <select name="modele[]"  id="modeles" class="form-control" required>
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
                        <button class="btn btn-danger remove_field"><i class="ion-trash-a"></i></button>
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
