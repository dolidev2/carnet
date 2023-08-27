<?php
$header = '';
ob_start();
?>
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Ajouter un paiement</h4>
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
                    <li class="breadcrumb-item"><a href="<?= URL ?>client/info/<?= $client->getIdClient()?>">Paiement</a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?= URL ?>client/info/<?= $client->getIdClient()?>/paiement_ajouter">Ajouter</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page header end -->
        <!-- Page body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-block">
                            <h4 class="sub-title">Info Client</h4>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-control ">
                                        <label class="col-form-label">Nom</label>
                                        <input type="text" class="form-control" value="<?= $client->getNomClient()?>" readonly>
                                    </div>
                                    <div class=" form-control ">
                                        <label class="col-form-label">Prénom</label>
                                        <input type="text"  class="form-control" value="<?= $client->getPrenomClient()?>" readonly>
                                    </div>
                                    <div class="form-control ">
                                        <label class="col-form-label">Numéro mesure</label>
                                        <input type="text" class="form-control" value="<?= $client->getNumeroMesure()?>" readonly>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class=" form-control ">
                                        <label class="col-form-label">Type</label>
                                        <input type="text"  class="form-control" value="<?= $client->getTypeClient()?>" readonly>
                                    </div>
                                    <div class="form-control ">
                                        <label class="col-form-label">Contact</label>
                                        <input type="text" class="form-control" value="<?= $client->getContactClient()?>" readonly>
                                    </div>
                                    <div class="form-control ">
                                        <label class="col-form-label">Adresse</label>
                                        <input type="text"  class="form-control" value="<?= $client->getAdresseClient()?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-block">
                            <h4 class="sub-title">Info Commande</h4>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-control">
                                        <label class="col-form-label">Description</label>
                                        <input type="text" class="form-control" value="<?= $commande->getDescCommande()?>" readonly>
                                    </div>
                                    <div class=" form-control">
                                        <label class="col-form-label">Date de création</label>
                                        <input type="text"  class="form-control" value="<?=date("d-m-Y",strtotime($commande->getCreatCommande())) ?>" readonly>
                                    </div>
                                    <div class="form-control">
                                        <label class="col-form-label">Date de RDV</label>
                                        <input type="text" class="form-control" value="<?= date("d-m-Y",strtotime($commande->getRdvCommande()))?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-block">
                            <h4 class="sub-title">Info Commande Articles</h4>
                            <?php foreach ($data as $dt): ?>
                                <div class="row">
                                    <div class="col-12">
                                        <div class=" form-control">
                                            <label class="col-form-label">Modèle</label>
                                            <input type="text" class="form-control" value="<?= $dt['modele_nom'].' <=> '.$dt['modele_prix'] ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;
                            ?>
                            <div class="row">
                                <div class="col-12">
                                    <div class=" form-control">
                                        <label class="col-form-label">Remise</label>
                                        <button class="btn btn-info btn-block mt-3 "><?= $remise ?> F CFA</button>
<!--                                        <input type="text" class="form-control" value="--><?//= $remise ?><!--" readonly>-->
                                    </div>
                                </div>
                            </div>
                            <?php
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
            <?php if($formAdd): ?>
            <?php else: ?>
                <div class="row" id="div-add-paiement">
                    <div class="col-sm-12">
                        <!-- Basic Form Inputs card start -->
                        <div class="card">
                            <div class="card-block">
                                <h4 class="sub-title">Ajouter un paiement</h4>
                                <form id="form-add-paiement">
                                    <div class="form-group row">
                                        <div class="col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label class="form-label">Date de paiement</label>
                                                <input type="date" id="date_p" name="date_p" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label class="form-label">Somme</label>
                                                <input type="number" id="somme" name="somme" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label class="form-label">Description</label>
                                                <input type="text" id="desc" name="desc" class="form-control">
                                                <input type="hidden" id="commande" name="commande" value="<?= $commande->getIdCommande() ?>" class="form-control col-sm-8">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label class="form-label">Type</label>
                                                <select name="type" id="type" class="form-control">
                                                    <option value="ESPECE">ESPECE</option>
                                                    <option value="MOBILE MONEY">MOBILE MONEY</option>
                                                    <option value="CHEQUE">CHEQUE</option>
                                                    <option value="VIREMENT BANACAIRE">VIREMENT BANACAIRE</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4 offset-md-8">
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
            <?php endif;
                if(!empty($paies)):  ?>
            <div class="row">
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
                                                <a href="<?= URL ?>client/info/<?= $client->getIdClient() ?>/paiement_modifier/<?= $paie->getIdPaie() ?>">
                                                    <button class="btn btn-success btn-md text-light"><i class="icofont icofont-pencil-alt-5"></i></button>
                                                </a>
                                                <a href="<?= URL ?>client/info/<?= $client->getIdClient() ?>/recu/<?= $paie->getIdPaie() ?>" target="_blank">
                                                    <button class="btn btn-info btn-md"><i class="icofont icofont-plus-circle"></i></button>
                                                </a>
                                                <?php if($_SESSION['role'] == 'super_admin'): ?>
                                                <form class="d-inline" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer ?');" action="<?= URL ?>client/info/<?= $client->getIdClient() ?>/paiement_sv/<?= $paie->getIdPaie() ?>" >
                                                    <button id="btn-delete-form" class="btn btn-danger btn-md" type="submit"><i class="icofont icofont-trash"></i></button>
                                                </form>
                                                <?php endif; ?>
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
            </div>
            <?php endif; ?>
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
    $(document).ready(function() {
        $('#form-add-paiement').submit( function(e)
        {
            var desc = $('#desc').val();
            var somme= $('#somme').val();
            var type = $('#type').val();
            var date_p = $('#date_p').val();
            var commande = $('#commande').val();

            $.post(
                "<?= URL ?>client/info/<?= $client->getIdClient() ?>/paiement_av",
                {
                    desc:desc, somme:somme, type:type, commande:commande,date_p:date_p
                },
                function(response)
                {
                     swal({
                         title: "Bravo",
                         text: "Le paiement a été ajouté avec succès!",
                         icon: "success"
                     }).then(function() {
                        window.location ="<?= URL ?>client/info/<?= $client->getIdClient() ?>/paiement_ajouter/<?= $commande->getIdCommande() ?>";
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
