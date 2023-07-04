<nav class="navbar header-navbar pcoded-header" header-theme="theme4">
    <div class="navbar-wrapper">
        <div class="navbar-logo">
            <a class="mobile-menu" id="mobile-collapse" href="#!">
                <i class="ti-menu"></i>
            </a>
            <a class="mobile-search morphsearch-search" href="#">
                <i class="ti-search"></i>
            </a>
            <a href="index.html">
                <img class="img-fluid" src="<?= URL ?>public/image/logo/logo-small.png" alt="Theme-Logo" />
            </a>
            <a class="mobile-options">
                <i class="ti-more"></i>
            </a>
        </div>
        <div class="navbar-container container-fluid">
            <div>
                <ul class="nav-left">
                    <li>
                        <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a></div>
                    </li>
                    <li>
                        <a href="#!" onclick="javascript:toggleFullScreen()">
                            <i class="ti-fullscreen"></i>
                        </a>
                    </li>
                </ul>

                <ul class="nav-right">
                    <li class="user-profile header-notification">
                        <a href="#">
                            <?php if (!empty($_SESSION['image'])):?>
                                <img class="img-20" src="<?= URL ?>public/image/user/<?= $_SESSION['image'] ?>" width="30" height="35" alt="User-Profile-Image">
                            <?php endif;?>
                            <span><?= $_SESSION['nom'].' '.$_SESSION['prenom'] ?></span>
                            <i class="ti-angle-down"></i>
                        </a>
                        <ul class="show-notification profile-notification">

                            <li>
                                <a href="<?= URL ?>utilisateur/unlogin">
                                    <i class="ti-layout-sidebar-left"></i> Se deconnecter
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>