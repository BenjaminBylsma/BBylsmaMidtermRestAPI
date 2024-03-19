<?php
include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$categories = new Category($db);


//author query
if ($categories->id = isset($_GET['id'])){
    $categories->id = $_GET['id'];

        
    $categories->read_single();
    if($categories->category != null){
        $category_arr = array(
            'id' => $categories->id,
            'category' => $categories->category
        );

        //create json for output
        print_r(json_encode($category_arr));
    } else {
        print_r(json_encode(array('error'=> 'No data found to match id')));
    }
} else{
    include_once('../categories/read.php');
}