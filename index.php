<?php

/* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */

date_default_timezone_set("Asia/Kolkata");

$timeout = 60 * 60 * 24 * 31;                        //  1 Month
ini_set('session.gc_maxlifetime', $timeout);
session_set_cookie_params($timeout);
ini_set('session.cookie_lifetime', 0);
session_start();

include_once __DIR__."/database/model.php";

function checkAdmin() {
    return $_SESSION['employee_id'] == 1;
}

function checkAuth($admin = false) {
    if (!isset($_SESSION['employee_id']) || ($_SESSION['employee_id'] != 1 && $admin)) {
        return false;
    }
    return true;
}

function showPage($page, $data = [], $admin = false) {
    extract($data);
    checkAuth($admin) ? include_once __DIR__ . $page : include_once __DIR__ . '/views/403.php';
}

$request = $_SERVER['REQUEST_URI'];

$request = str_replace('/tracker', '', $request);       //  For server
$request = rtrim($request, '/');

switch ($request) {
    case '':
    case '/' :
        checkAuth() ? include_once __DIR__ . '/home.php' : include_once __DIR__ . '/views/login/index.php';
        break;

    case '/home' :
        include_once __DIR__ . '/home.php';
        break;

    case '/login' :
        if (checkAuth()) {
            session_write_close();
            header("Location: /");
        } else {
            include_once __DIR__ . '/views/login/index.php';
        }
        break;

    case '/login/auth' :
        if (checkAuth()) {
            session_write_close();
            header("Location: /");
        } else {
            include_once __DIR__ . '/controller/login.php';
        }
        break;

    case '/logout' :
        showPage('/controller/logout.php');
        break;

    case '/employees' :
        showPage('/views/employees/index.php', [], true);
        break;

    case '/employees/create' :
        showPage('/views/employees/store.php', [], true);
        break;

    case '/employees/store' :
        showPage('/controller/employee.php', [], true);
        break;

    case '/gameplays' :
        showPage('/controller/gameplays/index.php');
        break;

    case '/gameplays/create' :
        showPage('/views/gameplays/store.php');
        break;

    case '/gameplays/store' :
        showPage('/controller/gameplays/store.php');
        break;

    case '/acampaigns' :
        showPage('/views/campaigns/index.php', [], true);
        break;

    case '/acampaigns/create' :
        showPage('/views/campaigns/store.php', [], true);
        break;

    case '/acampaigns/store' :
        showPage('/controller/campaign.php', [], true);
        break;

    case '/leads' :
        showPage('/controller/leads/index.php');
        break;

    case '/leads/create' :
        showPage('/views/leads/store.php');
        break;

    case '/leads/store' :
        showPage('/controller/leads/store.php');
        break;

    default:
        switch (true) {
            case preg_match('/^\/employees\/edit\/([0-9]+)$/', $request, $matches):
                showPage('/views/employees/edit.php', [ 'employee_id' => $matches[1] ], true);
                break;

            case preg_match('/^\/acampaigns\/edit\/([0-9]+)$/', $request, $matches):
                showPage('/views/campaigns/edit.php', [ 'campaign_id' => $matches[1] ], true);
                break;

            case preg_match('/^\/gameplays\/([0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]))$/', $request, $matches):
                showPage('/controller/gameplays/index.php', [ 'date' => $matches[1] ]);
                break;

            case preg_match('/^\/gameplays\/edit\/([0-9]+)$/', $request, $matches):
                showPage('/views/gameplays/edit.php', [ 'gameplay_id' => $matches[1] ]);
                break;

            case preg_match('/^\/leads\/([0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]))\/?([0-9]+)?$/', $request, $matches):
                showPage('/controller/leads/index.php', [ 'date' => $matches[1], 'state_id' => $matches[4] ]);
                break;

            case preg_match('/^\/leads\/edit\/([0-9]+)$/', $request, $matches):
                showPage('/views/leads/edit.php', [ 'lead_id' => $matches[1] ]);
                break;

            default:
                include_once __DIR__ . '/views/404.php';
                break;
        }
        break;
}