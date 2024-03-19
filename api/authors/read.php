<?php
include_once '../../config/Database.php';
include_once '../../models/Author.php';

$database = new Database();
$db = $database->connect();

$authors = new Author($db);



//author query
$result = $authors->read();

$num = $result->rowCount();

if($num > 0){
    //post array
    $authors_arr = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $authors_item = array(
            'id' => $id,
            'author' => $author
        );
        array_push($authors_arr, $authors_item);
    } 

    //turn to JSON for output
    echo json_encode($authors_arr);
} else {
    //no authors
    echo json_encode(array('message' => 'No Posts Found'));
}