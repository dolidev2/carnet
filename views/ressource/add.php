<?php ob_start(); ?>

<div class="main-body">
    <div class="page-wrapper">
        <!-- Page header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Ajouter une ressource</h4>

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
                    <li class="breadcrumb-item"><a href="<?= URL ?>ressource/ajouter">Ajouter</a>
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
                            <form method="post" action="<?= URL ?>ressource/av" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label class="form-label">Nom</label>
                                    <input type="text" name="nom" placeholder="Entrer le nom de la ressource" class="form-control" required pattern="[0-9a-zA-Z_- ]*">
                                </div>
                                <div class="form-group row">
                                    <label class="form-label">Description</label>
                                    <input type="text"  name="desc" class="form-control" placeholder="Entrer une description de la  ressource">
                                </div>
                                <?php if ($_SESSION['agence_role'] =='Principale' && $_SESSION['role']=='admin'):?>
                                    <div class="form-group row">
                                        <label class="form-label">Agence</label>
                                        <select  id="agence" class="form-control" >
                                            <option value="">------------------------------</option>
                                            <?php foreach ($agences as $agence): ?>
                                                <option value="<?= $agence->getIdAgence() ?>">
                                                    <?= $agence->getNomAgence().' <=> '.$agence->getAdresseAgence().' <=> '.$agence->getContactAgence() ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                <?php else:?>
                                    <input type="hidden" value="<?=$_SESSION['agence'] ?>" id="agence">
                                <?php endif;?>
                                <div class="form-group row">
                                    <label class="form-label">Image</label>
                                    <input type="file"  name="image" class="form-control">
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
        </div>
        <!-- Page body end -->
    </div>
</div>
<?php $content = ob_get_clean();
$header = '';
$footer ='';
require "views/partials/template.php";
?>
