<?php
include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$categories = new Category($db);

//category query
$result = $categories->read();

$num = $result->rowCount();

if($num > 0){
    //post array
    $categories_arr = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $categories_item = array(
            'id' => $id,
            'category' => $category
        );
        array_push($categories_arr, $categories_item);
    } 

    //turn to JSON for output
    echo json_encode($categories_arr);
} else {
    //no categories
    echo json_encode(array('message' => 'category_id Not Found'));
}