<?php
include_once '../../config/Database.php';
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->connect();

$quotes = new Quote($db);

$data = json_decode(file_get_contents('php://input'));

if (!empty($data->id)) { 
    
    $quotes->id = $data->id;    

    if ($quotes->getQuote() != null){        

        if($quotes->delete()){
            echo json_encode(array('id'=> $quotes->id));
        } else {
            echo json_encode(array('message'=> 'No Quotes Found'));
        }
    } else {
        echo json_encode(array('message'=> 'No Quotes Found'));
    }
} else {
    echo json_encode(array('message'=> 'No Quotes Found'));
}