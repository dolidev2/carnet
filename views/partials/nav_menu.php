<nav class="pcoded-navbar" pcoded-header-position="relative">
    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
    <div class="pcoded-inner-navbar main-menu">
        <div class="">
            <div class="main-menu-header">
                <?php if (!empty($_SESSION['image'])):?>
                    <img class="img-30" src="<?= URL ?>public/image/user/<?= $_SESSION['image'] ?>" width="30" height="35" alt="User-Profile-Image">
                <?php endif;?>
                <div class="user-details">
                    <span><?= $_SESSION['nom']. ' '.$_SESSION['prenom'] ?></span>
                    <span id="more-details"><?= $_SESSION['role'] ?><i class="ti-angle-down"></i></span>
                </div>
            </div>

            <div class="main-menu-content">
                <ul>
                    <li class="more-details">
<!--                        <a href="user-profile.html"><i class="ti-user"></i>View Profile</a>-->
<!--                        <a href="#!"><i class="ti-settings"></i>Settings</a>-->
                        <a href="<?= URL ?>utilisateur/unlogin"><i class="ti-layout-sidebar-left"></i>Se déconnecter</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation" menu-title-theme="theme5">Menu</div>
        <ul class="pcoded-item pcoded-left-item">
            <li>
                <a href="<?= URL ?>accueil">
                    <span class="pcoded-micon"><i class="ti-home"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Accueil</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li>
                <a href="<?= URL ?>client">
                    <span class="pcoded-micon"><i class="ti-layout"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.page_layout.main">Client</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li>
                <a href="<?= URL ?>commande" >
                    <span class="pcoded-micon"><i class="ti-layout-cta-right"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.navigate.main">Programme</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="">
                <a href="<?= URL ?>personnel">
                    <span class="pcoded-micon"><i class="ti-view-grid"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.widget.main">Personnel</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="">
                <a href="<?= URL ?>ressource">
                    <span class="pcoded-micon"><i class="ti-gift"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.widget.main">Ressource</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li>
                <a href="<?= URL ?>caisse">
                    <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.basic-components.main">Caisse
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li>
                <a href="<?= URL ?>utilisateur">
                    <span class="pcoded-micon"><i class="ti-crown"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.advance-components.main">Utilisateur</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
<!--            <li>-->
<!--                <a href="--><?//= URL ?><!--statistique">-->
<!--                    <span class="pcoded-micon"><i class="ti-gift"></i></span>-->
<!--                    <span class="pcoded-mtext" data-i18n="nav.extra-components.main">Statistique</span>-->
<!--                    <span class="pcoded-mcaret"></span>-->
<!--                </a>-->
<!--            </li>-->
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-layout"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.page_layout.main">Paramètres</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class=" ">
                        <a href="<?= URL ?>modele">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.page_layout.bottom-menu">Modèle</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="<?= URL ?>stock" >
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.page_layout.box-layout">Stock</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="<?= URL ?>agence">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.page_layout.rtl">Agence</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="<?= URL ?>impression">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.page_layout.rtl">Impression</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>

                </ul>
            </li>
        </ul>
    </div>
</nav>