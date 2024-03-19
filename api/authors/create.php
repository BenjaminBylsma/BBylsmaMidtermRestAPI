<?php
include_once '../../config/Database.php';
include_once '../../models/Author.php';

$database = new Database();
$db = $database->connect();

$authors = new Author($db);

$data = json_decode(file_get_contents('php://input'));

if (!empty($data->author)){
    $authors->author = $data->author;

    //author query
    if($authors->create()){
        $author_arr = array(
            'id' => $authors->id,
            'author' => $authors->author
        );
        print_r(json_encode($author_arr));
    }
}
else {
    $authors->missingData();
}