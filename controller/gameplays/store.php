<?php

if (!isset($_POST['employee_id']) || $_POST['employee_id'] == '') {
    if (checkAuth(true)) {
        echo "Employee is required";
        exit;
    }
    $employee_id = $_SESSION['employee_id'];
} else {
    if (checkAuth(true)) {
        $employee_id = $_POST['employee_id'];
    } else {
        $employee_id = $_SESSION['employee_id'];
    }
}

$lead_id = @$_POST['lead_id'];
$emulator_name = @$_POST['emulator_name'];

if ((!isset($lead_id) || $lead_id == '') && (!isset($emulator_name) || $emulator_name == '')) {
    echo "Emulator is required";
    exit;
}

$lead_id = $lead_id == '' ? NULL : $lead_id;
$emulator_name = $emulator_name == '' ? NULL : $emulator_name;

$model = new Model('gameplays');
$data = [
    'employee_id' => $employee_id,
    'emulator_name' => $emulator_name,
    'lead_id' => $lead_id,
];
$gameplay_id = $_POST['gameplay_id'];

if ($gameplay_id) {
    $db_res1 = $model->update($data, $gameplay_id);
}
else {
    $db_res1 = $model->create($data);
    $gameplay_id = $model->getConnection()->insert_id;
}

$rakes = $_POST['rakes'];
$rake_ids = $_POST['rake_ids'];

$model = new Model('gameplay_rakes');
foreach ($rake_ids as $rake_id_index => $rake_id) {
    if ($rakes[$rake_id_index] != '') {
        if ($rake_id == 0) {
            $db_res2 = $model->create([
                'gameplay_id' => $gameplay_id,
                'rake' => (float)$rakes[$rake_id_index],
            ]);
        }
        else {
            $db_res2 = $model->update([
                'rake' => (float)$rakes[$rake_id_index],
            ], $rake_id);
        }
    }
}

if ($db_res1 !== false && $db_res2 !== false) {
    header("Location: /gameplays");
}
else {
    echo "Something Went Wrong!";
}
?>