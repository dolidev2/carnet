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
                                    <div class="col-sm-6">
                                        <input type="text" value="<?= $client->getNomClient() ?>" class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" value="<?= $client->getPrenomClient() ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <input type="text"  value="<?= $client->getContactClient() ?>" class="form-control"readonly >
                                    </div>
                                    <div class="col-sm-6">
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
                            <p>Créer une commande du client</p>
                        </div>
                        <div class="card-block">
                            <form id="form-add-commande">
                                <div class="form-group">
                                    <label class="form-label">Date de création</label>
                                    <div class="">
                                        <input type="date" class="form-control" id="date_commande" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Description</label>
                                    <div class="">
                                        <input type="text" class="form-control" id="desc_commande" value="<?=$numero ?>" readonly>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Date RDV</label>
                                    <div class="">
                                        <input type="date" class="form-control" id="rdv_commande" required>
                                        <input type="hidden" class="form-control" id="client" value="<?= $client->getIdClient() ?>">
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit">Créer</button>
                                <button class="btn btn-danger" type="reset">Annuler</button>
                            </form>
                        </div>
                    </div>
                    <!-- Basic Form Inputs card end -->
                </div>
            </div>
            <?php if (!empty($commandes)): ?>
                <div class="row">
                    <div class="col-sm-12">
                        <!-- Basic Form Inputs card start -->
                        <div class="card">
                            <div class="card-header">
                                <p>Choisir Modèle Tissu du client</p>
                            </div>
                            <div class="card-block">
                                <button   class="btn btn-block m-2 add_field_button"><i class="ion-plus"></i></button>
                                <form id="form-add-cmd" method="post" action="<?= URL ?>client/info/<?= $client->getIdClient() ?>/commande_avc">
                                    <div class="form-group">
                                        <label class="form-label">Commande</label>
                                        <div class="">
                                            <select name="commande" id="commande"  class="form-control">
                                                <?php
                                                if (!empty($commandes)):
                                                    foreach ($commandes as $commande):
                                                        ?>
                                                        <option value="<?= $commande->getIdCommande() ?>">
                                                            <?= $commande->getDescCommande().' <=> '.date("d-m-Y",strtotime($commande->getRdvCommande())) ?>
                                                        </option>
                                                    <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="input_fields_wrap">
                                        <div class="form-group">
                                            <label class="form-label">Modèle</label>
                                            <div class="">
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

                                        <div class="form-group">
                                            <label class="form-label">Tissu</label>
                                            <div class="">
                                                <select name="tissu[]" id="tissus" class="form-control" required>
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
                                                <input type="number"  name="quantite[]" id="qte" class="form-control" placeholder="Entrer la quantité" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Rémise</label>
                                            <div class="">
                                                <input type="number"  name="remise[]" id="remise" class="form-control" placeholder="Entrer la rémise ex.:5000">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Prix</label>
                                            <div class="">
                                                <input type="number" class="form-control" name="prix[]"  id="prix" readonly>
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
            <?php endif; ?>
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
        $('#form-add-commande').submit( function(e)
        {
            var creat = $('#date_commande').val();
            var desc = $('#desc_commande').val();
            var rdv= $('#rdv_commande').val();
            var client = $('#client').val();

            $.post(
                "<?= URL ?>client/info/<?= $client->getIdClient() ?>/commande_av",
                {
                    creat:creat, desc:desc, rdv:rdv, client:client
                },
                function(response)
                {
                    swal({
                        title: "Bravo",
                        text: "La commande a été ajoutée avec succès!",
                        icon: "success"
                    }).then(function() {
                        window.location ="<?= URL ?>client/info/<?= $client->getIdClient() ?>/commande_ajouter";
                    });
                });

            return false;
        });

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

                        <div class="form-group">
                            <label class="form-label">Tissu</label>
                            <div class="">
                                <select name="tissu[]" id="tissus" class="form-control" required>
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
                                <input type="number"  name="quantite[]" id="qte" class="form-control" placeholder="Entrer la quantité" required>
                            </div>
                        </div>
                          <div class="form-group">
                            <label class="form-label">Rémise</label>
                            <div class="">
                                <input type="number"  name="remise[]" id="remise" class="form-control" placeholder="Entrer la rémise ex.:5000">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Prix</label>
                            <div class="">
                                <input type="number" class="form-control" name="prix[]" id="prix" readonly>
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
