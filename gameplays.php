<?php
    ob_start();

    include 'database/model.php';

    $model = new Model('employees');

    include 'views/gameplay/gameplay-store.php';

    $customSection = ob_get_clean();

    include 'views/layout/index.php';
?>
