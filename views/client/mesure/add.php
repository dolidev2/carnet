<?php
$header = '';
ob_start();
?>
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Ajouter la mesure du client</h4>
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
                    <li class="breadcrumb-item"><a href="<?= URL ?>client/info/<?= $client->getIdClient() ?>">Mesure</a>
                    </li>
                    <li class="breadcrumb-item"><a
                                href="<?= URL ?>client/info/<?= $client->getIdClient() ?>/mesure_ajouter">Ajouter</a>
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
                            <h4 class="sub-title">Info Client</h4>
                            <div class="row">
                                <div class="form-control col-sm-6">
                                    <label class="col-form-label">Nom</label>
                                    <input type="text" class="form-control" value="<?= $client->getNomClient() ?>"
                                           readonly>
                                </div>
                                <div class=" form-control col-sm-6">
                                    <label class="col-form-label">Prénom</label>
                                    <input type="text" class="form-control" value="<?= $client->getPrenomClient() ?>"
                                           readonly>
                                </div>
                                <div class="form-control col-sm-6">
                                    <label class="col-form-label">Numéro mesure</label>
                                    <input type="text" class="form-control" value="<?= $client->getNumeroMesure() ?>"
                                           readonly>
                                </div>
                                <div class=" form-control col-sm-6">
                                    <label class="col-form-label">Type</label>
                                    <input type="text" class="form-control" value="<?= $client->getTypeClient() ?>"
                                           readonly>
                                </div>
                                <div class="form-control col-sm-6">
                                    <label class="col-form-label">Contact</label>
                                    <input type="text" class="form-control" value="<?= $client->getContactClient() ?>"
                                           readonly>
                                </div>
                                <div class="form-control col-sm-6">
                                    <label class="col-form-label">Adresse</label>
                                    <input type="text" class="form-control" value="<?= $client->getAdresseClient() ?>"
                                           readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <!-- Basic Form Inputs card start -->
                    <div class="card">
                        <div class="card-block">
                            <h4 class="sub-title"></h4>
                            <form id="form-add-mesure">
                                <div class="form-group">
                                    <label class="form-label">Sexe</label>
                                    <select id="sexe" class="form-control">
                                        <option value="Masculin">Masculin</option>
                                        <option value="Feminin">Feminin</option>
                                    </select>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">Epaule</label>
                                            <input type="text" id="epaule" class="form-control ">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Largeur épaule</label>
                                            <input type="text" id="l_epaule" class="form-control ">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Carrure</label>
                                            <input type="text" id="carrure" class="form-control ">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Poitrine</label>
                                            <input type="text" id="poitrine" class="form-control ">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Dos</label>
                                            <input type="text" id="dos" class="form-control ">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Tour de taille</label>
                                            <input type="text" id="t_taille" class="form-control ">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Ceinture</label>
                                            <input type="text" id="ceinture" class="form-control ">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Bassin</label>
                                            <input type="text" id="bassin" class="form-control ">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Cuisse</label>
                                            <input type="text" id="cuisse" class="form-control ">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Tour des Genoux</label>
                                            <input type="text" id="t_genou" class="form-control ">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Bas</label>
                                            <input type="text" id="bas" class="form-control ">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Cole</label>
                                            <input type="text" id="cole" class="form-control ">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Tour de Manche</label>
                                            <input type="text" id="t_manche" class="form-control ">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Poignet</label>
                                            <input type="text" id="poignet" class="form-control ">
                                        </div>

                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">Longueur Manche</label>
                                            <input type="text" id="l_manche" class="form-control ">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Longueur Taille</label>
                                            <input type="text" id="l_taille" class="form-control ">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Longueur Chemise</label>
                                            <input type="text" id="l_chemise" class="form-control ">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Longueur Tunique</label>
                                            <input type="text" id="l_chemise_a" class="form-control ">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Longueur Gilet</label>
                                            <input type="text" id="l_gilet" class="form-control ">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Longueur Veste</label>
                                            <input type="text" id="l_veste" class="form-control ">
                                            <input type="hidden" id="client" value="<?= $client->getIdClient() ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Longueur Genoux</label>
                                            <input type="text" id="l_genou" class="form-control ">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Longueur Pantalon</label>
                                            <input type="text" id="l_pantalon" class="form-control ">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Longueur Pantacourt</label>
                                            <input type="text" id="pantacourt" class="form-control ">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Entre Jambe</label>
                                            <input type="text" id="e_jambe" class="form-control ">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Frappe</label>
                                            <input type="text" id="frappe" class="form-control ">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Tour de tête</label>
                                            <input type="text" id="t_tete" class="form-control ">
                                        </div>
                                        <div class="form-group" id="l_ju">
                                            <label class="form-label">Longueur Jupe</label>
                                            <input type="text" id="l_jupe" class="form-control ">
                                        </div>
                                        <div class="form-group" id="ep">
                                            <label class="form-label">Ecart pince poitrine</label>
                                            <input type="text" id="e_p_poitrine" class="form-control ">
                                        </div>
                                        <div class="form-group" id="l_ha">
                                            <label class="form-label">Longueur haut</label>
                                            <input type="text" id="l_haut" class="form-control ">
                                        </div>
                                        <div class="form-group" id="l_ro">
                                            <label class="form-label">Longueur Robe</label>
                                            <input type="text" id="l_robe" class="form-control ">
                                        </div>
                                        <div class="form-group" id="l_po">
                                            <label class="form-label">Hauteur Poitrine</label>
                                            <input type="text" id="l_poitrine" class="form-control ">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 offset-sm-8">
                                        <button class="btn btn-outline-primary mb-2" type="submit">Ajouter</button>
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

