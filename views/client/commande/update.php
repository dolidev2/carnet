<?php
$header = '';
ob_start(); ?>

<div class="main-body">
    <div class="page-wrapper">
        <!-- Page header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Commande mise à jour</h4>

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
                    <li class="breadcrumb-item"><a href="<?= URL ?>client/commande/ajouter">Modifier</a>
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
                            <p>Modifier la commande</p>
                        </div>
                        <div class="card-block">
                            <form id="form-up-commande">
                                <div class="form-group">
                                    <label class="form-label">Date de création</label>
                                    <div class="">
                                        <input type="date" class="form-control" id="date_commande" value="<?= $commande->getCreatCommande() ?>" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Description</label>
                                    <div class="">
                                        <input type="text" class="form-control" id="desc_commande" value="<?= $commande->getDescCommande() ?>" readonly>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Date RDV</label>
                                    <div class="">
                                        <input type="date" class="form-control" id="rdv_commande" value="<?= date("Y-m-d",strtotime($commande->getRdvCommande())) ?>" required>
                                        <input type="hidden" class="form-control" id="commande" value="<?= $commande->getIdCommande() ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Statut</label>
                                    <div class="">
                                        <select  id="statut_commande" class="form-control" required>
                                            <?php if ($commande->getStatutCommande() == 0): ?>
                                                <option value="<?= $commande->getStatutCommande()?>"><button class="btn btn-success">En cours</button></option>
                                            <?php elseif ($commande->getStatutCommande() == 1): ?>
                                                <option value="<?= $commande->getStatutCommande()?>"><button class="btn btn-danger">Terminé</button></option>
                                            <?php endif; ?>
                                            <option value="1"><button class="btn btn-danger">Terminé</button></option>
                                            <option value="0"><button class="btn btn-success">En cours</button></option>
                                        </select>
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit">Modifier</button>
                                <button class="btn btn-danger" type="reset">Annuler</button>
                            </form>
                        </div>
                    </div>
                    <!-- Basic Form Inputs card end -->
                </div>
            </div>
            <?php if (!empty($data)):  ?>
                <div class="row">
                    <div class="col-sm-12">
                        <!-- Basic Form Inputs card start -->
                        <div class="card">
                            <div class="card-header">
                                <p>Modifier Modèle Tissu de la commande</p>
                            </div>
                            <div class="card-block">
                                <form id="form-up-cmd" method="post" action="<?= URL ?>client/info/<?= $client->getIdClient() ?>/commande_mvc/<?= $commande->getIdCommande() ?>">

                                    <?php foreach ($data as $dt): ?>
                                    <div class="input_fields_wrap">
                                        <div class="form-group">
                                            <label class="form-label">Modèle</label>
                                            <div>
                                                <input type="hidden" class="form-control" name="id_cmt[]" value="<?= $dt['id'] ?>">
                                                <select name="modele[]"  id="modeles" class="form-control" required>
                                                    <?php
                                                    if(!empty($modeles)):
                                                        foreach ($modeles as $modele):
                                                            if( $dt['modele_id'] ==  $modele->getIdModele()):
                                                                  ?>
                                                                    <option value="<?= $modele->getIdModele() ?>" selected>
                                                                        <?= $modele->getNomModele().' <=> '.$modele->getPrixModele() ?>
                                                                    </option>
                                                                <?php
                                                            endif;
                                                            ?>
                                                            <option value="<?= $modele->getIdModele() ?>">
                                                                <?= $modele->getNomModele().' <=> '.$modele->getPrixModele() ?>
                                                            </option>
                                                            <?php
                                                        endforeach;
                                                    endif;
                                                    if(!empty($modelesComp)):
                                                        foreach ($modelesComp as $modeleComp):
                                                            if( $dt['modele_id'] ==  $modeleComp->getIdModComp()):
                                                                  ?>
                                                                    <option value="<?= $modeleComp->getIdModComp() ?>" selected>
                                                                        <?= $modeleComp->getNomModComp().' <=> '.$modeleComp->getPrixModComp() ?>
                                                                    </option>
                                                                <?php
                                                            endif;
                                                            ?>
                                                            <option value="<?= $modeleComp->getIdModComp() ?>">
                                                                <?= $modeleComp->getNomModComp().' <=> '.$modeleComp->getPrixModComp() ?>
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
                                                    <option value="<?= $dt['tissu_id'] ?>" selected>
                                                        <?= $dt['tissu'].' <=> '.$dt['tissu_desc'] ?>
                                                    </option>
                                                    <?php
                                                    if(!empty($tissus)):
                                                        foreach ($tissus as $tissu):
                                                            if ($dt['tissu_id'] == $tissu->getIdTissu()):
                                                            ?>
                                                                <option value="<?= $tissu->getIdTissu() ?>" selected>
                                                                    <?= $tissu->getNomTissu().' <=> '.$tissu->getDescTissu() ?>
                                                                </option>
                                                            <?php
                                                            endif;
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
                                            <label class="form-label">Rémise</label>
                                            <div>
                                                <input type="number"  name="remise[]" id="remise" value="<?= $dt['remise'] ?>" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Quantité</label>
                                            <div>
                                                <input type="number"  name="quantite[]" id="qte" value="<?= $dt['qte'] ?>" class="form-control" placeholder="Entrer la quantité" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Prix</label>
                                            <div>
                                                <input type="number" class="form-control" name="prix[]"  id="prix" value="<?= $dt['prix'] ?>" placeholder="Entrer le prix">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Statut</label>
                                            <div class="">
                                                <select  name="statut[]" class="form-control">
                                                    <?php if ($dt['statut'] == 0): ?>
                                                        <option value="<?= $dt['statut']?>"><button class="btn btn-success">En cours</button></option>
                                                    <?php elseif ($dt['statut'] == 1): ?>
                                                        <option value="<?= $dt['statut']?>"><button class="btn btn-danger">Terminé</button></option>
                                                    <?php endif; ?>
                                                    <option value="1"><button class="btn btn-danger">Terminé</button></option>
                                                    <option value="0"><button class="btn btn-success">En cours</button></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                        <hr>
                                    <?php endforeach; ?>
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
        $('#form-up-commande').submit( function(e)
        {
            var creat = $('#date_commande').val();
            var desc = $('#desc_commande').val();
            var rdv= $('#rdv_commande').val();
            var statut= $('#statut_commande').val();
            var commande = $('#commande').val();

            $.post(
                "<?= URL ?>client/info/<?= $client->getIdClient() ?>/commande_mv/<?= $commande->getIdCommande() ?>",
                {
                    creat:creat, desc:desc, rdv:rdv, commande:commande,statut:statut
                },
                function(response)
                {
                    swal({
                        title: "Bravo",
                        text: "La commande a été modifiée avec succès!",
                        icon: "success"
                    }).then(function() {
                        window.location ="<?= URL ?>client/info/<?= $client->getIdClient() ?>/commande_modifier/<?= $commande->getIdCommande() ?>";
                    });;
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
