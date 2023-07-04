<?php ob_start(); ?>

<div class="main-body">
    <div class="page-wrapper">
        <!-- Page header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Modifier le client</h4>

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
                    <li class="breadcrumb-item"><a href="<?= URL ?>client/modifier">Modifier</a>
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
                            <form id="form-up-client">
                                <div class="form-group">
                                    <label class="form-label">Date d'arrivée</label>
                                    <div class="">
                                        <input type="date" id="date_client" value="<?= $client->getCreatClient() ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Nom</label>
                                    <div class="">
                                        <input type="text" id="nom_client" value="<?= $client->getNomClient() ?>" class="form-control"  pattern="[0-9a-zA-Z_- ]*">
                                    </div>
                                </div>
                                <div class="form-group" id="div_prenom">
                                    <label class="form-label">Prénoms</label>
                                    <div class="">
                                        <input type="text"  id="prenom_client" class="form-control" value="<?= $client->getPrenomClient() ?>"  pattern="[0-9a-zA-Z_- ]*">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Numéro de mesure</label>
                                    <div class="">
                                        <input type="text"  id="num_mesure" class="form-control" value="<?= $client->getNumeroMesure() ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Contact</label>
                                    <div class="">
                                        <input type="text" class="form-control" id="contact_client" value="<?= $client->getContactClient() ?>"  pattern="[0-9a-zA-Z_- ]*">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Adresse</label>
                                    <div class="">
                                        <input type="text" class="form-control" id="adresse_client" value="<?= $client->getAdresseClient() ?>" pattern="[0-9a-zA-Z_- ]*">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Type de client</label>
                                    <div class="">
                                        <select id="type_client" class="form-control">
                                            <option value="<?= $client->getTypeClient() ?>" selected><?= $client->getTypeClient() ?></option>
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
                                                <input type="text" class="form-control" id="bpostal_client" value="<?= $client->getBoitePostalClient() ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">N° IFU</label>
                                            <div class="">
                                                <input type="text" class="form-control" id="ifu_client"  value="<?= $client->getIfuClient() ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">N° RCCM</label>
                                            <div class="">
                                                <input type="text" class="form-control" id="rccm_client"  value="<?= $client->getRccmClient() ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Division fiscale</label>
                                            <div class="">
                                                <input type="text" class="form-control" id="division_client"  value="<?= $client->getDivisionFiscaleClient() ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Régime d'imposition</label>
                                            <div class="">
                                                <input type="text" class="form-control" id="regime_client" value="<?= $client->getRegimeImpositionClient() ?>">
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Recommandation</label>
                                    <div class="">
                                        <select  id="client" class="form-control">
                                            <option value="">------------------------------</option>
                                            <?php foreach ($clients as $clt): ?>
                                                <?php if ($client->getClient() != 0 && $client->getClient() == $clt->getIdClient()):?>
                                                    <option value="<?= $clt->getIdClient() ?>" selected>
                                                        <?= $clt->getNomClient().' <=> '.$clt->getPrenomClient().' <=> '.$clt->getContactClient() ?>
                                                    </option>
                                                <?php endif; ?>
                                                <option value="<?= $clt->getIdClient() ?>">
                                                    <?= $clt->getNomClient().' <=> '.$clt->getPrenomClient().' <=> '.$clt->getContactClient() ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <?php if ($_SESSION['agence_role'] =='Principale' && $_SESSION['role']=='admin'):?>
                                <div class="form-group">
                                    <label class="form-label">Agence</label>
                                    <div>
                                        <select  id="agence" class="form-control" required>
                                            <?php foreach ($agences as $agence): ?>
                                                <?php if($client->getAgence() == $agence->getIdAgence()): ?>
                                                    <option value="<?= $agence->getIdAgence() ?>" selected>
                                                        <?= $agence->getNomAgence().' <=> '.$agence->getAdresseAgence().' <=> '.$agence->getContactAgence() ?>
                                                    </option>
                                                <?php endif; ?>
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
                                        <button class="btn btn-outline-primary mb-2"  id="btn_submit" type="submit" >Modifier</button>
                                        <button class="btn btn-outline-danger mb-2" type="reset">Annuler</button>
                                    </div>
                                </div>
                                <input type="hidden" id="id_client" value="<?= $client->getIdClient() ?>">
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

ob_start();
?>
<script src="<?= URL ?>public/assets/js/cdn/sweetarlert.js"></script>
<script>
    $(document).ready(function (){
        $('#entreprise').hide();

        if($('#type_client').val()=='entreprise'){
            $('#div_prenom').hide();
            $('#entreprise').show();
        }
        //Hide or show
        $('#type_client').change(function (e){
            if(e.target.value == 'entreprise'){
                $('#entreprise').show();
                $('#div_prenom').hide();
            }else{
                $('#entreprise').hide();
                $('#div_prenom').show();
            }
        })
        $('#form-up-client').submit( function(e)
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
            var id = $('#id_client').val();

            $.post(
                '<?= URL ?>client/mv',
                {
                    creat:creat, nom:nom, prenom:prenom, contact:contact, adresse:adresse, client:client, type:type,
                    mesure:mesure, boite:boite, ifu:ifu, rccm:rccm, division:division, regime:regime, id:id
                },
                function(response)
                {
                    swal({
                        title: "Bravo",
                        text: "Client modifié avec succès!",
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
