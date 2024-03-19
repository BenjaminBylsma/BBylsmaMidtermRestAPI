<?php
include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$categories = new Category($db);

$data = json_decode(file_get_contents('php://input'));

if (!empty($data->id)) { 
    
    $categories->id = $data->id;
    $categories->read_single();
    
    if ($categories->category != null){          

        if($categories->delete()){
            echo json_encode(array('id'=> $categories->id));
        } else {
            echo json_encode(array('message'=> 'category_id Not Found'));
        }
    } else {
        echo json_encode(array('message'=> 'category_id Not Found'));
    }
} else {
    $categories->missingData();
}