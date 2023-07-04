<?php ob_start(); ?>

<div class="main-body">
    <div class="page-wrapper">
        <!-- Page header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Modifier l'utilisateur</h4>

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
                    <li class="breadcrumb-item"><a href="<?= URL ?>utilisateur/modifier">modifier</a>
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
                            <form id="form-up-user">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nom</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="nom" value="<?= $user->getNomUser() ?>" placeholder="Entrer le nom" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Prénoms</label>
                                    <div class="col-sm-10">
                                        <input type="text"  name="prenom" value="<?= $user->getPrenomUser() ?>" class="form-control" placeholder="Entrer le prénom ">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Contact</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="contact" value="<?= $user->getContactUser() ?>" placeholder="Entrer le contact">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nom d'utilisateur</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="user" value="<?= $user->getUsernameUser() ?>" placeholder="Entrer le mot de passe" required >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Mot de passe</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Entrer le mot de passe" >
                                        <input type="hidden" class="form-control" name="id_user" value="<?= $user->getIdUser() ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Mot de passe confirmé</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" name="password_c" id="password_c" placeholder="Entrer de nouveau le mot de passe" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Rôle</label>
                                    <div class="col-sm-10">
                                        <select name="role_u" class="form-control" required>
                                            <?php if ($_SESSION['role'] == 'super_admin'): ?>
                                                <option value="super_admin">Super administrateur</option>
                                            <?php endif; ?>
                                            <option value="<?= $user->getRoleUser() ?>" selected><?= $user->getRoleUser() ?></option>
                                            <option value="admin">Administrateur</option>
                                            <option value="secretaire">Secrétaire</option>
                                        </select>
                                    </div>
                                </div>
                                <?php if ( $_SESSION['role']=='super_admin')  :?>
                                    <div class="form-group row">
                                        <label class="form-label col-sm-2 col-form-label">Agence</label>
                                        <div class="col-sm-10">
                                            <select  name="agence" class="form-control" >
                                                <option value="">------------------------------</option>
                                                <?php foreach ($agences as $agence):
                                                    if($agence->getIdAgence() == $user->getAgence()): ?>
                                                        <option value="<?= $agence->getIdAgence() ?>" selected>
                                                            <?= $agence->getNomAgence().' <=> '.$agence->getAdresseAgence().' <=> '.$agence->getContactAgence() ?>
                                                        </option>
                                                    <?php endif; ?>

                                                    <option value="<?= $agence->getIdAgence() ?>">
                                                        <?= $agence->getNomAgence().' <=> '.$agence->getAdresseAgence().' <=> '.$agence->getContactAgence() ?>
                                                    </option>
                                                <?php  endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php endif;?>
                                <div class="form-group row">
                                    <div class="col-sm-6 col-md-6 row">
                                        <label class="col-sm-2 col-form-label">Cnib recto</label>
                                        <div class="col-sm-10">
                                            <input type="file" class="form-control" name="recto" >
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <img src="<?= URL ?>/public/image/user/<?= $user->getCnibRectoUser() ?>" alt="" class="img-thumbnail" width="200" height="200">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 col-md-6 row">
                                        <label class="col-sm-2 col-form-label">Cnib verso</label>
                                        <div class="col-sm-10">
                                            <input type="file" class="form-control" name="verso" >
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <img src="<?= URL ?>/public/image/user/<?= $user->getCnibVersoUser() ?>" alt="" class="img-thumbnail" width="200" height="200">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 col-md-6 row">
                                        <label class="col-sm-2 col-form-label">Photo de profil</label>
                                        <div class="col-sm-10">
                                            <input type="file" class="form-control" name="image" >
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <img src="<?= URL ?>/public/image/user/<?= $user->getCnibRectoUser() ?>" alt="" class="img-thumbnail" width="200" height="200">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 offset-sm-8">
                                        <button class="btn btn-outline-primary mb-2"  type="submit">Modifier</button>
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
        $('#form-up-user').submit( function(e)
        {
            e.preventDefault();
            var password = $('#password').val();
            var password_c = $('#password_c').val();
            
            if (password == password_c){
                $.ajax({
                    url: "<?= URL ?>utilisateur/mv",
                    type: "POST",
                    data:  new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,

                    success: function(response)
                    {
                        $("#form-up-user")[0].reset(); 
                        swal({
                            title: "Bravo",
                            text: "Utilisateur modifié avec succès!",
                            icon: "success"
                        })
                        .then(function() {
                            window.location ="<?= URL ?>utilisateur";
                        });

                    },
                    error: function(e) 
                    {
                        swal({
                            title: "Erreur",
                            text: e,
                            icon: "error"
                        })
                    }          
                });
            }else{
                swal({
                    title: "Erreur",
                    text: "Les mots de passes ne correspondent pas"+ password+" "+password_c,
                    icon: "error"
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