ob_start();
?>
<script src="<?= URL ?>public/assets/js/cdn/sweetarlert.js"></script>
<script>
    $(document).ready(function () {

        $('#ep').hide();
        $('#l_ju').hide();
        $('#l_ro').hide();
        $('#l_po').hide();
        $('#l_ha').hide();

        $('#sexe').change(function (e) {
            var sex = e.target.value;
            if (sex == 'Masculin') {
                $('#ep').hide();
                $('#l_ju').hide();
                $('#l_ro').hide();
                $('#l_po').hide();
                $('#l_ha').hide();
            }
            if (sex == 'Feminin') {
                $('#ep').show();
                $('#l_ju').show();
                $('#l_ro').show();
                $('#l_po').show();
                $('#l_ha').show();
            }
        });

        $('#form-add-mesure').submit(function (e) {
            var epaule = $('#epaule').val();
            var l_epaule = $('#l_epaule').val();
            var carrure = $('#carrure').val();
            var poitrine = $('#poitrine').val();
            var dos = $('#dos').val();
            var t_taille = $('#t_taille').val();
            var ceinture = $('#ceinture').val();
            var bassin = $('#bassin').val();
            var cuisse = $('#cuisse').val();
            var t_genou = $('#t_genou').val();
            var bas = $('#bas').val();

            var cole = $('#cole').val();
            var t_manche = $('#t_manche').val();
            var poignet = $('#poignet').val();
            var l_manche = $('#l_manche').val();
            var l_taille = $('#l_taille').val();
            var l_chemise = $('#l_chemise').val();
            var l_chemise_a = $('#l_chemise_a').val();
            var l_gilet = $('#l_gilet').val();
            var l_veste = $('#l_veste').val();
            var l_genou = $('#l_genou').val();

            var e_p_poitine = $('#e_p_poitine').val();
            var l_jupe = $('#l_jupe').val();
            var l_robe = $('#l_robe').val();
            var l_poitrine = $('#l_poitrine').val();
            var l_haut = $('#l_haut').val();

            var l_pantalon = $('#l_pantalon').val();
            var pantacourt = $('#pantacourt').val();
            var frappe = $('#frappe').val();
            var e_jambe = $('#e_jambe').val();
            var sexe = $('#sexe').val();
            var t_tete = $('#t_tete').val();
            var client = $('#client').val();

            $.post(
                "<?= URL ?>client/info/<?= $client->getIdClient() ?>/mesure_av",
                {
                    epaule: epaule,
                    l_epaule: l_epaule,
                    carrure: carrure,
                    poitrine: poitrine,
                    dos: dos,
                    t_taille: t_taille,
                    ceinture: ceinture,
                    bassin: bassin,
                    cuisse: cuisse,
                    t_genou: t_genou,
                    bas: bas,
                    cole: cole,
                    t_manche: t_manche,
                    poignet: poignet,
                    l_manche: l_manche,
                    l_taille: l_taille,
                    l_chemise: l_chemise,
                    l_chemise_a: l_chemise_a,
                    l_gilet: l_gilet,
                    l_veste: l_veste,
                    l_genou: l_genou,
                    l_pantalon: l_pantalon,
                    pantacourt: pantacourt,
                    frappe: frappe,
                    e_jambe: e_jambe,
                    client: client,
                    e_p_poitine: e_p_poitine,
                    l_jupe: l_jupe,
                    l_robe: l_robe,
                    l_poitrine: l_poitrine,
                    l_haut: l_haut,
                    sexe: sexe,
                    t_tete: t_tete
                },
                function (response) {
                    swal({
                        title: "Bravo",
                        text: "Les mesures du client ont été ajoutées avec succès!",
                        icon: "success"
                    }).then(function () {
                        window.location = "<?= URL ?>client/info/<?= $client->getIdClient() ?>";
                    });

                }
            );

            return false;
        });
    });
</script>
<?php

$footer = ob_get_clean();
require "views/partials/template.php";
?>
