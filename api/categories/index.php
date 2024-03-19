<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: ORigin, Accept, Content-Type, X-Requested-Width');
    exit();
}

switch($method){
    case 'GET':
        include_once('../categories/read_single.php');
        break;
    case 'POST':
        include_once('../categories/create.php');
        break;
    case 'PUT':
        include_once('../categories/update.php');
        break;
    case 'DELETE':
        include_once('../categories/delete.php');
        break;
}