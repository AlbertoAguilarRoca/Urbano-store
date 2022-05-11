<?php

require_once __DIR__ . '/security/controlAccess.php';

$controlAccess = new ControlAccess();
if ($controlAccess->getUser() == null) {
    header("Location: /urban/backoffice/login.php");
    exit;
}

?>

<?php require_once __DIR__ . '/./head.php'; ?>

<div class="content-page">
    <div class="content-container">

        <div class="content-breadcrumb-box">
            <div class="breadcrumbs">
                <p>Dashboard</p>
            </div>
        </div>

        <div class="content-header">
            <h1 class="content-title">Dashboard</h1>
        </div>

        <?php
            echo intval($_SESSION['user']['permiso']);
        ?>

    </div>
    <!--fin content-container-->
</div>
<!--fin .content-page-->

</div>
<!--fin del container que envuelve todo: main row-->

<?php require_once __DIR__ . '/./footer.php'; ?>