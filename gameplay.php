<?php
    ob_start();

    include 'model.php';

    $model = new Model();

    include 'gameplay-store.php';

    $customSection = ob_get_clean();

    include 'dashboard.php';
?>
