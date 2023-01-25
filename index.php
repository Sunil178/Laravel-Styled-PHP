<?php

$request = $_SERVER['REQUEST_URI'];

/* $public_folder = __DIR__ . '/test';
echo $public_folder;
exit;
$file_path = $public_folder . $request;

if (is_file($file_path)) {
    $file_info = pathinfo($file_path);
    $extension = $file_info['extension'];
    $mime_types = [
        'css' => 'text/css',
        'js' => 'application/javascript',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
    ];
    $mime_type = $mime_types[$extension] ?? 'application/octet-stream';
    header("Content-Type: $mime_type");
    readfile($file_path);
    exit;
} */

switch ($request) {
    case '/' :
        include_once __DIR__ . '/home.php';
        break;
    case '/employees' :
        include_once __DIR__ . '/views/employees/index.php';
        break;
    case '/employees/create' :
        include_once __DIR__ . '/views/employees/store.php';
        break;
    case '/employees/edit' :
        include_once __DIR__ . '/views/employees/edit.php';
        break;
    case '/gameplays' :
        include_once __DIR__ . '/views/gameplays/index.php';
        break;
    case '/gameplays/create' :
        include_once __DIR__ . '/views/gameplays/store.php';
        break;
    case '/gameplays/edit' :
        include_once __DIR__ . '/views/gameplays/edit.php';
        break;
    case '/campaigns' :
        include_once __DIR__ . '/views/campaigns/index.php';
        break;
    case '/campaigns/create' :
        include_once __DIR__ . '/views/campaigns/store.php';
        break;
    case '/campaigns/edit' :
        include_once __DIR__ . '/views/campaigns/edit.php';
        break;
    case '/leads' :
        include_once __DIR__ . '/views/leads/index.php';
        break;
    case '/leads/create' :
        include_once __DIR__ . '/views/leads/store.php';
        break;
    case '/leads/edit' :
        include_once __DIR__ . '/views/leads/edit.php';
        break;
    default:
        // http_response_code(404);
        // include_once __DIR__ . '/views/404.php';
        break;
}