<?php
$header = '';
ob_start(); ?>

<div class="main-body">
    <div class="page-wrapper">
        <!-- Page header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Infos Production</h4>

            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= URL ?>accueil">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?= URL ?>">Charge</a>
                    </li>

                    <li class="breadcrumb-item"><a href="<?= URL ?>">Ajouter</a>
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
                                        <label for="">Client</label>
                                        <input type="text" value="<?= $prodDetail[0]['nom_client'].' '.$prodDetail[0]['prenom_client'].' '.$prodDetail[0]['contact_client'] ?>" class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="">Commande</label>
                                        <input type="text" value="<?= $prodDetail[0]['desc_commande'] ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        <label for="">Nom du modèle</label>
                                        <input type="text"  value="<?= $prodDetail[0]['nom_modele'] ?>" class="form-control"readonly>

                                    </div>
                                    <div class="col-sm-4">
                                        <label for="">Côut du modèle</label>
                                        <input type="text"  value="<?= $prodDetail[0]['cout_modele'] ?>" class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="">Quantité</label>
                                        <input type="text"  value="<?= $prodDetail[0]['quantite_cmt'] ?>" class="form-control"readonly >
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
                            <p>Ajouter les charges de la production</p>
                        </div>
                        <div class="card-block">
                            <button   class="btn btn-block m-2 add_field_button"><i class="ion-plus"></i></button>
                            <form id="form-add-cmd" method="post" action="<?= URL ?>charge/av/<?= $prodDetail[0]['id_prod'] ?>">
                                <div class="input_fields_wrap">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Ressource</label>
                                        <div class="col-sm-10">
                                            <input type="hidden" name="prod" value="<?= $prodDetail[0]['id_prod'] ?>">
                                            <select name="ressource[]"   class="form-control" required>
                                                <?php
                                                if(!empty($ressources)):
                                                    foreach ($ressources as $ressource):
                                                        ?>
                                                        <option value="<?= $ressource->getIdRes() ?>">
                                                            <?= $ressource->getNomRes().' <=> '. $ressource->getDescRes() ?>
                                                        </option>
                                                    <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Description</label>
                                        <div class="col-sm-10">
                                            <input type="text"  name="desc[]" id="qte" class="form-control" placeholder="Entrer la description">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Prix</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" name="prix[]"  id="prix" placeholder="Entrer le prix" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Quantité</label>
                                        <div class="col-sm-10">
                                            <input type="number" step="0.01" class="form-control" name="qte[]"  id="prix" placeholder="Entrer la quantité" required>
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

            <?php if(isset($data) && !empty($data)): ?>
            <div class="row">
                <div class="col-sm-12">
                    <!-- Basic Form Inputs card start -->
                    <div class="card">
                        <div class="card-header">
                            <p>Historique des charges de la production</p>
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="simpletable" class="table table-striped table-bordered nowrap">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Description</th>
                                        <th>Prix</th>
                                        <th>Quantité</th>
                                        <th>Ressource</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i=1; foreach ($data as $dt):?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= $dt['desc']?></td>
                                            <td><?= $dt['prix']?></td>
                                            <td><?= $dt['qte']?></td>
                                            <td><?= $dt['ressource']?></td>
                                            <td>
                                                <a href="<?= URL ?>/charge/modifier/<?= $dt['production'] ?>">
                                                    <button class="btn btn-success btn-md text-light"><i class="icofont icofont-pencil-alt-5"></i></button>
                                                </a>
                                                <form class="d-inline" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer ?');" action="<?= URL ?>charge/sv/<?= $dt['id'] ?>" >
                                                    <button id="btn-delete-form" class="btn btn-danger btn-md" type="submit"><i class="icofont icofont-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Description</th>
                                        <th>Prix</th>
                                        <th>Quantité</th>
                                        <th>Ressource</th>
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
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Ressource</label>
                                <div class="col-sm-10">
                                    <select name="ressource[]"  id="modeles" class="form-control" required>
                                           <option value="0">
                                           ---------------------------------------------------
                                            </option>
                                        <?php
                                        if(!empty($ressources)):
                                        foreach ($ressources as $ressource):
                                        ?>
                                            <option value="<?= $ressource->getIdRes() ?>">
                                                <?= $ressource->getNomRes().' <=> '. $ressource->getDescRes() ?>
                                            </option>
                                        <?php
                                        endforeach;
                                        endif;
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10">
                                    <input type="text"  name="desc[]" id="qte" class="form-control" placeholder="Entrer la description">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Prix</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="prix[]"  id="prix" placeholder="Entrer le prix" required>
                                </div>
                            </div>
                              <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Quantité</label>
                                <div class="col-sm-10">
                                    <input type="number" step="0.01" class="form-control" name="qte[]"  id="qte" placeholder="Entrer la quantité" required>
                                </div>
                            </div>
                    <button class="btn btn-danger remove_field"><i class="ion-trash-a"></i></button>
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
