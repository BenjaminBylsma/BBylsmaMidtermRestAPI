<?php
include_once '../../config/Database.php';
include_once '../../models/Author.php';

$database = new Database();
$db = $database->connect();

$authors = new Author($db);


//author query
if ($authors->id = isset($_GET['id'])){
    $authors->id = $_GET['id'];

        
    $authors->read_single();
    if($authors->author != null){
        $author_arr = array(
            'id' => $authors->id,
            'author' => $authors->author
        );

        //create json for output
        print_r(json_encode($author_arr));
    } else {
        print_r(json_encode(array('message'=> 'author_id Not Found')));
    }
} else {
    include_once('../authors/read.php');
}