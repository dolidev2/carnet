<?php ob_start();
?>
<!-- Data Table Css -->
<link rel="stylesheet" type="text/css"
      href="<?= URL ?>public/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css"
      href="<?= URL ?>public/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">
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
                <a href="<?= URL ?>caisse">
                    <button class="btn btn-outline-success btn-lg">Caisse</button>
                </a>
                <span>Modifier une ligne de la caisse</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= URL ?>accueil">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?= URL ?>caisse">Caisse</a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?= URL ?>update">Modifier</a>
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
                            <form id="form-up-caisse">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label class="form-control-label">Date</label>
                                        <input type="date" id="date_caisse"
                                               value="<?= $caisse->getCreatCaisse() ?>"
                                               class="form-control">
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="form-control-label">Somme</label>
                                        <input type="number" id="sommeup"
                                               value="<?= $caisse->getSommeCaisse() ?>"
                                               class="form-control"
                                               placeholder="Entrez la somme ">
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="form-control-label">Motif</label>
                                        <textarea name=""   placeholder="Entrez le motif"   class="form-control" id="descup" cols="30" rows="10">
                                            <?= $caisse->getDescCaisse() ?>
                                        </textarea>
                                        <input type="hidden" id="idup"
                                               value="<?= $caisse->getIdCaisse() ?>">
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="form-control-label">Type</label>
                                        <select name="" id="typeup"
                                                class="form-control">
                                            <?php if ($caisse->getTypeCaisse() == 'entre'): ?>
                                                <option value="<?= $caisse->getTypeCaisse() ?>">
                                                    Entrée
                                                </option>
                                            <?php else: ?>
                                                <option value="<?= $caisse->getTypeCaisse() ?>">
                                                    Sortie
                                                </option>
                                            <?php endif; ?>
                                            <option value="entre">Entrée</option>
                                            <option value="sortie">Sortie</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-primary">Modifier</button>
                                        <button type="button" class="btn btn-default mt-1" data-dismiss="modal">Annuler</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end Body-->
<?php $content = ob_get_clean();

ob_start();
?>
<script src="<?= URL ?>public/assets/js/cdn/sweetarlert.js"></script>
<script>
    $(document).ready(function () {
        $('#form-up-caisse').submit(function (e) {

            var somme = $('#sommeup').val();
            var desc = $('#descup').val();
            var type = $('#typeup').val();
            var id = $('#idup').val();
            var date_caisse = $('#date_caisse').val();

            $.post(
                '<?= URL ?>caisse/mv',
                {
                    somme:somme, desc:desc, type:type, id:id, date_caisse:date_caisse
                },
                function(response)
                {
                    swal({
                        title: "Bravo",
                        text: "Ligne de caisse modifiée avec succès!",
                        icon: "success"
                    }).then(function() {
                        window.location ="<?= URL ?>caisse";
                    });
                });
            return false;
        });
    });
</script>

<?php
$footer = ob_get_clean();
require "views/partials/template.php";
?>


