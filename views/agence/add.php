<?php
$header = '';
ob_start();
?>
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Ajouter une agence</h4>

            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= URL ?>accueil">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?= URL ?>agence">Agence</a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?= URL ?>agence/ajouter">Ajouter</a>
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
                            <h4 class="sub-title">Ajouter une agence</h4>
                            <form id="form-add-agence">
                                <div class="form-group row">
                                    <div class="col-sm-6 col-md-6">
                                        <div class="row form-group">
                                            <label class="col-sm-4 form-label">Nom</label>
                                            <input type="text" id="nom" name="nom" class="form-control col-sm-8">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="row form-group">
                                            <label class="col-sm-4 form-label">Contact</label>
                                            <input type="text" id="contact" name="contact" class="form-control col-sm-8">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="row form-group">
                                            <label class="col-sm-4 form-label">Adresse</label>
                                            <input type="text" id="adresse" name="adresse" class="form-control col-sm-8">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="row form-group">
                                            <label class="col-sm-4 form-label">Boite postale</label>
                                            <input type="text" id="bp" name="bp" class="form-control col-sm-8">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="row form-group">
                                            <label class="col-sm-4 form-label">Numéro IFU</label>
                                            <input type="text" id="ifu" name="ifu" class="form-control col-sm-8">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="row form-group">
                                            <label class="col-sm-4 form-label">Numéro RCCM</label>
                                            <input type="text" id="rccm" name="rccm" class="form-control col-sm-8">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="row form-group">
                                            <label class="col-sm-4 form-label">Division Fiscale</label>
                                            <input type="text" id="df" name="df" class="form-control col-sm-8">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="row form-group">
                                            <label class="col-sm-4 form-label">Régime d'imposition</label>
                                            <input type="text" id="ri" name="ri" class="form-control col-sm-8">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="row form-group">
                                            <label class="col-sm-4 form-label">Email</label>
                                            <input type="email" id="email" name="email" class="form-control col-sm-8">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="row form-group">
                                            <label class="col-sm-4 form-label">Statut</label>
                                            <select id="statut" class="form-control col-sm-8">
                                                <option value="particulier">Principale</option>
                                                <option value="entreprise">Annexe</option>
                                            </select>
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
ob_start();
?>
<script src="<?= URL ?>public/assets/js/cdn/sweetarlert.js"></script>
<script>
    $(document).ready(function (){
        $('#form-add-agence').submit( function(e)
        {
            var nom = $('#nom').val();
            var contact = $('#contact').val();
            var adresse = $('#adresse').val();
            var email = $('#email').val();
            var bp = $('#bp').val();
            var df = $('#df').val();
            var ri = $('#ri').val();
            var ifu = $('#ifu').val();
            var rccm = $('#rccm').val();
            var statut = $('#statut').val();


            $.post(
                '<?= URL ?>agence/av',
                {
                    nom:nom, contact:contact, adresse:adresse, statut:statut,
                    email:email, bp:bp, df:df, ri:ri,ifu:ifu,rccm:rccm
                },
                function(response)
                {
                    swal({
                        title: "Bravo",
                        text: "Agence ajoutée avec succès!",
                        icon: "success"
                    }).then(function() {
                        window.location ="<?= URL ?>agence";
                    });
                });
            return false;
        });
    });
</script>
<?php

$footer =  ob_get_clean();

require "views/partials/template.php";
?>
