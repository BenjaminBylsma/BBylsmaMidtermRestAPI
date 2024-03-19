<?php
include_once '../../config/Database.php';
include_once '../../models/Author.php';

$database = new Database();
$db = $database->connect();

$authors = new Author($db);

$data = json_decode(file_get_contents('php://input'));


if (!empty($data->id)) {
    
    $authors->id = $data->id;
    $authors->read_single();

    if ($authors->author != null){

        if (!empty($data->author)) {

            $authors->author = $data->author;
            

            if($authors->update()){
                echo json_encode(
                    array(
                        'id'=> $authors->id,
                        'author' => $authors->author
                    ));
            } else {
                echo json_encode(array('message'=> 'author_id Not Found'));
            }
        } else {
            print_r(json_encode(array('message'=> 'Missing Required Parameters')));
        }
    } else {
        echo json_encode(array('message'=> 'author_id Not Found'));
    }
} else {
    print_r(json_encode(array('message'=> 'Missing Required Parameters')));
}