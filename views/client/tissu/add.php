<?php
$header = '';
ob_start();
?>
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Ajouter le tissu du client</h4>

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
                    <li class="breadcrumb-item"><a href="<?= URL ?>client/info/<?= $client->getIdClient()?>">Tissu</a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?= URL ?>client/info/<?= $client->getIdClient()?>/tissu_ajouter">Ajouter</a>
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
                            <h4 class="sub-title">Info Client</h4>
                            <div class="row">
                                <div class="form-control col-sm-6">
                                    <label class="col-form-label">Nom</label>
                                    <input type="text" class="form-control" value="<?= $client->getNomClient()?>" readonly>
                                </div>
                                <div class=" form-control col-sm-6">
                                    <label class="col-form-label">Prénom</label>
                                    <input type="text"  class="form-control" value="<?= $client->getPrenomClient()?>" readonly>
                                </div>
                                <div class="form-control col-sm-6">
                                    <label class="col-form-label">Numéro mesure</label>
                                    <input type="text" class="form-control" value="<?= $client->getNumeroMesure()?>" readonly>
                                </div>
                                <div class=" form-control col-sm-6">
                                    <label class="col-form-label">Type</label>
                                    <input type="text"  class="form-control" value="<?= $client->getTypeClient()?>" readonly>
                                </div>
                                <div class="form-control col-sm-6">
                                    <label class="col-form-label">Contact</label>
                                    <input type="text" class="form-control" value="<?= $client->getContactClient()?>" readonly>
                                </div>
                                <div class="form-control col-sm-6">
                                    <label class="col-form-label">Adresse</label>
                                    <input type="text"  class="form-control" value="<?= $client->getAdresseClient()?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <!-- Basic Form Inputs card start -->
                    <div class="card">
                        <div class="card-block">
                            <h4 class="sub-title"></h4>
                            <form id="form-add-tissu" method="post" action="<?= URL ?>client/info/<?= $client->getIdClient() ?>/tissu_av" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <div class="row form-group">
                                                <label class="form-label">Nom</label>
                                                <input type="text" id="nom" name="nom" class="form-control"  pattern="[0-9a-zA-Z_- ]*" placeholder="Entrez le nom du tissu">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <div class="row form-group">
                                                <label class="form-label">Description</label>
                                                <input type="text" id="desc" name="desc" class="form-control "  pattern="[0-9a-zA-Z_- ]*" placeholder="Entrez la description du tissu">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-5">
                                            <div class="row form-group">
                                                <label for="achat_tissu" class="form-label">Si achat de tissu, cochez la case</label>
                                                <input type="checkbox" class="form-control" id="check_achat">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div id="achat" class="form-group row">
                                    <div class="col-sm-12">
                                        <div class="row form-group">
                                            <label class="form-label">Quantité</label>
                                            <input type="number" step="0.1" id="qte" name="qte" class="form-control " placeholder="Entrez la quantité du tissu">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="row form-group">
                                            <label class="form-label">Prix</label>
                                            <input type="number" id="prix" name="prix" class="form-control" placeholder="Entrez le prix total du tissu">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="row form-group">
                                            <label class="form-label">Commission</label>
                                            <input type="number" id="com" name="com" class="form-control" placeholder="Entrez la commission sur le tissu">
                                        </div>
                                    </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="row form-group">
                                            <label class="form-label">Image</label>
                                            <input type="file" id="image" name="image[]" class="form-control " multiple>
                                            <input type="hidden" id="client" name="client" value="<?= $client->getIdClient() ?>" class="form-control col-sm-8">
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
<script>
    $(document).ready(function() {

        $('#achat').hide();
        $('input[id=check_achat]').click(function ()
        {
           var checkbox = this.checked;
           if(checkbox)
           {
                $('#achat').show();
           }else{
            $('#achat').hide();
           }
        });

    });
</script>
<?php
$footer = ob_get_clean();

require "views/partials/template.php";
?>
