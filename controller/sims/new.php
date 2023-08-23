<?php

$employee_id = $_SESSION['employee_id'];

if (!isset($_POST['product_id']) || $_POST['product_id'] == '') {
    echo "Product is required";
    exit;
}

if (!isset($_POST['operator_id']) || $_POST['operator_id'] == '') {
    echo "Operator is required";
    exit;
}

$model = new Model('operators');
$operator = $model->get( $_POST['operator_id'] )->name;

$model = new Model('products');
$product = $model->get( $_POST['product_id'] )->name;

include_once __DIR__."/../utils/http.php";

$url = "https://5sim.net/v1/user/buy/activation/india/$operator/$product";
$result = getResponse($url);

if ($result !== false) {
    $model = new Model('sims');

    $data = [
        'employee_id' => $employee_id,
        'product_id' => $_POST['product_id'],
        'operator_id' => $_POST['operator_id'],
        'order_id' => $result['id'],
        'phone' => $result['phone'],
        'price' => $result['price'],
        'status' => $result['status'],
        'sms' => $result['sms'],
        'sim_created_at' => $result['created_at'],
        'expires_at' => $result['expires'],
    ];

    $db_res = $model->create($data);

    if ($db_res !== false) {
        session_write_close();
        header("Location: /sims/" . $result['id']);
    } else {
        echo "Something Went Wrong!";
    }
} else {
    echo "Something Went Wrong!";
}
?>