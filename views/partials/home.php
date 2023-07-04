<?php
ob_start();
?>
<!-- Data Table Css -->
<link rel="stylesheet" type="text/css"
      href="<?= URL ?>public/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css"
      href="<?= URL ?>public/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">

<link href="<?= URL ?>public/assets/css/timeline.css" rel="stylesheet">
<?php
$header = ob_get_clean();
ob_start();
?>
<div class="main-body">
    <div class="page-wrapper">
        <div class="page-header">
            <div class="page-header-title">
                <h4>Accueil</h4>
                <button class="btn btn-primary" id="btnMontrerRDV">RDV</button>
            </div>
        </div>
        <div class="page-body">
            <div class="card" id="rdvTimeline">
                <div class="card-header">
                    <p class="card-header">Liste des rdv</p>
                    <button class="btn btn-primary" id="btnMasquerRdv">Masquer</button>
                </div>
                <section id="timeline">
                    <?php if (!empty($data_commande)):
                        foreach ($data_commande as $cmd):
                            if ($cmd['rdv'] > date("Y-m-d")):
                                $style = 'green';
                            else:
                                $style = 'red';
                            endif;
                            ?>
                            <article>
                                <div class="inner">
                              <span class="date">
                                <span class="day"><?= date("d", strtotime($cmd['rdv'])) ?></span>
                                  <span class="month"><?= substr(date("F", strtotime($cmd['rdv'])), 0, 3) ?></span>
                                          <span class="year"><?= date("Y", strtotime($cmd['rdv'])) ?></span>
                              </span>
                                    <h2 style="background-color: <?= $style ?>;"><?= $cmd['desc'] ?></h2>
                                    <p> Client: <?= $cmd['nom'] . ' ' . $cmd['prenom'] . ' ' . $cmd['contact'] ?>
                                        <br>
                                        <?php if ($_SESSION['agence_role'] == 'Principale' && $_SESSION['role'] == 'admin'): ?>
                                            Montant Commande: <?= $cmd['somme'] ?> <br>
                                        <?php endif; ?>
                                        Progression: <?= $cmd['tache'] . '/' . $cmd['total'] . ' effectuées' ?></p>
                                </div>
                            </article>
                        <?php
                        endforeach;
                    endif; ?>
                </section>
            </div>
            <div class="row" id="info-commande">
                <div class="col-sm-12">
                    <!-- Zero config.table start -->
                    <div class="card">
                        <button class="btn btn-info" id="btn_personnel">Personnel</button>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="simpletable" class="table table-striped table-bordered nowrap">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Client</th>
                                        <th>Commande</th>
                                        <th>Date de création</th>
                                        <th>Date de RDV</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($data_cmd)): ?>
                                        <?php $i = 1;
                                        foreach ($data_cmd as $cmd): ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= $cmd['nom'] . ' ' . $cmd['prenom'] ?></td>
                                                <td><?= $cmd['desc'] ?></td>
                                                <td><?= date("d-m-Y", strtotime($cmd['creat'])) ?></td>
                                                <td><?= date("d-m-Y", strtotime($cmd['rdv'])) ?></td>
                                                <td>
                                                    <a href="<?= URL ?>client/info/<?= $cmd['client'] ?>/commande/<?= $cmd['commande'] ?>">
                                                        <button class="btn btn-info btn-md"><i
                                                                    class="icofont icofont-plus-circle"></i></button>
                                                    </a>
                                                </td>

                                            </tr>
                                            <?php $i++; endforeach; ?>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="info-personnel">
                <div class="col-sm-12">
                    <!-- Zero config.table start -->
                    <div class="card">
                        <button class="btn btn-info" id="btn_commande">Commande</button>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table class="table table-striped table-bordered nowrap">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Personnel</th>
                                        <?php if (!empty($column)): ?>
                                            <?php for ($cpt_col = 1; $cpt_col <= $column; $cpt_col++): ?>
                                                <th>Tâche <?= $cpt_col ?></th>
                                            <?php endfor; ?>
                                        <?php endif; ?>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($data_pers)): ?>
                                        <?php $i = 1;
                                        foreach ($data_pers as $dt): ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= $dt['personnel']->getNomPers() . ' ' . $dt['personnel']->getPrenomPers() ?></td>
                                                <?php foreach ($dt['travail'] as $tache): ?>
                                                    <td>
                                                        <?php if (isset($tache['rdv']) && !empty($tache['rdv'])): ?>
                                                            <button class="btn btn-warning" data-toggle="modal"
                                                                    data-target="#infos-Modal<?= $tache['id_cmt'] ?>">
                                                                <span><?= $tache['nom_client'] . ' ' . $tache['prenom_client'] ?></span>
                                                                <br>
                                                                <span><?= $tache['desc_commande'] ?></span> <br>
                                                                <span><?= $tache['nom_modele'] ?></span><br>
                                                                <span><?= date("d-m-Y", strtotime($tache['rdv'])) ?></span><br>
                                                                <span><?= $tache['desc_prod'] ?></span><br>
                                                            </button> <br>
                                                            <button class="btn btn-success btn-md text-light  mt-1"
                                                                    data-toggle="modal"
                                                                    data-target="#prod-Modal<?= $tache['id_prod'] ?>"><i
                                                                        class="icofont icofont-pencil-alt-5"></i>
                                                            </button>
                                                            <form class="d-inline" method="post"
                                                                  onsubmit="return confirm('Voulez-vous vraiment supprimer ?');"
                                                                  action="<?= URL ?>commande/sv/<?= $tache['id_prod'] ?>">
                                                                <button id="btn-delete-mesure-form"
                                                                        class="btn btn-danger btn-md  mt-1"
                                                                        type="submit"><i
                                                                            class="icofont icofont-trash"></i></button>
                                                            </form>

                                                        <?php elseif ($tache['rdv_commande'] >= date("Y-m-d")): ?>
                                                            <button class="btn btn-success" data-toggle="modal"
                                                                    data-target="#infos-Modal<?= $tache['id_cmt'] ?>">
                                                                <span><?= $tache['nom_client'] . ' ' . $tache['prenom_client'] ?></span>
                                                                <br>
                                                                <span><?= $tache['desc_commande'] ?></span> <br>
                                                                <span><?= $tache['nom_modele'] ?></span><br>
                                                                <span><?= date("d-m-Y", strtotime($tache['rdv_commande'])) ?></span><br>
                                                                <span><?= $tache['desc_prod'] ?></span><br>
                                                            </button><br>
                                                            <button class="btn btn-success btn-md text-light  mt-1"
                                                                    data-toggle="modal"
                                                                    data-target="#prod-Modal<?= $tache['id_prod'] ?>"><i
                                                                        class="icofont icofont-pencil-alt-5"></i>
                                                            </button>
                                                            <form class="d-inline" method="post"
                                                                  onsubmit="return confirm('Voulez-vous vraiment supprimer ?');"
                                                                  action="<?= URL ?>commande/sv/<?= $tache['id_prod'] ?>">
                                                                <button id="btn-delete-mesure-form"
                                                                        class="btn btn-danger btn-md  mt-1"
                                                                        type="submit"><i
                                                                            class="icofont icofont-trash"></i></button>
                                                            </form>
                                                        <?php elseif ($tache['rdv_commande'] < date("Y-m-d")): ?>
                                                            <button class="btn btn-danger" data-toggle="modal"
                                                                    data-target="#infos-Modal<?= $tache['id_cmt'] ?>">
                                                                <span><?= $tache['nom_client'] . ' ' . $tache['prenom_client'] ?></span>
                                                                <br>
                                                                <span><?= $tache['desc_commande'] ?></span> <br>
                                                                <span><?= $tache['nom_modele'] ?></span><br>
                                                                <span><?= date("d-m-Y", strtotime($tache['rdv_commande'])) ?></span><br>
                                                                <span><?= $tache['desc_prod'] ?></span><br>
                                                            </button><br>
                                                            <button class="btn btn-success btn-md text-light  mt-1"
                                                                    data-toggle="modal"
                                                                    data-target="#prod-Modal<?= $tache['id_prod'] ?>"><i
                                                                        class="icofont icofont-pencil-alt-5"></i>
                                                            </button>
                                                            <form class="d-inline" method="post"
                                                                  onsubmit="return confirm('Voulez-vous vraiment supprimer ?');"
                                                                  action="<?= URL ?>commande/sv/<?= $tache['id_prod'] ?>">
                                                                <button id="btn-delete-mesure-form"
                                                                        class="btn btn-danger btn-md  mt-1"
                                                                        type="submit"><i
                                                                            class="icofont icofont-trash"></i></button>
                                                            </form>
                                                        <?php endif; ?>
                                                    </td>
                                                    <!-- Modal Affecter-->
                                                    <div class="modal fade" id="infos-Modal<?= $tache['id_cmt'] ?>"
                                                         tabindex="-1" role="dialog">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Detail sur la tache</h4>
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <a href="<?= URL ?>commande/cloturer/<?= $tache['id_prod'] ?>">
                                                                        <button class="btn btn-success btn-block m-2">
                                                                            Terminer
                                                                        </button>
                                                                    </a>
                                                                    <hr>

                                                                    <form method="post"
                                                                          action="<?= URL ?>commande/reporter/<?= $tache['id_commande'] ?>">
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Description</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" rows="4"
                                                                                       class="form-control" name="desc">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Date
                                                                                report RDV</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="date" name="date_report"
                                                                                       class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <button type="submit"
                                                                                class="btn-block btn btn-danger waves-effect waves-light ">
                                                                            Reporter
                                                                        </button>
                                                                    </form>
                                                                    <hr>
                                                                    <form method="post" action="<?= URL ?>commande/ava">
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Personnel</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="hidden"
                                                                                       value="<?= $tache['id_cmt'] ?>"
                                                                                       name="id_cmt">
                                                                                <input type="hidden"
                                                                                       value="<?= $tache['id_prod'] ?>"
                                                                                       name="id_prod">
                                                                                <select name="personnel"
                                                                                        class="form-control">
                                                                                    <option value="">
                                                                                        ------------------------------
                                                                                    </option>
                                                                                    <?php foreach ($personnels as $personnel): ?>
                                                                                        <option value="<?= $personnel->getIdPers() ?>">
                                                                                            <?= $personnel->getNomPers() . ' <=> ' . $personnel->getPrenomPers() . ' <=> ' . $personnel->getContactPers() ?>
                                                                                        </option>
                                                                                    <?php endforeach; ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Type</label>
                                                                            <div class="col-sm-8">
                                                                                <select name="type"
                                                                                        class="form-control">
                                                                                    <option value="<?= $tache['desc_prod'] ?>"><?= $tache['desc_prod'] ?></option>
                                                                                    <option value="Montage">Montage
                                                                                    </option>
                                                                                    <option value="Découpage">
                                                                                        Découpage
                                                                                    </option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Montant
                                                                                à verser</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="number"
                                                                                       class="form-control"
                                                                                       name="somme">
                                                                            </div>
                                                                        </div>
                                                                        <button type="submit"
                                                                                class="btn-block btn btn-primary waves-effect waves-light ">
                                                                            Réaffecter
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button"
                                                                            class="btn btn-default waves-effect "
                                                                            data-dismiss="modal">Annuler
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--End modal-->

                                                    <div class="modal fade" id="prod-Modal<?= $tache['id_prod'] ?>"
                                                         tabindex="-1" role="dialog">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Modification de la
                                                                        tâche</h4>
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <hr>
                                                                    <form method="post" action="<?= URL ?>commande/mv">
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-5 col-form-label">Personnel</label>
                                                                            <div class="col-sm-7">
                                                                                <input type="hidden"
                                                                                       value="<?= $tache['id_prod'] ?>"
                                                                                       name="production">
                                                                                <select name="personnel"
                                                                                        class="form-control">
                                                                                    <option value="<?= $tache['id_pers'] ?>"
                                                                                            selected><?= $tache['nom_pers'] . ' <=> ' . $tache['prenom_pers'] . ' <=> ' . $tache['contact_pers'] ?></option>
                                                                                    <?php foreach ($personnels as $personnel): ?>
                                                                                        <option value="<?= $personnel->getIdPers() ?>">
                                                                                            <?= $personnel->getNomPers() . ' <=> ' . $personnel->getPrenomPers() . ' <=> ' . $personnel->getContactPers() ?>
                                                                                        </option>
                                                                                    <?php endforeach; ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-5 col-form-label">Type</label>
                                                                            <div class="col-sm-7">
                                                                                <select name="type"
                                                                                        class="form-control">
                                                                                    <option value="<?= $tache['desc_prod'] ?>"
                                                                                            selected><?= $tache['desc_prod'] ?></option>
                                                                                    <option value="Montage">Montage
                                                                                    </option>
                                                                                    <option value="Découpage">
                                                                                        Découpage
                                                                                    </option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-5 col-form-label">Prime
                                                                                de rendement</label>
                                                                            <div class="col-sm-7">
                                                                                <input type="number"
                                                                                       class="form-control" name="rend">
                                                                            </div>

                                                                        </div>
                                                                        <button type="submit"
                                                                                class="btn-block btn btn-primary waves-effect waves-light ">
                                                                            Modifier
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button"
                                                                            class="btn btn-default waves-effect "
                                                                            data-dismiss="modal">Annuler
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </tr>
                                            <?php $i++; endforeach; ?>
                                    <?php endif; ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Personnel</th>
                                        <?php for ($cpt_col = 1; $cpt_col <= $column; $cpt_col++): ?>
                                            <th>Tâche <?= $cpt_col ?></th>
                                        <?php endfor; ?>
                                        <th></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Zero config.table end -->
                    <!-- Default ordering table start -->
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
ob_start();
?>
<!-- data-table js -->
<script src="<?= URL ?>public/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= URL ?>public/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= URL ?>public/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= URL ?>public/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script>
    $(document).ready(function () {
        $('#btnMasquerRdv').click(function () {
            $('#btnMontrerRDV').show();
            $('#rdvTimeline').hide();
        });

        $('#btnMontrerRDV').click(function () {
            $('#rdvTimeline').show();
            $('#btnMontrerRDV').hide();
        });

        $('#btnMontrerRDV').hide();
        $('#info-commande').hide();
        $('#info-personnel').show();

        $('#btn_commande').click(function () {
            $('#info-commande').show();
            $('#info-personnel').hide();
        });

        $('#btn_personnel').click(function () {
            $('#info-commande').hide();
            $('#info-personnel').show();
        });

    });
</script>
<?php
$footer = ob_get_clean();
require 'views/partials/template.php';
?>
