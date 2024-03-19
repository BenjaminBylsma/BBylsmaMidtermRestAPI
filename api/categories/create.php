<?php
include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$categories = new Category($db);

$data = json_decode(file_get_contents('php://input'));

if (!empty($data->category)){
    $categories->category = $data->category;

    //author query
    if($categories->create()){
        $category_arr = array(
            'id' => $categories->id,
            'category' => $categories->category
        );
        print_r(json_encode($category_arr));
    }
}
else {
    print_r(json_encode(array('message'=> 'Missing Required Parameters')));
}