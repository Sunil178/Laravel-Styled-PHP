<?php ob_start(); ?>

    <h1>Welcome To AceAffilino Tracker</h1>

<?php
    $customSection = ob_get_clean();
    include_once __DIR__."/layout/index.php";
?>
