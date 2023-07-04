<?php ob_start();
?>
<!-- Data Table Css -->
<link rel="stylesheet" type="text/css" href="<?= URL ?>public/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="<?= URL ?>public/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="<?= URL ?>public/bower_components/owl.carousel/css/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="<?= URL ?>public/bower_components/owl.carousel/css/owl.theme.default.css">
<?php
$header = ob_get_clean();
ob_start();
?>
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Infos client</h4>
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
                    <li class="breadcrumb-item"><a href="<?= URL ?>client/info/<?= $client->getIdClient()?>">Infos</a>
                    </li>
                    <li class="breadcrumb-item"><?= $client->getNomClient()?></li>
                    <li class="breadcrumb-item"><?= $client->getPrenomClient()?></li>
                </ul>
            </div>
        </div>
        <!-- Page header end -->
        <!-- Page body start -->
        <div class="page-body">
<!--            <button class="btn btn-outline-success btn-lg btn-block rounded-circle m-2">RDV</button>-->
                <!-- Basic Form Inputs card start -->
                <div class="card">
                    <div class="card-block">
                        <div class="sub-title">
                            <?php if($_SESSION['role'] == 'super_admin'): ?>
                            <a href="<?= URL ?>client/info/<?= $client->getIdClient() ?>/statistique/<?= date("Y") ?>"><button class="btn btn-outline-primary"> Statistique</button></a>
                            <a href="<?= URL ?>client/info/<?= $client->getIdClient() ?>/recommandation"><button class="btn btn-outline-success"> Recommandation</button></a>
                      <?php endif; ?>
                        </div>
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs  tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#Mesure" role="tab">Mesure</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#Tissu" role="tab">Tissu</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#Commande" role="tab">Commande</a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabs card-block">
                            <div class="tab-pane" id="Mesure" role="tabpanel">
                                <a href="<?= URL ?>client/info/<?=$client->getIdClient() ?>/mesure_ajouter"><button class="btn btn-outline-info btn-lg btn-block">Ajouter Mesure</button></a>
                                <div class="table-responsive card-block">
                                    <table class="table table-bordered table-condensed">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Epaule</th>
                                            <th>Poitrine</th>
                                            <th>Ceinture</th>
                                            <th>Bas</th>
                                            <th>Long Chemise</th>
                                            <th>Long Pantalon</th>
                                            <th>Cuisse</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (isset($mesures)): ?>
                                                <?php $j=1; foreach ($mesures as $mesure): ?>
                                                    <tr>
                                                        <th scope="row"><?= $j++?></th>
                                                        <td><?= date("d-m-Y",strtotime($mesure->getCreatMesure()))  ?></td>
                                                        <td><?= $mesure->getEpauleMesure() ?></td>
                                                        <td><?= $mesure->getPoitrineMesure() ?></td>
                                                        <td><?= $mesure->getCeintureMesure() ?></td>
                                                        <td><?= $mesure->getBasMesure() ?></td>
                                                        <td><?= $mesure->getLChemiseMesure() ?></td>
                                                        <td><?= $mesure->getLPantalonMesure() ?></td>
                                                        <td><?= $mesure->getCuisseMesure() ?></td>
                                                        <td>
                                                            <a href="<?= URL ?>client/info/<?=$client->getIdClient() ?>/mesure_modifier/<?= $mesure->getIdMesure() ?>">
                                                                <button class="btn btn-success btn-md text-light"><i class="icofont icofont-pencil-alt-5"></i></button>
                                                            </a>
                                                            <a href="<?= URL ?>client/info/<?=$client->getIdClient() ?>/mesure/<?= $mesure->getIdMesure() ?>">
                                                                <button class="btn btn-info btn-md"><i class="icofont icofont-plus-circle"></i></button>
                                                            </a>
                                                            <?php if($_SESSION['role'] == 'super_admin'): ?>
                                                            <form class="d-inline" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer ?');" action="<?= URL ?>client/info/<?= $client->getIdClient() ?>/mesure_sv/<?= $mesure->getIdMesure() ?>" >
                                                                <button id="btn-delete-mesure-form" class="btn btn-danger btn-md" type="submit"><i class="icofont icofont-trash"></i></button>
                                                            </form>
                                                        <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif;  ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div  class="tab-pane active" id="Tissu" role="tabpanel" >
                                <a href="<?= URL ?>client/info/<?= $client->getIdClient() ?>/tissu_ajouter"><button class="btn btn-outline-info btn-lg btn-block">Ajouter Tissu</button></a>
                                <div class="table-responsive card-block ">
                                    <table class="table table-bordered table-condensed"">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Type de tissu</th>
                                            <th>Description</th>
                                            <th>Image</th>
                                            <th>Statut</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($tissus)): ?>
                                                    <?php $jt = 1; foreach ($tissus as $tissu) :
                                                        $images = $this->tissuImageManager->getImagesTissu($tissu);
                                                        $color = (!empty($images))? 'primary': 'danger';
                                                    ?>
                                                    <tr>
                                                        <th scope="row"><?= $jt ?></th>
                                                        <td><?= date("d-m-Y",strtotime($tissu->getCreatTissu()))  ?></td>
                                                        <td><?= $tissu->getNomTissu()  ?></td>
                                                        <td><?= $tissu->getDescTissu()  ?></td>
                                                        <td>
                                                                <button class="btn btn-<?= $color ?>" data-toggle="modal" data-target="#large-<?= $tissu->getIdTissu() ?>">Image</button>
                                                        </td>
                                                        <td>
                                                        <?php if($tissu->getStatutTissu() == 0)
                                                        {?>
                                                            <button class="btn btn-success">Actif</button>
                                                        <?php
                                                        }elseif($tissu->getStatutTissu() ==1 )
                                                        {?>
                                                            <button class="btn btn-danger">Inactif</button>
                                                        <?php
                                                        } ?>
                                                        </td>
                                                        <td>
                                                            <a href="<?= URL ?>client/info/<?=$client->getIdClient() ?>/tissu_modifier/<?= $tissu->getIdTissu() ?>">
                                                                <button class="btn btn-success btn-md text-light"><i class="icofont icofont-pencil-alt-5"></i></button>
                                                            </a>
                                                            <a href="<?= URL ?>client/info/<?=$client->getIdClient() ?>/tissu/<?= $tissu->getIdTissu() ?>">
                                                                <button class="btn btn-info btn-md"><i class="icofont icofont-plus-circle"></i></button>
                                                            </a>
                                                            <?php if($_SESSION['role'] == 'super_admin'): ?>
                                                            <form class="d-inline" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer ?');" action="<?= URL ?>client/info/<?= $client->getIdClient() ?>/tissu_sv/<?= $tissu->getIdTissu() ?>" >
                                                                <button id="btn-delete-mesure-form" class="btn btn-danger btn-md" type="submit"><i class="icofont icofont-trash"></i></button>
                                                            </form>
                                                       <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                    <!-- Modal-->
                                                    <div class="modal fade" id="large-<?= $tissu->getIdTissu() ?>" tabindex="-1" role="dialog">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5>Image des tissus</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="owl-carousel carousel-nav owl-theme">
                                                                        <?php if(!empty($images)): ?>
                                                                            <?php foreach ($images as $img): ?>
                                                                                <div>
                                                                                    <img src="<?= URL ?>public/image/tissu/<?= $nomDossierclient ?>/<?= $img->getImageTissu() ?>" class="img-thumbnail"  width="100" height="100" alt=""  >
                                                                                </div>
                                                                            <?php endforeach; ?>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Fermer</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End Modal-->
                                                <?php $jt++; endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="Commande" role="tabpanel">
                                <a href="<?= URL ?>client/info/<?= $client->getIdClient() ?>/commande_ajouter"><button class="btn btn-outline-info btn-lg btn-block">Ajouter Commande</button></a>
                                <div class="dt-responsive table-responsive">
                                    <table class="table table-striped table-bordered nowrap">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <?php if ( $_SESSION['role']=='super_admin'):?>
                                            <th>Montant</th>
                                            <?php endif; ?>
                                            <th>Description</th>
                                            <th>Date de RDV</th>
                                            <th>Statut</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (isset($commandesClient)): ?>
                                                <?php $i=1; foreach ($commandesClient as $commande): ?>
                                                    <tr>
                                                        <td><?= $i ?></td>
                                                        <td><?=  date("d-m-Y" ,strtotime($commande['commande']->getCreatCommande())) ?></td>
                                                        <?php if ($_SESSION['role']=='super_admin'):?>
                                                        <td><?= $commande['total'] ?></td>
                                                        <?php endif; ?>
                                                        <td><?= $commande['commande']->getDescCommande() ?></td>
                                                        <td><?= date("d-m-Y" ,strtotime($commande['commande']->getRdvCommande())) ?></td>
                                                        <td>
                                                            <?php if($commande['commande']->getStatutCommande() == 0){
                                                            ?>
                                                                <button class="btn btn-success">Actif</button>
                                                            <?php
                                                            }else{
                                                            ?>
                                                                <button class="btn btn-danger">Inactif</button>
                                                            <?php
                                                            } ?>
                                                        </td>
                                                        <td>
                                                            <a href="<?= URL ?>client/info/<?= $client->getIdClient() ?>/commande_affecter/<?= $commande['commande']->getIdCommande() ?>">
                                                                <button type="button" class="btn btn-dark btn-md text-light"><i class="fa fa-eye"></i></button>
                                                            </a> <a href="<?= URL ?>client/info/<?= $client->getIdClient() ?>/paiement_ajouter/<?= $commande['commande']->getIdCommande() ?>">
                                                                <button class="btn btn-warning btn-md text-light"><i class="fa fa-money"></i></i></button>
                                                            </a>
                                                            <a href="<?= URL ?>client/info/<?= $client->getIdClient() ?>/commande_modifier/<?= $commande['commande']->getIdCommande() ?>">
                                                                <button class="btn btn-success btn-md text-light"><i class="icofont icofont-pencil-alt-5"></i></button>
                                                            </a>
                                                            <a href="<?= URL ?>client/info/<?= $client->getIdClient() ?>/commande/<?= $commande['commande']->getIdCommande() ?>">
                                                                <button class="btn btn-info btn-md"><i class="icofont icofont-plus-circle"></i></button>
                                                            </a>
                                                            <?php if($_SESSION['role'] == 'super_admin'): ?>
                                                            <form class="d-inline" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer ?');" action="<?= URL ?>client/info/<?= $client->getIdClient() ?>/commande_sv/<?=  $commande['commande']->getIdCommande() ?>" >
                                                                <button class="btn btn-danger btn-md"><i class="icofont icofont-trash"></i></button>
                                                            </form>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php $i++; endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Montant</th>
                                            <th>Description</th>
                                            <th>Date de RDV</th>
                                            <th>Statut</th>
                                            <th></th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Basic Form Inputs card end -->
            </div>
        </div>
        <!-- Page body end -->
    </div>
</div>

<?php $content = ob_get_clean();
ob_start();
?>
<!-- data-table js -->
<script src="<?= URL ?>public/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= URL ?>public/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= URL ?>public/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= URL ?>public/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<!-- owl carousel 2 js -->
<script type="text/javascript" src="<?= URL ?>public/bower_components/owl.carousel/js/owl.carousel.min.js"></script>
<script type="text/javascript" src="<?= URL ?>public/assets/js/owl-custom.js"></script>
<?php
$footer = ob_get_clean();
require "views/partials/template.php";
?>


