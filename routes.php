<?php
// $router = new Router();
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$parts = explode('/', $uri);
if ($parts[2] !== '') {
    if (is_numeric($parts[2])) {
        $id = $parts[2];
    } elseif ($parts[2] === 'share') {
        if($parts[3]!=='' && is_numeric($parts[3])){
            $fileId  = $parts[3];
            if($parts[4]!=='' && is_numeric($parts[4])){
                $userId = $parts[4];
            }else{echo 'Wrong user id';}
        }else {echo 'Wrong file id'; }
                }else {
        $id = '';
    }
}
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

// $router->get($uri,FileService::load());
$router->get('/user', UserService::load()); //get users
if($_POST['action']=='add'){
    $router->post('/user', UserService::save($_POST)); //add user (parameters: email, fullName, age, gender, password)
}
$router->get('/file', FileService::load());  //get files
// $router->get('/',);
// $router->get('/',);
if ($id !== '') {
    if(!isset($_POST)){
        $router->get('/user/'. $id, UserService::loadById($id)); //user description
        $router->delete('/user/' . $id, UserService::delete($id)); //delete user
        $router->get('/file/' . $id, FileService::loadById($id));  //file description
        $router->delete('/file/'.$id, FileService::delete($id)); // delete file
    }else {
      if ($_POST['action']=='update') {
      }  $router->put('/user/'. $id, UserService::update($_POST,$id)); //update user description with ooptions: email, password, fullName, age, gender, id
    }
  
}
var_dump($uri);
var_dump($router->route($uri, $method));
var_dump($_POST);