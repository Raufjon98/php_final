<?php

session_start();

require_once 'autoload.php';
require_once 'Router.php';
require_once 'routes.php';







// $url = $_SERVER['REQUEST_URI'];
// $url = rtrim($url, '/'); 

// $parts = explode('/', $url);
// switch ($parts[1]) {
//     case 'user':
//         $id  = $parts[2] ?? null;
//         break;
//     case 'login':
//         $id = null;
//         break;
//     case 'logout':
//         $id = null;
//         break;
//     case 'resetPassword':
//         $id  = $parts[2] ?? null;
//         break;
//     case 'admin':
//         if ($parts[2] === 'user') {
//             $id  = $parts[3] ?? null;
//         } else {
//             http_response_code(404);
//             exit;
//         }
//         break;
//     case 'file':
//         $id  = $parts[2];
//         if ($id  === 'share') {
//             $fileId  = $parts[3];
//             $userId = $parts[4];
//         }
//         break;
//     case 'directory':
//         $id  = $parts[2] ?? null;
//         break;
//     default:
//         http_response_code(404);
//         exit;
// }
// if ($parts[1] === 'user') {
   
//     if (is_null($id)) {
//         switch ($method) {
//             case 'GET':
//                 $result = UserService::load();
//                 var_dump($result);
//                 break;
//             case 'POST':
//                 UserService::save($_POST);
//                 break;

//             default:
//                 echo 'your method is incorrect for this app!';
//                 http_response_code(404);
//         }
//     } elseif (is_numeric($id)) {
//         switch ($method) {
//             case 'GET':
//                 print_r(UserService::loadById($id));
//                 break;
//             case 'POST':
//                 UserService::update($_POST, $id);
//                 break;
//             case 'DELETE':
//                 UserService::delete($id);
//                 echo 'User status changed to deleted!';
//                 http_response_code(404);
//                 break;
//             default:
//                 echo 'your method is incorrect for this app!';
//                 http_response_code(404);
//         }
//     }elseif($id==='search'){
//         if($method==='GET'){
//             $email = $parts[3];
//             UserService::search($email);
//         }
//     } else echo 'Id must be numeric';
//     http_response_code(404);
// } elseif ($parts[1] === 'admin' && $parts[2] === 'user') {
//     if (is_null($id)) {
//         if ($method === 'GET') {
//            UserService::load();
//         } else  echo 'your method is incorrect for this app!';
//         http_response_code(404);
//     } elseif (is_numeric($id)) {
//         switch ($method) {
//             case 'GET':
//                 UserService::loadById($id);
//                 break;
//             case 'POST':
//                 UserService::update($_POST, $id);
//                 break;
//             case 'DELETE':
//                 UserService::delete($id);
//                 echo 'User status changed to deleted!';
//                 http_response_code(404);
//                 break;
//             default:
//                 echo 'your method is incorrect for this app!';
//                 http_response_code(404);
//         }
//     } else echo 'Id have be numeric';
//     http_response_code(404);
// } elseif ($parts[1] === 'login') {
//     if ($method === 'POST') {
//         UserService::login($_POST['email'], $_POST['password']);
//     } else echo 'Method is not POST!';
// } elseif ($parts[1] === 'logout') {
//    UserService::logout();
// } elseif ($parts[1] === 'resetPassword') {
//     if ($method === 'POST' && (!empty($_POST['email']))) {
//         if ($_POST['action'] == 'reset') {
//             UserService::resetPassword($_POST['email']);
//         }
//         if ($_POST['action'] == 'update') {
//            UserService::updatePassword($_POST['email'], $_POST['pass1'], $_POST['pass2']);
//         }
//     } elseif ($method === 'GET' && (!empty($_GET['email']))) {
//         echo 'Write form to user for generating new password!';
//         http_response_code(404);
//     } else echo 'Method is not POST!';
//     http_response_code(404);
// } elseif ($parts[1] === 'file') {
//         if (empty($id)) {
//         switch ($method) {
//             case 'GET':
//                 var_dump(FileService::load());
//                 break;
//             case 'POST':
              
//                     if(ValidationService::checkFileValid($_POST))
//                     {
//                         FileService::addFile($_FILES, $_POST['id_dir']);
//                     }elseif(ValidationService::renameFileValid($_POST)){
//                         FileService::moveFile($_POST['newName'], $_POST['id_dir'], $_POST['id_file']);
//                     }
//                 break;
//             default:
//                 http_response_code(404);
//                 echo 'your method is incorrect for this app!';
//         }
//     } elseif (is_numeric($id)) {
//         switch ($method) {
//             case 'GET':
//                var_dump(FileService::loadById($id));
//                 break;
//             case 'DELETE':
//                FileService::delete($id);
//                 break;
//             default:
//                 echo 'Your method is incorrect for this app!';
//                 http_response_code(404);
//         }
//     } elseif ($id === 'share') {
//         if($method === 'GET'){
//             if ($fileId != '') {
//                 if ($userId == '') {
//                    var_dump( FileAccessService::loadAccess($fileId));
//                 } else {
//                     $data = ['id_user'=>$userId, 'id_file'=>$fileId];
//                     if ($method === 'DELETE') {
//                         FileAccessService::delete($data);
//                     } elseif ($method === 'PUT') {
//                         FileAccessService::save($data);
//                     } else  echo 'Your method is incorrect for this app!';
//                     http_response_code(404);
//                 }
//             } else echo 'share must have id';
//         }
//     } else {
//         echo 'id must be numeric!';
//         http_response_code(404);
//     }
// } elseif ($parts[1] === 'directory') {
//     if (is_null($id)) {
//         if($method ==='POST'){
//             if (isset($_POST['add']) && $_POST['add'] == 'directory') {
//                 DirectoryService::addDirectory($_POST);
//              } elseif (isset($_POST['update']) && $_POST['update'] == 'rename') {
//                 echo 'update';
//                  DirectoryService::renameDirectory($_POST);
//              } else echo 'Your method is incorrect for this app!';
//              http_response_code(404);
//         }
//     } elseif (is_numeric($id)) {
//         switch ($method) {
//             case 'GET':
//                 DirectoryService::loadById($id);
//                 break;
//             case 'PUT':
//                 DirectoryService::renameDirectory($id);
//                 break;
//             case 'DELETE':
//                 DirectoryService::delete($id);
//                 break;
//             default:
//                 echo 'Your method is incorrect for this app!';
//                 http_response_code(404);
//         }
//     } else echo 'Id have be numeric!';
//     http_response_code(404);
// } else {
//     echo 'URL is absent. Please enter true url!';
//     http_response_code(404);
// }
