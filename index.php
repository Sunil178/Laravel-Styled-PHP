<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

function checkAuth($admin = false) {
    if (!isset($_SESSION['employee_id']) || ($_SESSION['employee_id'] != 1 && $admin)) {
        return false;
    }
    return true;
}

function showPage($page, $admin = false) {
    checkAuth($admin) ? include_once __DIR__ . $page : include_once __DIR__ . '/views/403.php';
}

$request = $_SERVER['REQUEST_URI'];

$request = str_replace('/tracker', '', $request);       //  For sever

switch ($request) {
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
        showPage('/views/employees/index.php', true);
        break;

    case '/employees/create' :
        showPage('/views/employees/store.php', true);
        break;

    case '/employees/store' :
        showPage('/controller/employee.php', true);
        break;

    case '/gameplays' :
        showPage('/views/gameplays/index.php');
        break;

    case '/gameplays/create' :
        showPage('/views/gameplays/store.php');
        break;

    case '/gameplays/store' :
        showPage('/controller/gameplay.php');
        break;

    case '/campaigns' :
        showPage('/views/campaigns/index.php', true);
        break;

    case '/campaigns/create' :
        showPage('/views/campaigns/store.php', true);
        break;

    case '/campaigns/store' :
        showPage('/controller/campaign.php', true);
        break;

    case '/leads' :
        showPage('/views/leads/index.php');
        break;

    case '/leads/create' :
        showPage('/views/leads/store.php');
        break;

    case '/leads/store' :
        showPage('/controller/lead.php');
        break;

    default:
        switch (true) {
            case preg_match('/^\/employees\/edit\/([0-9]+)$/', $request, $matches):
                $employee_id = $matches[1];
                showPage('/views/employees/edit.php', true);
                break;

            case preg_match('/^\/campaigns\/edit\/([0-9]+)$/', $request, $matches):
                $campaign_id = $matches[1];
                showPage('/views/campaigns/edit.php', true);
                break;

            case preg_match('/^\/gameplays\/edit\/([0-9]+)$/', $request, $matches):
                $gameplay_id = $matches[1];
                showPage('/views/gameplays/edit.php');
                break;

            case preg_match('/^\/leads\/edit\/([0-9]+)$/', $request, $matches):
                $lead_id = $matches[1];
                showPage('/views/leads/edit.php');
                break;

            default:
                include_once __DIR__ . '/views/404.php';
                break;
        }
        break;
}