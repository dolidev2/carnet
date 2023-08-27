<?php
$header = '';
ob_start(); ?>

<div class="main-body">
    <div class="page-wrapper">
        <!-- Page header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Infos client</h4>

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
                    <li class="breadcrumb-item"><a href="<?= URL ?>client/info/<?= $client->getIdClient() ?>">Commande</a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?= URL ?>client/commande/ajouter">Ajouter</a>
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
                                    <div class="col-sm-12 col-md-6">
                                        <input type="text" value="<?= $client->getNomClient() ?>" class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <input type="text" value="<?= $client->getPrenomClient() ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 col-md-6">
                                        <input type="text"  value="<?= $client->getContactClient() ?>" class="form-control"readonly >
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <input type="text"  value="<?= $client->getTypeClient() ?>" class="form-control"readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 col-md-6">
                                        <input type="text"  value="<?= $client->getAdresseClient() ?>" class="form-control" readonly>
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
                            <p>Choisir Modele Tissu du client</p>
                        </div>
                        <div class="card-block">
                            <button   class="btn btn-block m-2 add_field_button"><i class="ion-plus"></i></button>
                            <form id="form-add-cmd" method="post" action="<?= URL ?>client/info/<?= $client->getIdClient() ?>/commande_avca">
                                <div class="input_fields_wrap">
                                    <div class="form-group">
                                        <label class="form-label">Modele</label>
                                        <div class="">
                                            <input type="hidden" name="commande" value="<?= $commande->getIdCommande() ?>">
                                            <select name="modele[]"  id="modeles" class="form-control">
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
                                                if(!empty($compoModeles)):
                                                    foreach ($compoModeles as $modele):
                                                        ?>
                                                        <option value="<?= $modele->getIdModComp() ?>">
                                                            <?= $modele->getNomModComp().' <=> '. $modele->getDescModComp().' <=> '.$modele->getPrixModComp() ?>
                                                        </option>
                                                    <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Tissu</label>
                                        <div class="">
                                            <select name="tissu[]" id="tissus" class="form-control">
                                                <option value="">
                                                  ----------------------------
                                                </option>
                                                <?php
                                                if(!empty($tissus)):
                                                    foreach ($tissus as $tissu):
                                                        ?>
                                                        <option value="<?= $tissu->getIdTissu() ?>">
                                                            <?= $tissu->getNomTissu().' <=> '.$tissu->getDescTissu() ?>
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
                                            <input type="number"  name="quantite[]" id="qte" class="form-control" placeholder="Entrer la quantité">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Rémise</label>
                                        <div class="">
                                            <input type="number"  name="remise[]" id="remise" class="form-control" placeholder="Entrer la rémise ex.: 5000">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Prix</label>
                                        <div class="">
                                            <input type="number" class="form-control" name="prix[]"  id="prix"  readonly>
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
                            <label class="form-label">Modele</label>
                            <div class="">
                                <select name="modele[]"  id="modeles" class="form-control">
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
                                    if(!empty($compoModeles)):
                                        foreach ($compoModeles as $modele):
                                        ?>
                                            <option value="<?= $modele->getIdModComp() ?>">
                                                <?= $modele->getNomModComp().' <=> '. $modele->getDescModComp().' <=> '.$modele->getPrixModComp() ?>
                                            </option>
                                        <?php
                                        endforeach;
                                    endif;
                                    ?>
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Tissu</label>
                            <div class="">
                                <select name="tissu[]" id="tissus" class="form-control">
                                    <?php
                                    if(!empty($tissus)):
                                        foreach ($tissus as $tissu):
                                        ?>
                                          <option value="">
                                                ----------------------------
                                            </option>
                                            <option value="<?= $tissu->getIdTissu() ?>">
                                                <?= $tissu->getNomTissu().' <=> '.$tissu->getDescTissu() ?>
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
                                <input type="number"  name="quantite[]" id="qte" class="form-control" placeholder="Entrer la quantité">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Rémise</label>
                            <div class="">
                                <input type="number"  name="remise[]" id="remise" class="form-control" placeholder="Entrer la rémise ex.: 5000">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Prix</label>
                            <div class="">
                                <input type="number" class="form-control" name="prix[]" id="prix"  readonly>
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
