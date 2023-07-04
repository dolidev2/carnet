<?php ob_start(); ?>

<div class="main-body">
    <div class="page-wrapper">
        <!-- Page header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Ajouter un client</h4>

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
                    <li class="breadcrumb-item"><a href="<?= URL ?>client/ajouter">Ajouter</a>
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
                            <form id="form-add-client">
                                <div class="form-group">
                                    <label class="form-label">Date d'arrivée</label>
                                    <div class="">
                                        <input type="date" id="date_client" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Nom</label>
                                    <div class="">
                                        <input type="text" id="nom_client" placeholder="Entrer le nom du client" class="form-control" pattern="[0-9a-zA-Z_- ]*">
                                    </div>
                                </div>
                                <div class="form-group" id="div_prenom">
                                    <label class="form-label">Prénoms</label>
                                    <div class="">
                                        <input type="text"  id="prenom_client" class="form-control" placeholder="Entrer le prénom du client"  pattern="[0-9a-zA-Z_- ]*">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Numéro de mesure</label>
                                    <div class="">
                                        <input type="text"  id="num_mesure" value="<?= $numero ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Contact</label>
                                    <div class="">
                                        <input type="text" class="form-control" id="contact_client" placeholder="Entrer le contact du client"  pattern="[0-9a-zA-Z_- ]*">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Adresse</label>
                                    <div class="">
                                        <input type="text" class="form-control" id="adresse_client" placeholder="Entrer l'adresse du client"  pattern="[0-9a-zA-Z_- ]*" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Type de client</label>
                                    <div class="">
                                        <select id="type_client" class="form-control">
                                            <option value="particulier">Particulier</option>
                                            <option value="entreprise">Entreprise</option>
                                            <option value="revendeur">Revendeur</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="entreprise">
                                    <fieldset>
                                        <legend>
                                            Information sur l'entreprise
                                        </legend>
                                        <div class="form-group">
                                            <label class="form-label">Boite postale</label>
                                            <div class="">
                                                <input type="text" class="form-control" id="bpostal_client" placeholder="Entrez la boite postale">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">N° IFU</label>
                                            <div class="">
                                                <input type="text" class="form-control" id="ifu_client" placeholder="Entrez l'IFU">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">N° RCCM</label>
                                            <div class="">
                                                <input type="text" class="form-control" id="rccm_client" placeholder="Entrez le RCCM">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Division fiscale</label>
                                            <div class="">
                                                <input type="text" class="form-control" id="division_client" placeholder="Entrez la division fiscalen">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Régime d'imposition</label>
                                            <div class="">
                                                <input type="text" class="form-control" id="regime_client" placeholder="Entrez le régime  d'imposition">
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Recommandation</label>
                                    <div class="">
                                        <select  id="client" class="form-control">
                                            <option value="">------------------------------</option>
                                            <?php foreach ($clients as $client): ?>
                                                <option value="<?= $client->getIdClient() ?>">
                                                    <?= $client->getNomClient().' <=> '.$client->getPrenomClient().' <=> '.$client->getContactClient() ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <?php if ($_SESSION['agence_role'] =='Principale' && $_SESSION['role']=='admin' || $_SESSION['role']=='super_admin' ):?>
                                    <div class="form-group">
                                        <label class="form-label">Agence</label>
                                        <div class="">
                                            <select  id="agence" class="form-control" >
                                                <option value="">------------------------------</option>
                                                <?php foreach ($agences as $agence): ?>
                                                    <option value="<?= $agence->getIdAgence() ?>">
                                                        <?= $agence->getNomAgence().' <=> '.$agence->getAdresseAgence().' <=> '.$agence->getContactAgence() ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php else:?>
                                    <input type="hidden" value="<?=$_SESSION['agence'] ?>" id="agence">
                                <?php endif;?>
                                <div class="row">
                                    <div class="col-sm-4 offset-sm-8">
                                        <button class="btn btn-outline-primary mb-2" id="btn_submit"  type="submit">Ajouter</button>
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
$header = '';

ob_start();
?>
<script src="<?= URL ?>public/assets/js/cdn/sweetarlert.js"></script>
<script>
    $(document).ready(function (){
        $('#entreprise').hide();
        //Hide or show
        $('#type_client').change(function (e){
            if(e.target.value == 'entreprise'){
                $('#entreprise').show();
                $('#div_prenom').hide()
            }else{
                $('#entreprise').hide();
                $('#div_prenom').show()
            }
        })
        $('#form-add-client').submit( function(e)
        {
            var creat = $('#date_client').val();
            var nom = $('#nom_client').val();
            var prenom = $('#prenom_client').val();
            var contact = $('#contact_client').val();
            var adresse = $('#adresse_client').val();
            var client = $('#client').val();
            var type = $('#type_client').val();
            var boite = $('#bpostal_client').val();
            var ifu = $('#ifu_client').val();
            var rccm = $('#rccm_client').val();
            var division = $('#division_client').val();
            var regime = $('#regime_client').val();
            var mesure = $('#num_mesure').val();
            var agence = $('#agence').val();

            $.post(
                '<?= URL ?>client/av',
                {
                    creat:creat, nom:nom, prenom:prenom, contact:contact, adresse:adresse, client:client,
                    type:type, boite:boite, ifu:ifu, rccm:rccm, division:division, regime:regime, mesure:mesure,
                    agence:agence
                },
                function(response)
                {
                    swal({
                        title: "Bravo",
                        text: "Client ajouté avec succès!",
                        icon: "success"
                    }).then(function() {
                        window.location ="<?= URL ?>client";
                    });
                });
            $("#btn_submit").attr("disabled", true);
            return false;
        });
    });
</script>
<?php

$footer = ob_get_clean();
require "views/partials/template.php";
?>




