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
                    <a href="<?= URL ?>utilisateur/ajouter"><button class="btn btn-outline-info btn-lg">Ajouter <i class="fa fa-user-plus"></i></button></a>
                    <?php if ( ($_SESSION['role']=='super_admin') ): ?>
                        <button id="btnUserConnected" class="btn btn-outline-warning btn-lg">Déconnexion <i class="fa fa-user-plus"></i></button>
                    <?php endif; ?>

                    <span>Liste des utilisateurs</span>
                </div>
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="<?= URL ?>accueil">
                                <i class="icofont icofont-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item"><a href="<?= URL ?>utilisateur">Utilisateur</a>
                        </li>
                        <li class="breadcrumb-item"><a href="<?= URL ?>utilisateur">Consulter</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Page-header end -->
            <!-- Page-body start -->
            <div class="page-body">
                <div class="row">
                    <div class="col-sm-12">
                        <!-- Zero config.table start -->
                        <div class="card">
                            <div class="card-block">
                                <div class="dt-responsive table-responsive">
                                    <table id="simpletable" class="table table-striped table-bordered nowrap">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nom</th>
                                            <th>Prénoms</th>
                                            <th>Contact</th>
                                            <th>Nom d'utilisateur</th>
                                            <th>CNIB recto</th>
                                            <th>CNIB verso</th>
                                            <th>Image</th>
                                            <th>Rôle</th>
                                            <th>En ligne</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(!empty($users) && $users != NULL ): ?>
                                            <?php $i=1; foreach ($users as $user):
                                                $color = ($user->getConnectedUser() == 1)? 'success': 'danger';
                                                $value = ($user->getConnectedUser() == 1)? 'Connecté': 'Déconnecté';
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?= $i ?>
                                                        <?php if ( ($_SESSION['role']=='super_admin') ): ?>
                                                            <input type="checkbox" value="<?= $user->getIdUser()  ?>" id="idUser" >
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= $user->getNomUser() ?></td>
                                                    <td><?= $user->getPrenomUser() ?></td>
                                                    <td><?= $user->getContactUser() ?></td>
                                                    <td><?= $user->getUsernameUser() ?></td>
                                                    <td>
                                                        <img src="<?= URL ?>/public/image/user/<?= $user->getCnibRectoUser() ?>" alt="" width="100" height="100" class="img-thumbnail"   data-toggle="modal" data-target="#recto-<?= $user->getIdUser() ?>"/>
                                                    </td>
                                                    <td>
                                                        <img src="<?= URL ?>/public/image/user/<?= $user->getCnibVersoUser() ?>" alt="" width="100" height="100" class="img-thumbnail"   data-toggle="modal" data-target="#verso-<?= $user->getIdUser() ?>"/>
                                                    </td>
                                                    <td>
                                                        <img src="<?= URL ?>/public/image/user/<?= $user->getImageUser() ?>" alt="" width="100" height="100" class="img-thumbnail"   data-toggle="modal" data-target="#image-<?= $user->getIdUser() ?>"/>
                                                    </td>
                                                    
                                                    <td><?= $user->getRoleUser() ?></td>
                                                    <td>
                                                        <input type="button" value="<?= $value ?>" class= "btn btn-<?= $color?> " >

                                                    </td>
                                                    <td>
                                                        <?php if ( ($_SESSION['role']=='super_admin') || $_SESSION['id']==$user->getIdUser())  :?>
                                                        <a href="<?= URL ?>utilisateur/modifier/<?= $user->getIdUser() ?>">
                                                            <button class="btn btn-success btn-md text-light"><i class="icofont icofont-pencil-alt-5"></i></button>
                                                        </a>
                                                        <a href="<?= URL ?>utilisateur/detail/<?=$user->getIdUser() ?>">
                                                            <button class="btn btn-info btn-md"><i class="icofont icofont-plus-circle"></i></button>
                                                        </a>
                                                        <?php endif;?>
                                                        <?php if ( $_SESSION['role']=='super_admin')  :?>
                                                        <form class="d-inline" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer ?');" action="<?= URL ?>utilisateur/sv/<?= $user->getIdUser() ?>" >
                                                            <button id="btn-delete-form" class="btn btn-danger btn-md" type="submit"><i class="icofont icofont-trash"></i></button>
                                                        </form>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <!-- Modal -->
                                                <div class="modal fade" id="recto-<?= $user->getIdUser() ?>" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <img src="<?= URL?>public/image/user/<?= $user->getCnibRectoUser() ?>" class="img-responsive"  width="780px">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Fermer</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal -->

                                                <!-- Modal -->
                                                <div class="modal fade" id="verso-<?= $user->getIdUser() ?>" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <img src="<?= URL?>public/image/user/<?= $user->getCnibVersoUser() ?>" class="img-responsive"  width="780px">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Fermer</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal -->

                                                     <!-- Modal -->
                                                     <div class="modal fade" id="image-<?= $user->getIdUser() ?>" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <img src="<?= URL?>public/image/user/<?= $user->getImageUser() ?>" class="img-responsive"  width="780px">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Fermer</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal -->
                                            <?php $i++; endforeach; ?>
                                        <?php endif; ?>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Nom</th>
                                            <th>Prénoms</th>
                                            <th>Contact</th>
                                            <th>Nom d'utilisateur</th>
                                            <th>Rôle</th>
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
    <script src="<?= URL ?>public/assets/js/cdn/sweetarlert.js"></script>
    <script>
        $(document).ready(function (){

            $('#btnUserConnected').click(function (){
                var user = [];
                $('input[id="idUser"]').map(function () {
                    if(this.checked){
                        user.push(this.value) ; // $(this).val()
                    }
                });
                $.post(
                    '<?= URL ?>utilisateur/unloged',
                    {
                        user:user
                    },
                    function(response)
                    {
                        swal({
                            title: "Bravo",
                            text: "Utilisateur déconnecté avec succès!",
                            icon: "success"
                        }).then(function() {
                            window.location ="<?= URL ?>utilisateur";
                        });
                });
            });
            return false;

        });
    </script>
<?php
$footer = ob_get_clean();
require "views/partials/template.php";
?>