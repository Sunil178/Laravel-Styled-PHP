<?php
    if (!isset($date)) {
        $date = date('Y-m-d');
    }

    $model = new Model('bot_leads');
    $bot_leads = $model->getBy([ "DATE(`created_at`)" => $date ]);

    include_once __DIR__."/../../views/bot/index.php";
?>