<?php
ob_start();
?>
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
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index.html">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?=URL?>accueil">Accueil</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="page-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
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
                                        <?php $i=1; foreach ($data_pers as $dt): ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= $dt['personnel']->getNomPers().' '.$dt['personnel']->getPrenomPers() ?></td>
                                                <?php foreach ($dt['travail'] as $tache): ?>
                                                    <td>
                                                        <?php if(isset($tache['rdv']) && !empty($tache['rdv'])):  ?>
                                                            <button class="btn btn-warning" data-toggle="modal" data-target="#infos-Modal<?= $tache['id_cmt'] ?>">
                                                                <span><?= $tache['desc_commande'] ?></span> <br>
                                                                <span><?= $tache['nom_modele'] ?></span><br>
                                                                <span><?= date("d-m-Y", strtotime($tache['rdv'] )) ?></span><br>
                                                                <span><?= $tache['desc_prod'] ?></span><br>
                                                            </button> <br>
                                                            <button class="btn btn-success btn-md text-light  mt-1" data-toggle="modal" data-target="#prod-Modal<?=  $tache['id_prod'] ?>"><i class="icofont icofont-pencil-alt-5"></i></button>
                                                            <form class="d-inline" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer ?');" action="<?= URL ?>commande/sv/<?=$tache['id_prod'] ?>">
                                                                <button id="btn-delete-mesure-form" class="btn btn-danger btn-md  mt-1" type="submit"><i class="icofont icofont-trash"></i></button>
                                                            </form>

                                                        <?php elseif ( $tache['rdv_commande'] >= date("Y-m-d")): ?>
                                                            <button class="btn btn-success" data-toggle="modal" data-target="#infos-Modal<?= $tache['id_cmt'] ?>">
                                                                <span><?= $tache['desc_commande'] ?></span> <br>
                                                                <span><?= $tache['nom_modele'] ?></span><br>
                                                                <span><?= date("d-m-Y", strtotime($tache['rdv_commande'] )) ?></span><br>
                                                                <span><?= $tache['desc_prod'] ?></span><br>
                                                            </button><br>
                                                            <button class="btn btn-success btn-md text-light  mt-1" data-toggle="modal" data-target="#prod-Modal<?=  $tache['id_prod'] ?>"><i class="icofont icofont-pencil-alt-5"></i></button>
                                                            <form class="d-inline" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer ?');" action="<?= URL ?>commande/sv/<?=$tache['id_prod'] ?>">
                                                                <button id="btn-delete-mesure-form" class="btn btn-danger btn-md  mt-1" type="submit"><i class="icofont icofont-trash"></i></button>
                                                            </form>
                                                        <?php elseif($tache['rdv_commande'] < date("Y-m-d")): ?>
                                                            <button class="btn btn-danger" data-toggle="modal" data-target="#infos-Modal<?= $tache['id_cmt'] ?>">
                                                                <span><?= $tache['desc_commande'] ?></span> <br>
                                                                <span><?= $tache['nom_modele'] ?></span><br>
                                                                <span><?= date("d-m-Y", strtotime($tache['rdv_commande'] )) ?></span><br>
                                                                <span><?= $tache['desc_prod'] ?></span><br>
                                                            </button><br>
                                                            <button class="btn btn-success btn-md text-light  mt-1" data-toggle="modal" data-target="#prod-Modal<?=  $tache['id_prod'] ?>"><i class="icofont icofont-pencil-alt-5"></i></button>
                                                            <form class="d-inline" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer ?');" action="<?= URL ?>commande/sv/<?=$tache['id_prod'] ?>">
                                                                <button id="btn-delete-mesure-form" class="btn btn-danger btn-md  mt-1" type="submit"><i class="icofont icofont-trash"></i></button>
                                                            </form>
                                                        <?php endif; ?>
                                                    </td>
                                                    <!-- Modal Affecter-->
                                                    <div class="modal fade" id="infos-Modal<?= $tache['id_cmt'] ?>" tabindex="-1" role="dialog">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Detail sur la tache</h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <a href="<?= URL ?>/commande/cloturer/<?= $tache['id_cmt'] ?>">
                                                                        <button class="btn btn-success btn-block m-2"> Terminer</button>
                                                                    </a>
                                                                    <hr>

                                                                    <form method="post"  action="<?= URL ?>/commande/reporter/<?= $tache['id_commande'] ?>">
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Description</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text"   rows="4" class="form-control" name="desc">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Date report RDV</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="date" name="date_report" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <button type="submit" class="btn-block btn btn-danger waves-effect waves-light ">Reporter</button>
                                                                    </form>
                                                                    <hr>
                                                                    <form method="post"  action="<?= URL ?>commande/ava">
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-3 col-form-label">Personnel</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="hidden" value="<?= $tache['id_cmt'] ?>" name="id_cmt">
                                                                                <select  name="personnel" class="form-control">
                                                                                    <option value="">------------------------------</option>
                                                                                    <?php foreach ($personnels as $personnel): ?>
                                                                                        <option value="<?= $personnel->getIdPers() ?>">
                                                                                            <?= $personnel->getNomPers().' <=> '.$personnel->getPrenomPers().' <=> '.$personnel->getContactPers() ?>
                                                                                        </option>
                                                                                    <?php endforeach; ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-2 col-form-label">Type</label>
                                                                            <div class="col-sm-10">
                                                                                <select  name="type" class="form-control">
                                                                                    <option value="Montage">Montage</option>
                                                                                    <option value="Découpage">Découpage</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <button type="submit" class="btn-block btn btn-primary waves-effect waves-light ">Réaffecter</button>
                                                                    </form>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Annuler</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--End modal-->

                                                    <div class="modal fade" id="prod-Modal<?= $tache['id_prod'] ?>" tabindex="-1" role="dialog">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Modification de la tâche</h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <hr>
                                                                    <form method="post"  action="<?= URL ?>commande/mv">
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-3 col-form-label">Personnel</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="hidden" value="<?= $tache['id_prod'] ?>" name="production">
                                                                                <select  name="personnel" class="form-control">
                                                                                    <option value="<?= $tache['id_pers'] ?>" selected><?= $tache['nom_pers'].' <=> '.$tache['prenom_pers'].' <=> '.$tache['contact_pers'] ?></option>
                                                                                    <?php foreach ($personnels as $personnel): ?>
                                                                                        <option value="<?= $personnel->getIdPers() ?>">
                                                                                            <?= $personnel->getNomPers().' <=> '.$personnel->getPrenomPers().' <=> '.$personnel->getContactPers() ?>
                                                                                        </option>
                                                                                    <?php endforeach; ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-2 col-form-label">Type</label>
                                                                            <div class="col-sm-10">
                                                                                <select  name="type" class="form-control">
                                                                                    <option value="<?= $tache['id_prod'] ?>" selected><?= $tache['desc_prod'] ?></option>
                                                                                    <option value="Montage">Montage</option>
                                                                                    <option value="Découpage">Découpage</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label>Prime de rendement</label>
                                                                            <input type="number" class="form-control" name="rend">
                                                                        </div>
                                                                        <button type="submit" class="btn-block btn btn-primary waves-effect waves-light ">Modifier</button>
                                                                    </form>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Annuler</button>
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
                                        <?php if (!empty($column)): ?>
                                            <?php for ($cpt_col = 1; $cpt_col <= $column; $cpt_col++): ?>
                                                <th>Tâche <?= $cpt_col ?></th>
                                            <?php endfor; ?>
                                        <?php endif; ?>
                                        <th></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h4>Liste des rdv</h4>
                    </div>
                        <section id="timeline">
                            <article>
                                <div class="inner">
                                      <span class="date">
                                        <span class="day">30<sup>th</sup></span>
                                        <span class="month">Jan</span>
                                <!--        <span class="year">2014</span>-->
                                      </span>
                                    <h2>The Title</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean quis rutrum nunc, eget dictum massa. Nam faucibus felis nec augue adipiscing, eget commodo libero mattis.</p>
                                </div>
                            </article>
                            <article>
                                <div class="inner">
                                      <span class="date">
                                        <span class="day">26<sup>th</sup></span>
                                        <span class="month">Jan</span>
                                <!--        <span class="year">2014</span>-->
                                      </span>
                                    <h2>The Title</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean quis rutrum nunc, eget dictum massa. Nam faucibus felis nec augue adipiscing, eget commodo libero mattis.</p>
                                </div>
                            </article>
                            <article>
                                <div class="inner">
                                  <span class="date">
                                    <span class="day">26<sup>th</sup></span>
                                    <span class="month">Jan</span>
                                    <span class="year">2014</span>
                                  </span>
                                    <h2>The Title</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean quis rutrum nunc, eget dictum massa. Nam faucibus felis nec augue adipiscing, eget commodo libero mattis.</p>
                                </div>
                            </article>
                            <article>
                                <div class="inner">
                                  <span class="date">
                                    <span class="day">26<sup>th</sup></span>
                                    <span class="month">Jan</span>
                                    <span class="year">2014</span>
                                  </span>
                                    <h2>The Title</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean quis rutrum nunc, eget dictum massa. Nam faucibus felis nec augue adipiscing, eget commodo libero mattis.</p>
                                </div>
                            </article>
                            <article>
                                <div class="inner">
                                  <span class="date">
                                    <span class="day">26<sup>th</sup></span>
                                    <span class="month">Jan</span>
                                    <span class="year">2014</span>
                                  </span>
                                    <h2>The Title</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean quis rutrum nunc, eget dictum massa. Nam faucibus felis nec augue adipiscing, eget commodo libero mattis.</p>
                                </div>
                            </article>
                        </section>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
$footer = '';
require 'views/partials/template.php';
?>
