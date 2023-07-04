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
                    <div class="mb-1 row" >
                        <button class="btn btn-outline-info btn-lg mr-1" data-toggle="modal" data-target="#stock-Modal">Ajouter <i class="fa fa-user-plus"></i></button>
                           <a href="<?= URL ?>stock/periode">
                               <button class="btn btn-outline-success btn-lg">Période</button>
                           </a>
                        <button class="btn btn-outline-primary btn-lg ml-1" data-toggle="modal" data-target="#ressource-Modal">Ressource</button>
                    </div>
                    <span>Liste des entrées et sorties </span>
                </div>
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="<?= URL ?>accueil">
                                <i class="icofont icofont-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item"><a href="<?= URL ?>stock">Paramètre</a>
                        </li>
                        <li class="breadcrumb-item"><a href="<?= URL ?>stock">Stock</a>
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
                        <div class="mb-1 row" >
                            <button class="btn btn-primary col-sm-12 col-md-3 m-1" id="btn_entre" >Entrée</button>
                            <button class="btn btn-info col-sm-12 col-md-3 m-1" id="btn_sortie">Sortie</button>
                            <button class="btn btn-success col-sm-12 col-md-3 m-1" id="btn_etat">Etat</button>
                        </div>
                        <div class="card" id="table_etat">
                            <h5>Liste des entrées/sorties</h5>
                            <div class="card-block">
                                <div class="dt-responsive table-responsive">
                                    <table id="simpletable" class="table table-striped table-bordered nowrap">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Ressource</th>
                                            <th>Prix en Gros</th>
                                            <th>Prix au Détail</th>
                                            <th>Quantité</th>
                                            <th>Description</th>
                                            <th>Type</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (isset($stocks) && !empty($stocks)): ?>
                                            <?php $i=1; foreach ($stocks as $stock):?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $stock['nom_res'] ?></td>
                                                    <td><?= $stock['prix_g_stock'] ?></td>
                                                    <td><?= $stock['prix_d_stock'] ?></td>
                                                    <td><?= $stock['quantite_stock'] ?></td>
                                                    <td><?= $stock['desc_stock'] ?></td>
                                                    <td>
                                                        <?php if ($stock['type_stock'] == 'entre'): ?>
                                                            <button class="btn btn-success">Entrée</button>
                                                        <?php elseif ($stock['type_stock'] == 'sortie'): ?>
                                                            <button class="btn btn-danger">Sortie</button>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                            <button class="btn btn-success btn-md text-light" data-toggle="modal" data-target="#mod-Modal<?= $stock['id_stock'] ?>" ><i class="icofont icofont-pencil-alt-5"></i></button>
                                                            <button class="btn btn-info btn-md"><i class="icofont icofont-plus-circle"></i></button>
                                                        <?php if ($_SESSION['role']=='admin' || $_SESSION['role']=='super_admin'):?>
                                                            <form class="d-inline" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer ?');" action="<?= URL ?>stock/sv/<?=  $stock['id_stock'] ?>" >
                                                                <button id="btn-delete-form" class="btn btn-danger btn-md" type="submit"><i class="icofont icofont-trash"></i></button>
                                                            </form>
                                                        <?php endif;?>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="mod-Modal<?= $stock['id_stock'] ?>" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Modifier la ligne de stock</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="post" action="<?= URL ?>stock/mv">
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-4 col-form-label">Prix En Gros</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="number" step="0.01" name="prix_g" id="prix_g" value="<?= $stock['prix_g_stock'] ?>" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-4 col-form-label">Prix Au Détail</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="number" step="0.01"  name="prix_d" id="prix_d" value="<?= $stock['prix_d_stock'] ?>" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-4 col-form-label">Quantité</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="number"  step="0.01" name="qte_stock" id="qte_stock" value="<?= $stock['quantite_stock'] ?>" class="form-control">
                                                                            <input type="hidden"  name="id_stock" id="id_stock" value="<?= $stock['id_stock'] ?>" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-4 col-form-label">Description</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text"  name="desc" id="desc" value="<?= $stock['desc_stock']  ?>" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-4 col-form-label">Type</label>
                                                                        <div class="col-sm-8">
                                                                            <select name="type_stock" id="type_stock" class="form-control">
                                                                                <?php if ($stock['type_stock'] == 'entre'): ?>
                                                                                    <option value="entre" selected>Entrée</option>
                                                                                <?php else: ?>
                                                                                    <option value="sortie" selected>Sortie</option>
                                                                                <?php endif; ?>
                                                                                <option value="entre">Entrée</option>
                                                                                <option value="sortie">Sortie</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-4 col-form-label">Ressource</label>
                                                                        <div class="col-sm-8">
                                                                            <select name="ressource" id="ressource" class="form-control">
                                                                                <option value="<?= $stock['id_res'] ?>" selected><?= $stock['nom_res'] ?></option>
                                                                                <?php if(isset($ressource) && !empty($ressource)):  ?>
                                                                                    <?php foreach ($ressource as $res): ?>
                                                                                        <option value="<?= $res->getIdRes() ?>"><?= $res->getNomRes() ?></option>
                                                                                    <?php endforeach; ?>
                                                                                <?php endif; ?>
                                                                            </select>
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
                                            <?php $i++; endforeach; ?>
                                        <?php endif; ?>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Ressource</th>
                                            <th>Prix en Gros</th>
                                            <th>Prix au Détail</th>
                                            <th>Quantite</th>
                                            <th>Description</th>
                                            <th>Type</th>
                                            <th></th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- End Table Etat     -->
                        <!-- Entre Table    -->
                        <div class="card" id="table_entre">
                            <h5>Liste des entrées</h5>
                            <div class="card-block">
                                <div class="dt-responsive table-responsive">
                                    <table id="simpletable" class="table table-striped table-bordered nowrap">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Ressource</th>
                                            <th>Prix en Gros</th>
                                            <th>Prix au Détail</th>
                                            <th>Quantite</th>
                                            <th>Description</th>
                                            <th>Type</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (isset($entres) && !empty($entres)): ?>
                                            <?php $i=1; foreach ($entres as $stock):?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $stock['nom_res'] ?></td>
                                                    <td><?= $stock['prix_g_stock'] ?></td>
                                                    <td><?= $stock['prix_d_stock'] ?></td>
                                                    <td><?= $stock['quantite_stock'] ?></td>
                                                    <td><?= $stock['desc_stock'] ?></td>
                                                    <td>
                                                        <?php if ($stock['type_stock'] == 'entre'): ?>
                                                            <button class="btn btn-success">Entrée</button>
                                                        <?php elseif ($stock['type_stock'] == 'sortie'): ?>
                                                            <button class="btn btn-danger">Sortie</button>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-success btn-md text-light" data-toggle="modal" data-target="#mod-Modal<?= $stock['id_stock'] ?>" ><i class="icofont icofont-pencil-alt-5"></i></button>
                                                        <button class="btn btn-info btn-md"><i class="icofont icofont-plus-circle"></i></button>
                                                        <form class="d-inline" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer ?');" action="<?= URL ?>stock/sv/<?=  $stock['id_stock'] ?>" >
                                                            <button id="btn-delete-form" class="btn btn-danger btn-md" type="submit"><i class="icofont icofont-trash"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="mod-Modal<?= $stock['id_stock'] ?>" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Modifier la ligne de stock</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="post" action="<?= URL ?>stock/mv">
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-4 col-form-label">Prix En Gros</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="number" name="prix_g" id="prix_g" value="<?= $stock['prix_g_stock'] ?>" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-4 col-form-label">Prix Au Détail</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="number"  name="prix_d" id="prix_d" value="<?= $stock['prix_d_stock'] ?>" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-4 col-form-label">Quantité</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="number"  name="qte_stock" id="qte_stock" value="<?= $stock['quantite_stock'] ?>" class="form-control">
                                                                            <input type="hidden"  name="id_stock" id="id_stock" value="<?= $stock['id_stock'] ?>" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-4 col-form-label">Description</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text"  name="desc" id="desc" value="<?= $stock['desc_stock']  ?>" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-4 col-form-label">Type</label>
                                                                        <div class="col-sm-8">
                                                                            <select name="type_stock" id="type_stock" class="form-control">
                                                                                <?php if ($stock['type_stock'] == 'entre'): ?>
                                                                                    <option value="entre" selected>Entrée</option>
                                                                                <?php else: ?>
                                                                                    <option value="sortie" selected>Sortie</option>
                                                                                <?php endif; ?>
                                                                                <option value="entre">Entrée</option>
                                                                                <option value="sortie">Sortie</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-4 col-form-label">Ressource</label>
                                                                        <div class="col-sm-8">
                                                                            <select name="ressource" id="ressource" class="form-control">
                                                                                <option value="<?= $stock['id_res'] ?>" selected><?= $stock['nom_res'] ?></option>
                                                                                <?php if(isset($ressource) && !empty($ressource)):  ?>
                                                                                    <?php foreach ($ressource as $res): ?>
                                                                                        <option value="<?= $res->getIdRes() ?>"><?= $res->getNomRes() ?></option>
                                                                                    <?php endforeach; ?>
                                                                                <?php endif; ?>
                                                                            </select>
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
                                            <?php  $i++; endforeach; ?>
                                        <?php endif; ?>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Ressource</th>
                                            <th>Prix en Gros</th>
                                            <th>Prix au Détail</th>
                                            <th>Quantite</th>
                                            <th>Description</th>
                                            <th>Type</th>
                                            <th></th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- End Entre Table     -->
                        <!-- Sortie Table      -->
                        <div class="card" id="table_sortie">
                            <h5>Liste des sorties</h5>
                            <div class="card-block">
                                <div class="dt-responsive table-responsive">
                                    <table id="simpletable" class="table table-striped table-bordered nowrap">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Ressource</th>
                                            <th>Prix en Gros</th>
                                            <th>Prix au Détail</th>
                                            <th>Quantite</th>
                                            <th>Description</th>
                                            <th>Type</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (isset($sorties) && !empty($sorties)): ?>
                                            <?php $i=1; foreach ($sorties as $stock):?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $stock['nom_res'] ?></td>
                                                    <td><?= $stock['prix_g_stock'] ?></td>
                                                    <td><?= $stock['prix_d_stock'] ?></td>
                                                    <td><?= $stock['quantite_stock'] ?></td>
                                                    <td><?= $stock['desc_stock'] ?></td>
                                                    <td>
                                                        <?php if ($stock['type_stock'] == 'entre'): ?>
                                                            <button class="btn btn-success">Entrée</button>
                                                        <?php elseif ($stock['type_stock'] == 'sortie'): ?>
                                                            <button class="btn btn-danger">Sortie</button>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-success btn-md text-light" data-toggle="modal" data-target="#mod-Modal<?= $stock['id_stock'] ?>" ><i class="icofont icofont-pencil-alt-5"></i></button>
                                                        <button class="btn btn-info btn-md"><i class="icofont icofont-plus-circle"></i></button>
                                                        <form class="d-inline" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer ?');" action="<?= URL ?>stock/sv/<?=  $stock['id_stock'] ?>" >
                                                            <button id="btn-delete-form" class="btn btn-danger btn-md" type="submit"><i class="icofont icofont-trash"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="mod-Modal<?= $stock['id_stock'] ?>" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Modifier la ligne de stock</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="post" action="<?= URL ?>stock/mv">
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-4 col-form-label">Prix En Gros</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="number" name="prix_g" id="prix_g" value="<?= $stock['prix_g_stock'] ?>" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-4 col-form-label">Prix Au Détail</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="number"  name="prix_d" id="prix_d" value="<?= $stock['prix_d_stock'] ?>" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-4 col-form-label">Quantité</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="number"  name="qte_stock" id="qte_stock" value="<?= $stock['quantite_stock'] ?>" class="form-control">
                                                                            <input type="hidden"  name="id_stock" id="id_stock" value="<?= $stock['id_stock'] ?>" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-4 col-form-label">Description</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text"  name="desc" id="desc" value="<?= $stock['desc_stock']  ?>" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-4 col-form-label">Type</label>
                                                                        <div class="col-sm-8">
                                                                            <select name="type_stock" id="type_stock" class="form-control">
                                                                                <?php if ($stock['type_stock'] == 'entre'): ?>
                                                                                    <option value="entre" selected>Entrée</option>
                                                                                <?php else: ?>
                                                                                    <option value="sortie" selected>Sortie</option>
                                                                                <?php endif; ?>
                                                                                <option value="entre">Entrée</option>
                                                                                <option value="sortie">Sortie</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-4 col-form-label">Ressource</label>
                                                                        <div class="col-sm-8">
                                                                            <select name="ressource" id="ressource" class="form-control">
                                                                                <option value="<?= $stock['id_res'] ?>" selected><?= $stock['nom_res'] ?></option>
                                                                                <?php if(isset($ressource) && !empty($ressource)):  ?>
                                                                                    <?php foreach ($ressource as $res): ?>
                                                                                        <option value="<?= $res->getIdRes() ?>"><?= $res->getNomRes() ?></option>
                                                                                    <?php endforeach; ?>
                                                                                <?php endif; ?>
                                                                            </select>
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
                                            <?php $i++; endforeach; ?>
                                        <?php endif; ?>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Ressource</th>
                                            <th>Prix en Gros</th>
                                            <th>Prix au Détail</th>
                                            <th>Quantite</th>
                                            <th>Description</th>
                                            <th>Type</th>
                                            <th></th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- End Sorti Table Etat     -->
                    </div>
                    <!--Modal-->
                    <div class="modal fade" id="stock-Modal" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Ajouter une ligne de stock</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form  method="post" action="<?= URL ?>stock/av">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Prix En Gros</label>
                                            <div class="col-sm-8">
                                                <input type="number" step="0.01"  name="prix_g" id="prix_g" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Prix Au Détail</label>
                                            <div class="col-sm-8">
                                                <input type="number" step="0.01" name="prix_d" id="prix_d" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Quantité</label>
                                            <div class="col-sm-8">
                                                <input type="number" step="0.01" name="qte_stock" id="qte_stock" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Description</label>
                                            <div class="col-sm-8">
                                                <input type="text"  name="desc" id="desc" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Type</label>
                                            <div class="col-sm-8">
                                                <select name="type_stock" id="type_stock" class="form-control">
                                                    <option value="entre">Entrée</option>
                                                    <option value="sortie">Sortie</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Ressource</label>
                                            <div class="col-sm-8">
                                                <select name="ressource" id="ressource" class="form-control">
                                                    <?php if(isset($ressource) && !empty($ressource)):  ?>
                                                        <?php foreach ($ressource as $res): ?>
                                                            <option value="<?= $res->getIdRes() ?>"><?= $res->getNomRes() ?></option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn-block btn btn-primary waves-effect waves-light ">Ajouter</button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Annuler</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End modal-->

                    <!--Ressource Modal-->
                    <div class="modal fade" id="ressource-Modal" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Entrées/Sorties d'une ressource</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form  method="post" action="<?= URL ?>stock/ressource">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Date de début</label>
                                            <div class="col-sm-8">
                                                <input type="date"  name="dt_debut" id="dt_debut" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Date de fin</label>
                                            <div class="col-sm-8">
                                                <input type="date"  name="dt_fin" id="dt_fin" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Ressource</label>
                                            <div class="col-sm-8">
                                                <select name="ressource" name="ressource" id="ressource" class="form-control" required>
                                                    <?php if(isset($ressource) && !empty($ressource)):  ?>
                                                        <?php foreach ($ressource as $res): ?>
                                                            <option value="<?= $res->getIdRes() ?>"><?= $res->getNomRes() ?></option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn-block btn btn-primary waves-effect waves-light ">Valider</button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Annuler</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End modal-->
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
            $('#table_entre').hide();
            $('#table_sortie').hide();
            document.getElementById("btn_entre").addEventListener("click", function (){
                $('#table_etat').hide();
                $('#table_sortie').hide();
                $('#table_entre').show();
            });
            document.getElementById("btn_sortie").addEventListener("click", function (){
                $('#table_etat').hide();
                $('#table_sortie').show();
                $('#table_entre').hide();
            });
            document.getElementById("btn_etat").addEventListener("click", function (){
                $('#table_etat').show();
                $('#table_sortie').hide();
                $('#table_entre').hide();
            });
        });
    </script>
<?php
$footer = ob_get_clean();
require "views/partials/template.php";
?>