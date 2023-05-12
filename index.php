<?php

/* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */

// date_default_timezone_set("Asia/Kolkata");

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
$date = '([0-9]{4}-(0[0-9]|1[0-2])-(0[0-9]|[1-2][0-9]|3[0-1]))';

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
        showPage('/controller/employees/create.php', [], true);
        break;

    case '/employees/store' :
        showPage('/controller/employees/store.php', [], true);
        break;

    case '/gameplays' :
        showPage('/controller/gameplays/index.php');
        break;

    case '/gameplays/create' :
        showPage('/controller/gameplays/create.php');
        break;

    case '/gameplays/store' :
        showPage('/controller/gameplays/store.php');
        break;

    case '/acampaigns' :
        showPage('/views/campaigns/index.php', [], true);
        break;

    case '/acampaigns/create' :
        showPage('/controller/campaigns/create.php', [], true);
        break;

    case '/acampaigns/store' :
        showPage('/controller/campaigns/store.php', [], true);
        break;

    case '/leads' :
        showPage('/controller/leads/index.php');
        break;

    case '/leads/create' :
        showPage('/controller/leads/create.php');
        break;

    case '/leads/store' :
        showPage('/controller/leads/store.php');
        break;

    case '/targets' :
        showPage('/controller/targets/index.php');
        break;

    case '/targets/leads' :
        showPage('/controller/targets/leads.php');
        break;

    case '/targets/create' :
        showPage('/controller/targets/create.php', [], true);
        break;

    case '/targets/store' :
        showPage('/controller/targets/store.php', [], true);
        break;

    default:
        switch (true) {
            case preg_match('/^\/employees\/edit\/([0-9]+)$/', $request, $matches):
                showPage('/controller/employees/edit.php', [ 'employee_id' => $matches[1] ], true);
                break;

            case preg_match('/^\/acampaigns\/edit\/([0-9]+)$/', $request, $matches):
                showPage('/controller/campaigns/edit.php', [ 'campaign_id' => $matches[1] ], true);
                break;

            case preg_match('/^\/gameplays\/'.$date.'\/?([0-9]+)?$/', $request, $matches):
                showPage('/controller/gameplays/index.php', [ 'date' => $matches[1], 'employee_id_param' => $matches[4] ]);
                break;

            case preg_match('/^\/gameplays\/edit\/([0-9]+)$/', $request, $matches):
                showPage('/controller/gameplays/edit.php', [ 'gameplay_id' => $matches[1] ]);
                break;

            case preg_match('/^\/leads\/'.$date.'\/?([0-9]+)?$/', $request, $matches):
                showPage('/controller/leads/index.php', [ 'date' => $matches[1], 'state_id' => $matches[4] ]);
                break;

            case preg_match('/^\/leads\/'.$date.'\/?([0-9]+)?\/([0-9]+)?$/', $request, $matches):
                showPage('/controller/leads/index.php', [ 'date' => $matches[1], 'state_id' => $matches[4], 'employee_id_param' => $matches[5] ], true);
                break;

            case preg_match('/^\/leads\/edit\/([0-9]+)$/', $request, $matches):
                showPage('/controller/leads/edit.php', [ 'lead_id' => $matches[1] ]);
                break;

            case preg_match('/^\/targets\/'.$date.'\/?([0-9]+)?$/', $request, $matches):
                showPage('/controller/targets/index.php', [ 'date' => $matches[1], 'state_id' => $matches[4] ]);
                break;

            case preg_match('/^\/targets\/leads\/'.$date.'\/?([0-9]+)?$/', $request, $matches):
                showPage('/controller/targets/leads.php', [ 'date' => $matches[1], 'state_id' => $matches[4] ]);
                break;

            case preg_match('/^\/targets\/view\/([0-9]+)$/', $request, $matches):
                showPage('/controller/targets/view.php', [ 'target_id' => $matches[1] ]);
                break;

            case preg_match('/^\/targets\/edit\/([0-9]+)$/', $request, $matches):
                showPage('/controller/targets/edit.php', [ 'target_id' => $matches[1] ], true);
                break;

            default:
                include_once __DIR__ . '/views/404.php';
                break;
        }
        break;
}