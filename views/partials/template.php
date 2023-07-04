<?php if (!empty($_SESSION['id'])): ?>
<!DOCTYPE html>
<html lang="fr" >

<head>
    <?php require "header.php"?>
    <?= $header ?>
</head>

<body>
<!-- Pre-loader start -->
<div class="theme-loader">
    <div class="ball-scale">
        <div></div>
    </div>
</div>
<!-- Pre-loader end -->
<!-- Menu header start -->
<div id="pcoded" class="pcoded">
    <div class="pcoded-overlay-box"></div>
    <div class="pcoded-container navbar-wrapper">

        <!--Nav bar-->
        <?php require "nav.php"; ?>

        <!-- Sidebar inner chat start-->
        <?php require "sidebar_inner.php" ?>
        <!-- Sidebar inner chat end-->

        <div class="pcoded-main-container">
            <div class="pcoded-wrapper">
                <!--Nav menu -->
                <?php require "nav_menu.php"; ?>

                <div class="pcoded-content">
                    <div class="pcoded-inner-content" style="max-height: 100vh; overflow: auto;">

                        <?= $content ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Required Jqurey -->
<?php require "footer.php"?>
<?= $footer ?>
</body>

</html>
<?php else:
    header('location:'.URL);

endif;?>
