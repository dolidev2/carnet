<?php
$header = '';
ob_start();
?>
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Modifier le paiement</h4>
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
                    <li class="breadcrumb-item"><a href="<?= URL ?>client/info/<?= $client->getIdClient()?>">Commande</a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?= URL ?>client/info/<?= $client->getIdClient()?>/paiement_ajouter/<?= $commande->getIdCommande()?>">Paiement</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page header end -->
        <!-- Page body start -->
        <div class="page-body">
            <div class="row">
                    <div class=" col-md-4 col-sm-12">
                        <!-- Basic Form Inputs card start -->
                        <div class="card">
                            <div class="card-block">
                                <h4 class="sub-title">Info Client</h4>
                                <div class="row">
                                    <div class="form-control col-sm-12 col-md-6">
                                        <label class="col-form-label">Nom</label>
                                        <input type="text" class="form-control" value="<?= $client->getNomClient()?>" readonly>
                                    </div>
                                    <div class=" form-control col-sm-12 col-md-6">
                                        <label class="col-form-label">Prénom</label>
                                        <input type="text"  class="form-control" value="<?= $client->getPrenomClient()?>" readonly>
                                    </div>
                                    <div class="form-control col-sm-12 col-md-6">
                                        <label class="col-form-label">Numéro mesure</label>
                                        <input type="text" class="form-control" value="<?= $client->getNumeroMesure()?>" readonly>
                                    </div>
                                    <div class=" form-control col-sm-12 col-md-6">
                                        <label class="col-form-label">Type</label>
                                        <input type="text"  class="form-control" value="<?= $client->getTypeClient()?>" readonly>
                                    </div>
                                    <div class="form-control col-sm-12 col-md-6">
                                        <label class="col-form-label">Contact</label>
                                        <input type="text" class="form-control" value="<?= $client->getContactClient()?>" readonly>
                                    </div>
                                    <div class="form-control col-sm-12 col-md-6">
                                        <label class="col-form-label">Adresse</label>
                                        <input type="text"  class="form-control" value="<?= $client->getAdresseClient()?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12"">
                        <div class="row">
                            <div class="col-sm-12">
                            <!-- Basic Form Inputs card start -->
                                <div class="card">
                                    <div class="card-block">
                                        <h4 class="sub-title">Info Commande</h4>
                                        <div class="row">
                                            <div class="form-control col-sm-12 col-md-6">
                                                <label class="col-form-label">Description</label>
                                                <input type="text" class="form-control" value="<?= $commande->getDescCommande()?>" readonly>
                                            </div>
                                            <div class=" form-control col-sm-12 col-md-6">
                                                <label class="col-form-label">Date de création</label>
                                                <input type="text"  class="form-control" value="<?= date("d-m-Y",strtotime($commande->getCreatCommande())) ?>" readonly>
                                            </div>
                                            <div class="form-control col-sm-12 col-md-6">
                                                <label class="col-form-label">Date de RDV</label>
                                                <input type="text" class="form-control" value="<?= date("d-m-Y",strtotime($commande->getRdvCommande()))?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <!-- Basic Form Inputs card start -->
                                <div class="card">
                                    <div class="card-block">
                                        <h4 class="sub-title">Info Commande Articles</h4>
                                        <?php foreach ($data as $dt): ?>
                                            <div class="row">
                                                <div class=" form-control col-md-6 col-sm-12">
                                                    <label class="col-form-label">Modele</label>
                                                    <input type="text" class="form-control" value="<?= $dt['modele_nom'].' <=> '.$dt['modele_prix'] ?>" readonly>
                                                </div>
                                                <div class=" form-control col-md-6 col-sm-12">
                                                    <label class="col-form-label">Tissu</label>
                                                    <input type="text" class="form-control" value="<?= $dt['tissu']?>" readonly>
                                                </div>
                                            </div>
                                        <?php endforeach;
                                        if($somme == 0): ?>
                                            <button class="btn btn-danger btn-block mt-3 ">Soldé</button>
                                        <?php elseif($somme > 0): ?>
                                            <button class="btn btn-success btn-block mt-3 ">Reste: <?= $somme ?> FCFA</button>
                                        <?php else: ?>
                                            <button class="btn btn-danger btn-block mt-3 ">Avoir: <?= $somme ?> FCFA</button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php if($formAdd): ?>
            <?php else: ?>
            <div class="row">
                <div class="col-sm-12">
                    <!-- Basic Form Inputs card start -->
                    <div class="card">
                        <div class="card-block">
                            <h4 class="sub-title">Modifier le paiement</h4>
                            <form id="form-up-paiement">
                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        <div class="row form-group">
                                            <label class="col-sm-4 form-label">Somme</label>
                                            <input type="number" id="somme" name="somme" value="<?= $paieUp->getSommePaie() ?>" class="form-control col-sm-8">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="row form-group">
                                            <label class="col-sm-4 form-label">Description</label>
                                            <input type="text" id="desc" name="desc" value="<?= $paieUp->getDescPaie() ?>" class="form-control col-sm-8">
                                            <input type="hidden" id="paie" name="paie" value="<?= $paieUp->getIdPaie() ?>" class="form-control col-sm-8">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="row form-group">
                                            <label class="col-sm-4 form-label">Type</label>
                                            <select name="type" id="type" class="form-control col-sm-8">
                                                <option value="<?= $paieUp->getTypePaie() ?>" selected><?= $paieUp->getTypePaie() ?></option>
                                                <option value="ESPECE">ESPECE</option>
                                                <option value="MOBILE MONEY">MOBILE MONEY</option>
                                                <option value="CHEQUE">CHEQUE</option>
                                                <option value="VIREMENT BANACAIRE">VIREMENT BANACAIRE</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 offset-sm-8">
                                        <button class="btn btn-outline-primary mb-2"  type="submit">Modifier</button>
                                        <button class="btn btn-outline-danger mb-2" type="reset">Annuler</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Basic Form Inputs card end -->
                </div>
            </div>
            <?php
            endif;
                if(!empty($paies)):  ?>
                    <div class="col-sm-12">
                        <!-- Basic Form Inputs card start -->
                        <div class="card">
                            <div class="card-block">
                                <h4 class="sub-title">Historique de paiements</h4>
                                <div class="dt-responsive table-responsive">
                                    <table class="table table-striped table-bordered nowrap">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Somme</th>
                                            <th>Descrption</th>
                                            <th>Type</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i=1; foreach ($paies as $paie):?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= date("d-m-Y",strtotime($paie->getCreatPaie())) ?></td>
                                                <td><?= $paie->getSommePaie() ?></td>
                                                <td><?= $paie->getDescPaie() ?></td>
                                                <td><?= $paie->getTypePaie() ?></td>
                                                <td>
                                                    <a href="<?= URL ?>client/info/<?= $client->getIdClient() ?>/recu/<?= $paie->getIdPaie() ?>" target="_blank">
                                                        <button class="btn btn-info btn-md"><i class="icofont icofont-plus-circle"></i></button>
                                                    </a>
                                                    <form class="d-inline" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer ?');" action="<?= URL ?>client/info/<?= $client->getIdClient() ?>/paiement_sv/<?= $paie->getIdPaie() ?>"  >
                                                        <button id="btn-delete-form" class="btn btn-danger btn-md" type="submit"><i class="icofont icofont-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php $i++; endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Somme</th>
                                            <th>Descrption</th>
                                            <th>Type</th>
                                            <th></th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Basic Form Inputs card end -->
                    </div>
            <?php endif; ?>
        </div>
    </div>
</div>


        <!-- Page body end -->
<?php $content = ob_get_clean();

ob_start();
?>
<script src="<?= URL ?>public/assets/js/cdn/sweetarlert.js"></script>
<script>
    $(document).ready(function() {
        $('#form-up-paiement').submit( function(e)
        {
            var desc = $('#desc').val();
            var somme= $('#somme').val();
            var type = $('#type').val();
            var paie = $('#paie').val();

            $.post(
                "<?= URL ?>client/info/<?= $client->getIdClient() ?>/paiement_mv/<?= $paie->getIdPaie() ?>",
                {
                    desc:desc, somme:somme, type:type, paie:paie
                },
                function(response)
                {
                    swal({
                        title: "Bravo",
                        text: "Le paiement a été modifié avec succès!",
                        icon: "success"
                    }).then(function() {
                        window.location ="<?= URL ?>client/info/<?= $client->getIdClient() ?>/paiement_modifier/<?= $paie->getIdPaie() ?>";
                    });
                }
            );

            return false;
        });
    });
</script>
<?php
$footer = ob_get_clean();

require "views/partials/template.php";
?>

