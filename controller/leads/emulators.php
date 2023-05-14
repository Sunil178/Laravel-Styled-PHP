<?php

header('Content-Type: application/json');

$emulator_name = @$_GET['emulator_name'];

if (!isset($emulator_name) || $emulator_name == '') {
    echo json_encode([
        'status' => 400,
        'message' => 'Bad input'
    ]);
    exit;
}

$model = new Model('leads');
$emulators = $model->getByCustom(where: "type = '0' AND emulator LIKE '%$emulator_name%'",
                            columns: "id, emulator AS text");

echo json_encode($emulators);
?>
