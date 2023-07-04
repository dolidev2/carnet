<?php ob_start();
?>
    <!-- Data Table Css -->
    <link rel="stylesheet" type="text/css" href="<?= URL ?>public/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="<?= URL ?>public/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">
<?php
$header = ob_get_clean();
ob_start();
?>
    <!--body-->
    <div class="main-body">
        <div class="page-wrapper">
            <!-- Page-header start -->
            <div class="page-header">
                <div class="page-header-title">
                    <span>Liste des commandes en cours</span>
                </div>
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="<?= URL ?>accueil">
                                <i class="icofont icofont-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item"><a href="<?= URL ?>commande">Commande</a>
                        </li>
                        <li class="breadcrumb-item"><a href="<?= URL ?>commande">Programme</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Page-header end -->
            <!-- Page-body start -->
            <div class="page-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-block">
                                <form method="post"  action="<?= URL ?>commande/periode">
                                    <div class="row mb-3">
                                        <h5  class="col-sm-4 offset-sm-4 form-label">Période du programme</h5>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 col-md-4">
                                            <div class="row form-group">
                                                <label class="col-sm-4 form-label">Date de début</label>
                                                <input type="date" id="nom" name="dt_debut" class="form-control col-sm-8">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <div class="row form-group">
                                                <label class="col-sm-4 form-label">Date de fin</label>
                                                <input type="date" id="nom" name="dt_fin" class="form-control col-sm-8">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <div class="row form-group">
                                                <div class="col-sm-12">
                                                    <button class="btn btn-primary" type="submit">Valider</button>
                                                    <button class="btn btn-danger" type="reset">Annuler</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <!-- Zero config.table start -->
                        <div class="card">
                            <div class="card-block">
                                <button class="btn-block m-2 btn btn-toolbar-primary" data-toggle="modal" data-target="#affecter-Modal">Affecter</button>
                                <div class="dt-responsive table-responsive">
                                    <form method="post" action="<?= URL ?>commande/av">
                                    <table  class="table table-striped table-bordered ">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Commande</th>
                                            <th>Client</th>
                                            <th>Date de Création</th>
                                            <th>Date RDV</th>
                                            <th>#</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (!empty($data)): ?>
                                            <?php
                                                $i=1;
                                                for ($cpt =0;$cpt < count($data); $cpt++):
                                                    if (!empty($data[$cpt]['rdv'])):
                                                        $date = date("d-m-Y",strtotime( $data[$cpt]['rdv'] ));
                                                        $color = 'warning';
                                                    elseif($data[$cpt]['commande']['rdv_commande'] >= date("Y-m-d")):
                                                        $date = date("d-m-Y",strtotime( $data[$cpt]['commande']['rdv_commande'] ));
                                                        $color = 'success';
                                                    else:
                                                        $date = date("d-m-Y",strtotime( $data[$cpt]['commande']['rdv_commande'] ));
                                                        $color = 'danger';
                                                    endif;
                                            ?>
                                                <tr>
                                                <td><?= $i ?></td>
                                                <td><?= $data[$cpt]['commande']['desc_commande'] ?></td>
                                                <td><?= $data[$cpt]['commande']['nom_client']. ' '.$data[$cpt]['commande']['prenom_client'].' '.$data[$cpt]['commande']['contact_client'] ?></td>
                                                <td><?= date("d-m-Y",strtotime( $data[$cpt]['commande']['creat_commande'] ))?></td>
                                                <td> <button class="btn btn-<?= $color ?>"> <?= $date ?> </button> </td>
                                                <td></td>
                                                </tr>
                                                <?php if(!empty($data[$cpt]['articles'])):
                                                        $j=0;
                                                        for ($cp=0; $cp < count($data[$cpt]['articles']);$cp++):
                                                            $colorCheckDecoup = ($data[$cpt]['articles'][$cp]['qte_prod_decoup'] >= $data[$cpt]['articles'][$cp]['quantite_cmt'])  ? 'bg-warning': '';
                                                            if ($j == 0): ?>
                                                        <tr>
                                                            <th>Modele</th>
                                                            <th>Tissu</th>
                                                            <th>Prix</th>
                                                            <th>Quantité</th>
                                                            <th>total</th>
                                                            <th></th>
                                                        </tr>
                                                    <?php endif; ?>
                                                        <tr>
                                                            <td><?= $data[$cpt]['articles'][$cp]['nom_modele']  ?></td>
                                                            <td><?= $data[$cpt]['articles'][$cp]['nom_tissu']  ?></td>
                                                            <td><?= $data[$cpt]['articles'][$cp]['prix_modele']  ?></td>
                                                            <td><?=  ($data[$cpt]['articles'][$cp]['quantite_cmt'] - $data[$cpt]['articles'][$cp]['qte_prod'] ) ?></td>
                                                            <td><?= $data[$cpt]['articles'][$cp]['prix_cmt']  ?></td>
                                                            <td class="<?= $colorCheckDecoup ?>">
                                                                <input type="checkbox" name="programme[]" value="<?= $data[$cpt]['articles'][$cp]['id_cmt'] ?>" class="form-control">
                                                            </td>
                                                        </tr>
                                                    <?php $j++; endfor; ?>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Commande</th>
                                                        <th>Client</th>
                                                        <th>Date de Création</th>
                                                        <th>Date RDV</th>
                                                        <th>#</th>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php  $i++; endfor; ?>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Affecter-->
                        <div class="modal fade" id="affecter-Modal" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Affecter les tâches à un personnel</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Type</label>
                                                <div class="col-sm-10">
                                                    <select  name="type[]" class="form-control" >
                                                        <option value="Montage" selected>Montage</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Personnel</label>
                                                <div class="col-sm-10">
                                                    <select  name="personnel[]" class="form-control" >
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
                                                <label class="col-sm-2 col-form-label">Quantité</label>
                                                <div class="col-sm-10">
                                                    <input type="number" name="quantite[]" placeholder="Entrez la quantité"  class="form-control">
                                                </div>
                                            </div>
                                            <hr>
                                        </div>

                                        <div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Type</label>
                                                <div class="col-sm-10">
                                                    <select  name="type[]" class="form-control" >
                                                        <option value="Découpage" selected>Découpage</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Personnel</label>
                                                <div class="col-sm-10">
                                                    <select  name="personnel[]" class="form-control" >
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
                                                <label class="col-sm-2 col-form-label">Quantité</label>
                                                <div class="col-sm-10">
                                                    <input type="number"  name="quantite[]" class="form-control" placeholder="Entrez la quantité">
                                                </div>
                                            </div>
                                            <hr>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button  class="btn btn-primary waves-effect " type="submit">Valider</button>
                                        <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Annuler</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--End modal-->
                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <!-- Zero config.table start -->
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
                                                    <?php
                                                        foreach ($dt['travail'] as $tache):
                                                            if(isset($tache['rdv']) && !empty($tache['rdv'])):
                                                                $color = 'warning';
                                                            elseif ( $tache['rdv_commande'] >= date("Y-m-d")):
                                                                $color = 'success';
                                                            elseif($tache['rdv_commande'] < date("Y-m-d")):
                                                                $color = 'danger';
                                                            endif;
                                                    ?>
                                                        <td>
                                                                <button class="btn btn-<?= $color ?>" data-toggle="modal" data-target="#infos-Modal<?= $tache['id_prod'] ?>">
                                                                    <span><?= $tache['nom_client'].' '.$tache['prenom_client'] ?></span> <br>
                                                                    <span><?= $tache['desc_commande'] ?></span> <br>
                                                                    <span><?= $tache['nom_modele'] ?></span><br>
                                                                    <span>Quantité: <?= $tache['quantite_prod'] ?></span><br>
                                                                    <span><?= date("d-m-Y", strtotime($tache['rdv_commande'] )) ?></span><br>
                                                                    <span><?= $tache['desc_prod'] ?></span><br>
                                                                </button><br>
                                                                <button class="btn btn-success btn-md text-light  mt-1" data-toggle="modal" data-target="#prod-Modal<?=  $tache['id_prod'] ?>"><i class="icofont icofont-pencil-alt-5"></i></button>
                                                            <?php if($_SESSION['agence_role']== 'Principale' && $_SESSION['role'] == 'admin'): ?>
                                                                <form class="d-inline" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer ?');" action="<?= URL ?>commande/sv/<?=$tache['id_prod'] ?>">
                                                                    <button id="btn-delete-mesure-form" class="btn btn-danger btn-md  mt-1" type="submit"><i class="icofont icofont-trash"></i></button>
                                                                </form>
                                                            <?php endif; ?>

                                                        </td>
                                                        <td>
                                                          <button class="btn btn-info btn-md text-light  mt-1" data-toggle="modal" data-target="#pdf-Modal<?=  $tache['id_prod'] ?>"><i class="icofont icofont-printer"></i></button>
                                                        </td>
                                                        <!-- Modal Reaffecter-->
                                                        <div class="modal fade" id="infos-Modal<?= $tache['id_prod'] ?>" tabindex="-1" role="dialog">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Détail sur la tache</h4>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div>
                                                                            <a href="<?= URL ?>commande/cloturer/<?= $tache['id_prod'] ?>">
                                                                                <button class="btn btn-success btn-block m-2"> Terminer</button>
                                                                            </a>
                                                                            <div class="form-group row">
                                                                                <div class="col-sm-5">
                                                                                    <label for="check_form" class="form-label">Cochez pour plus de détail</label>
                                                                                    <input type="checkbox" class="form-control" id="check_form">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div id="form_detail">
                                                                            <hr>
                                                                            <form method="post"  action="<?= URL ?>commande/reporter/<?= $tache['id_commande'] ?>">
                                                                                <div class="form-group row">
                                                                                    <label class="col-sm-4 col-form-label">Description</label>
                                                                                    <div class="col-sm-8">
                                                                                        <input type="text"   rows="4" class="form-control" placeholder="Entrez le motif" name="desc">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label class="col-sm-4 col-form-label">Date report RDV</label>
                                                                                    <div class="col-sm-8">
                                                                                        <input type="date" name="date_report" class="form-control" required>
                                                                                    </div>
                                                                                </div>
                                                                                <button type="submit" class="btn-block btn btn-danger waves-effect waves-light ">Reporter</button>
                                                                            </form>
                                                                            <hr>
                                                                            <form method="post"  action="<?= URL ?>commande/ava">
                                                                                <div class="form-group row">
                                                                                    <label class="col-sm-4 col-form-label">Personnel</label>
                                                                                    <div class="col-sm-8">
                                                                                        <input type="hidden" value="<?= $tache['id_cmt'] ?>" name="id_cmt">
                                                                                        <input type="hidden" value="<?= $tache['id_prod'] ?>" name="id_prod">
                                                                                        <select  name="personnel" class="form-control" required>
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
                                                                                    <label class="col-sm-4 col-form-label">Type</label>
                                                                                    <div class="col-sm-8">
                                                                                        <select  name="type" class="form-control" required>
                                                                                            <option value="<?= $tache['desc_prod']?>" selected><?= $tache['desc_prod']?></option>
                                                                                            <option value="Montage">Montage</option>
                                                                                            <option value="Découpage">Découpage</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label class="col-sm-4 col-form-label">Montant à verser</label>
                                                                                    <div class="col-sm-8">
                                                                                        <input type="number" class="form-control" name="somme" required>
                                                                                    </div>
                                                                                </div>
                                                                                <button type="submit" class="btn-block btn btn-primary waves-effect waves-light ">Réaffecter</button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Annuler</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--End modal-->

                                                        <!--      Programme PDF  -->
                                                            <div class="modal fade" id="pdf-Modal<?= $tache['id_prod'] ?>" tabindex="-1" role="dialog">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title">Choisir la période</h4>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form method="post" action="<?= URL ?>personnel/programme/<?= $tache['id_pers']?>">
                                                                                <div class="form-group">
                                                                                    <div>
                                                                                        <label for="form-label"> Date de début</label>
                                                                                        <input type="date" name="dt_debut" class="form-control" required>
                                                                                    </div>
                                                                                    <div>
                                                                                        <label for="form-label"> Date de fin</label>
                                                                                        <input type="date" name="dt_fin" class="form-control" required>
                                                                                    </div>
                                                                                    <br>
                                                                                    <button class="btn btn-primary" type="submit">Valider</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Annuler</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--      Programme PDF  -->

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
                                                                                <label class="col-sm-5 col-form-label">Personnel</label>
                                                                                <div class="col-sm-7">
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
                                                                                <label class="col-sm-5 col-form-label">Type</label>
                                                                                <div class="col-sm-7">
                                                                                    <select  name="type" class="form-control">
                                                                                        <option value="<?= $tache['desc_prod'] ?>" selected><?= $tache['desc_prod'] ?></option>
                                                                                        <option value="Montage">Montage</option>
                                                                                        <option value="Découpage">Découpage</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-5 col-form-label">Prime de rendement</label>
                                                                                <div class="col-sm-7">
                                                                                    <input type="number" class="form-control" name="rend">
                                                                                </div>
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
            <!-- Page-body end -->
        </div>
    </div>
    <!--end Body-->
<?php $content = ob_get_clean() ;
ob_start();
?>
    <!-- data-table js -->
    <script src="<?= URL ?>public/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?= URL ?>public/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= URL ?>public/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= URL ?>public/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function (){
            $('#form_detail').hide();
            $('input[id=check_form]').click(function ()
            {
                var checkbox = this.checked;
                if(checkbox)
                {
                    $('#form_detail').show();
                }else{
                    $('#form_detail').hide();
                }
            });
        });
    </script>
<?php
$footer = ob_get_clean();
require "views/partials/template.php";
?>