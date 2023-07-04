<?php ob_start(); ?>

<div class="main-body">
    <div class="page-wrapper">
        <!-- Page header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Ajouter un utilisateur</h4>

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
                    <li class="breadcrumb-item"><a href="<?= URL ?>utilisateur/ajouter">Ajouter</a>
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
                            <form id="form-add-user">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nom</label>
                                    <div class="col-sm-10">
                                        <input type="text" id="nom" placeholder="Entrer le nom" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Prénoms</label>
                                    <div class="col-sm-10">
                                        <input type="text"  id="prenom" class="form-control" placeholder="Entrer le prénom ">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Contact</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="contact" placeholder="Entrer le contact">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nom d'utilisateur</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="user" placeholder="Entrer le mot de passe" required >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Mot de passe</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="password" placeholder="Entrer le mot de passe" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Mot de passe confirmé</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="password_c" placeholder="Entrer de nouveau le mot de passe" required>
                                    </div>
                                </div>
                                <?php if ($_SESSION['role']=='super_admin' || $_SESSION['role']=='admin'):?>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Rôle</label>
                                    <div class="col-sm-10">
                                        <select id="role_u" class="form-control" required>
                                            <?php if ($_SESSION['role']=='super_admin'):?>
                                                <option value="super_admin">Super Administrateur</option>
                                            <?php endif;?>
                                            <option value="admin">Administrateur</option>
                                            <option value="secretaire">Secrétaire</option>
                                        </select>
                                    </div>
                                </div>
                                <?php else:?>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Rôle</label>
                                        <div class="col-sm-10">
                                            <select id="role_u" class="form-control" required>
                                                <option value="secretaire">Secrétaire</option>
                                            </select>
                                        </div>
                                    </div>
                                <?php endif;?>
                                <?php if ( $_SESSION['role']=='super_admin')  :?>
                                    <div class="form-group row">
                                        <label class="form-label col-sm-2 col-form-label">Agence</label>
                                        <div class="col-sm-10">
                                            <select  id="agence" class="form-control" >
                                                <option value="">------------------------------</option>
                                                <?php foreach ($agences as $agence): ?>
                                                    <option value="<?= $agence->getIdAgence() ?>">
                                                        <?= $agence->getNomAgence().' <=> '.$agence->getAdresseAgence().' <=> '.$agence->getContactAgence() ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php else:?>
                                    <input type="hidden" value="<?=$_SESSION['agence'] ?>" id="agence">
                                <?php endif;?>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Cnib recto</label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control" name="recto" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Cnib verso</label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control" name="verso" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Photo de profil</label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control" name="image" >
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 offset-sm-8">
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

ob_start();
?>
<script src="<?= URL ?>public/assets/js/cdn/sweetarlert.js"></script>
<script>
    $(document).ready(function (){
        $('#form-add-user').submit( function(e)
        {
            var nom = $('#nom').val();
            var prenom = $('#prenom').val();
            var contact = $('#contact').val();
            var user = $('#user').val();
            var password = $('#password').val();
            var password_c = $('#password_c').val();
            var role = $('#role_u').val();
            var agence = $('#agence').val();
            if ( password == password_c){
                $.post(
                    '<?= URL ?>utilisateur/av',
                    {
                        nom:nom, prenom:prenom, contact:contact, user:user, password:password, role:role, agence:agence
                    },
                    function(response)
                    {
                        swal({
                            title: "Bravo",
                            text: "Utilisateur ajouté avec succès!",
                            icon: "success"
                        }).then(function() {
                            window.location ="<?= URL ?>utilisateur";
                        });
                    });
            }
            else{
                swal({
                    title: "Erreur",
                    text: "Les mots de passes ne sont pas identiques",
                    icon: "danger"
                });
            }
            return false;
        });
    });
</script>
<?php

$footer = ob_get_clean();
require "views/partials/template.php";
?>




