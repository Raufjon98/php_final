<?php

session_start();
include_once 'autoload.php';

// if($_SESSION['intrance'] !==1 ){
//     header('location login.php')
// }else{

// }

$url = $_SERVER['REQUEST_URI'];
$url = rtrim($url, '/'); 
$method = $_SERVER['REQUEST_METHOD'];
$parts = explode('/', $url);
switch ($parts[1]) {
    case 'user':
        $id  = $parts[2] ?? null;
        break;
    case 'login':
        $id = null;
        break;
    case 'logout':
        $id = null;
        break;
    case 'resetPassword':
        $id  = $parts[2] ?? null;
        break;
    case 'admin':
        if ($parts[2] === 'user') {
            $id  = $parts[3] ?? null;
        } else {
            http_response_code(404);
            exit;
        }
        break;
    case 'file':
        $id  = $parts[2];
        if ($id  === 'share') {
            $fileId  = $parts[3];
            $userId = $parts[4];
        }
        break;
    case 'directory':
        $id  = $parts[2] ?? null;
        break;
    default:
        http_response_code(404);
        exit;
}

if ($parts[1] === 'user') {
    if (is_null($id)) {
        switch ($method) {
            case 'GET':
                User::userList();
                break;
            case 'POST':
                User::create($_POST);
                break;

            default:
                echo 'your method is incorrect for this app!';
                http_response_code(404);
        }
    } elseif (is_numeric($id)) {
        switch ($method) {
            case 'GET':
                User::getUser($id);
                break;
            case 'POST':
                User::update($_POST, $id);
                break;
            case 'DELETE':
                USer::delete($id);
                echo 'User status changed to deleted!';
                http_response_code(404);
                break;
            default:
                echo 'your method is incorrect for this app!';
                http_response_code(404);
        }
    }elseif($id==='search'){
        $email = $parts[3];
       User::search($email);
    } else echo 'Id must be numeric';
    http_response_code(404);
} elseif ($parts[1] === 'admin' && $parts[2] === 'user') {
    if (is_null($id)) {
        if ($method === 'GET') {
           User::userList();
        } else  echo 'your method is incorrect for this app!';
        http_response_code(404);
    } elseif (is_numeric($id)) {
        switch ($method) {
            case 'GET':
                User::getUser($id);
                break;
            case 'POST':
                User::update($_POST, $id);
                break;
            case 'DELETE':
                User::delete($id);
                echo 'User status changed to deleted!';
                http_response_code(404);
                break;
            default:
                echo 'your method is incorrect for this app!';
                http_response_code(404);
        }
    } else echo 'Id have be numeric';
    http_response_code(404);
} elseif ($parts[1] === 'login') {
    if ($method === 'POST') {
        User::login($_POST['email'], $_POST['password']);
    } else echo 'Method is not POST!';
} elseif ($parts[1] === 'logout') {
   USer::logout();
} elseif ($parts[1] === 'resetPassword') {
    if ($method === 'POST' && (!empty($_POST['email']))) {
        if ($_POST['action'] == 'reset') {
            User::resetPassword($_POST['email']);
        }
        if ($_POST['action'] == 'update') {
           User::updatePassword($_POST['email'], $_POST['pass1'], $_POST['pass2']);
        }
    } elseif ($method === 'GET' && (!empty($_GET['email']))) {
        echo 'Write form to user for generating new password!';
        http_response_code(404);
    } else echo 'Method is not POST!';
    http_response_code(404);
} elseif ($parts[1] === 'file') {
        if (empty($id)) {
        switch ($method) {
            case 'GET':
                File::fileList();
                break;
            case 'POST':
                if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'upload') {
                    if ($_POST['action'] === 'add') {
                        File::addFile($_FILES, $_POST['id_dir']);
                    }
                    if ($_POST['action'] === 'move') {
                       File::moveFile($_POST['newName'], $_POST['id_dir'], $_POST['id_file']);
                    }
                }
                break;
            default:
                http_response_code(404);
                echo 'your method is incorrect for this app!';
        }
    } elseif (is_numeric($id)) {
        switch ($method) {
            case 'GET':
                File::getFile($id);
                break;
            case 'DELETE':
               File::deleteFile($id);
                break;
            default:
                echo 'Your method is incorrect for this app!';
                http_response_code(404);
        }
    } elseif ($id === 'share') {
        if ($fileId != '') {
            if ($userId == '') {
                File::fileAccess($fileId);
            } else {
                if ($method === 'DELETE') {
                    File::removeAccess($fileId, $userId);
                } elseif ($method === 'PUT') {
                    File::addAccess($fileId, $userId);
                } else  echo 'Your method is incorrect for this app!';
                http_response_code(404);
            }
        } else echo 'share must have id';
    } else {
        echo 'id must be numeric!';
        http_response_code(404);
    }
} elseif ($parts[1] === 'directory') {
    if (is_null($id)) {
        if (isset($_POST['add']) && $_POST['add'] == 'directory') {
           File::addDir($_POST);
        } elseif (isset($_POST['update']) && $_POST['update'] == 'rename') {
            File::renameDir($_POST);
        } else echo 'Your method is incorrect for this app!';
        http_response_code(404);
    } elseif (is_numeric($id)) {
        switch ($method) {
            case 'GET':
                File::getDir($id);
                break;
            case 'PUT':
                File::renameDir($id);
                break;
            case 'DELETE':
                File::deleteDir($id);
                break;
            default:
                echo 'Your method is incorrect for this app!';
                http_response_code(404);
        }
    } else echo 'Id have be numeric!';
    http_response_code(404);
} else {
    echo 'URL is absent. Please enter true url!';
    http_response_code(404);
}
