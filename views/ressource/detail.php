<?php ob_start(); ?>

<div class="main-body">
    <div class="page-wrapper">
        <!-- Page header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Info ressource</h4>

            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= URL ?>accueil">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?= URL ?>ressource">Ressource</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Détail</a>
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
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Nom</label>
                                        <div >
                                            <input type="text" name="nom" value="<?= $ressource->getNomRes() ?>"  class="form-control" readonly >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Description</label>
                                        <div >
                                            <input type="text"  name="desc" value="<?= $ressource->getDescRes() ?>"  class="form-control" readonly >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 ">
                                    <div class="form-group">
                                        <label class="form-label">Image</label>
                                        <div >
                                            <img src="<?= URL ?>/public/image/ressource/<?= $ressource->getImageRes() ?>" alt="" width="200" height="200" class="img-thumbnail"  data-toggle="modal" data-target="#large-">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal-->
                    <div class="modal fade" id="large-" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <img src="<?= URL?>public/image/ressource/<?= $ressource->getImageRes() ?>" class="img-responsive"  width="780px">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Fermer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal-->
                    <!-- Basic Form Inputs card end -->
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <!-- Basic Form Inputs card start -->
                    <div class="card">
                        <div class="card-block">
                            <h4 class="sub-title">Affecter Ressource au Personnel</h4>
                            <form id="form-affect-ressource">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 ">
                                        <div class="form-group">
                                            <label class="form-label">Choisir le personnel</label>
                                            <div >
                                                <input type="hidden" id="ressource" value="<?= $ressource->getIdRes() ?>">
                                                <select  id="personnel" class="form-control">
                                                    <option value="">------------------------------</option>
                                                    <?php foreach ($personnels as $personnel): ?>
                                                        <option value="<?= $personnel->getIdPers() ?>">
                                                          <?= $personnel->getNomPers().' <=> '.$personnel->getPrenomPers().' <=> '.$personnel->getContactPers() ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 ">
                                        <div class="form-group">
                                            <label class="form-label">Description</label>
                                            <div >
                                                <input type="text" id="desc" placeholder="Entrer une description" class="form-control">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4 offset-md-8">
                                        <button class="btn btn-outline-primary mb-2"  type="submit">Affecter</button>
                                        <button class="btn btn-outline-danger mb-2" type="reset">Annuler</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Basic Form Inputs card end -->
                </div>
            </div>
            <?php if (!empty($data)): ?>
            <div class="row">
                <div class="col-sm-12">
                    <!-- Basic Form Inputs card start -->
                    <div class="card">
                        <div class="card-block">
                            <h4 class="sub-title">Historique des affectations $persRess</h4>
                            <div class="dt-responsive table-responsive">
                                <table class="table table-striped table-bordered nowrap">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Personnel</th>
                                        <th>Description</th>
                                        <th>Date début</th>
                                        <th>Date fin</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i=1; foreach ($data as $dt):?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= $dt['nom'].' '.$dt['prenom'].' '.$dt['contact'] ?></td>
                                            <td><?=  $dt['desc'] ?></td>
                                            <td><?= date("d-m-Y",strtotime( $dt['creat'])) ?></td>
                                            <td>
                                                <?php if($dt['creat'] == $dt['mod']): ?>
                                                  En cours
                                                <?php elseif ($dt['creat'] != $dt['mod']): ?>
                                                  <?= date("d-m-Y",strtotime( $dt['creat'])) ?>
                                                <?php endif; ?>
                                            <td>
                                                <button class="btn btn-primary btn-md " data-toggle="modal" data-target="#modRes<?= $dt['id']?>"><i class="icofont icofont-pencil-alt-5"></i></button>
                                                <form class="d-inline" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer ?');" action="<?= URL ?>ressource/sf/<?= $dt['id'] ?>">
                                                    <button id="btn-delete-form" class="btn btn-danger btn-md" type="submit"><i class="icofont icofont-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="modRes<?= $dt['id']?>" tabindex="-1">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="sub-title">Affecter Ressource au Personnel</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body p-b-0">
                                                        <form id="" action="<?= URL ?>ressource/mf/<?= $dt['id'] ?>" method="post">
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="form-group ">
                                                                        <label class=" col-form-label">Choisir le personnel</label>
                                                                        <div class="">
                                                                            <input type="hidden" name="id_pers" id="id_pers" value="<?= $dt['id']?>">
                                                                            <select  id="personnelmod" name="personnelmod" class="form-control">
                                                                                <option value="">------------------------------</option>
                                                                                <option value="<?= $dt['id_p'] ?>" selected><?= $dt['nom'].' '.$dt['prenom'].' '.$dt['contact'] ?></option>
                                                                                <?php foreach ($personnels as $personnel): ?>
                                                                                    <option value="<?= $personnel->getIdPers() ?>">
                                                                                        <?= $personnel->getNomPers().' <=> '.$personnel->getPrenomPers().' <=> '.$personnel->getContactPers() ?>
                                                                                    </option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <label class="col-form-label">Description</label>
                                                                        <div>
                                                                            <input type="text" id="descmod" name="descmod" value="<?= $dt['desc']?>" placeholder="Entrer une description" class="form-control">

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                    <button class="btn btn-outline-primary mb-2"  type="submit">Modifier</button>
                                                                    <button class="btn btn-outline-danger mb-2" type="reset" data-dismiss="modal">Annuler</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php $i++; endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Personnel</th>
                                        <th>Description</th>
                                        <th>Date début</th>
                                        <th>Date fin</th>
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
    $(document).ready(function (){
        $('#form-affect-ressource').submit( function(e)
        {
            var ressource = $('#ressource').val();
            var personnel = $('#personnel').val();
            var desc = $('#desc').val();

            $.post(
                '<?= URL ?>ressource/af',
                {
                    ressource:ressource, personnel:personnel,desc:desc
                },
                function(response)
                {
                    swal({
                        title: "Bravo",
                        text: "Affectation ajoutée avec succès!",
                        icon: "success"
                    }).then(function() {
                        window.location ="<?= URL ?>ressource/detail/<?= $ressource->getIdRes() ?>";
                    });
                });
            return false;
        });
    });
</script>

<?php
$footer =ob_get_clean();
require "views/partials/template.php";
?>
