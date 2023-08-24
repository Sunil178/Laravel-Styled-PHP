<?php
    if (!isset($date)) {
        $date = date('Y-m-d');
    }
    $model = new Model('sims');
    $employee_id = @$employee_id_param ?: $_SESSION['employee_id'];

    $query = "SELECT
            sims.id, sims.order_id, sims.phone, sims.price, sims.otp, sims.status, employees.name AS employees_name, products.name AS product_name, operators.name as operator_name, sims.created_at
            FROM sims
            JOIN employees ON employees.id = sims.employee_id
            LEFT JOIN products ON products.id = sims.product_id
            LEFT JOIN operators ON operators.id = sims.operator_id
            WHERE DATE(sims.created_at) = '$date'";

    if (!checkAdmin() || @$employee_id_param) {
        $query .= " AND sims.employee_id = '$employee_id'";
    }
    $query .= " ORDER BY sims.created_at DESC";
    $sims = $model->runQuery($query);

    $model = new Model('products');
    $products = $model->getAll();
    $model = new Model('operators');
    $operators = $model->getAll();

    include_once __DIR__."/../utils/http.php";
    $result = getProfile();
    if ($result !== false) {
        $balance = $result['balance'];
    } else {
        echo "Something went wrong with api!";
        exit;
    }

    include_once __DIR__."/../../views/sims/index.php";
?>
