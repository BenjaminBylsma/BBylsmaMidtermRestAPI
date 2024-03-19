<?php
include_once '../../config/Database.php';
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->connect();

$quotes = new Quote($db);

$data = json_decode(file_get_contents('php://input'));

if($data->quote != null){

    $quotes->quote = $data->quote;

    if($data->author_id != null){

        $quotes->author_id = $data->author_id;

        if($data->category_id != null){

            $quotes->category_id = $data->category_id;
            
            //quote query
            if($quotes->create()){
                $quote_arr = array(
                    'id' => $quotes->id,
                    'quote' => $quotes->quote,
                    'author_id' => $quotes->author_id,
                    'category_id' => $quotes->category_id
                );
                print_r(json_encode($quote_arr));
            }
        } else {
            echo json_encode(array('message'=> 'category_id Not Found'));
        }
    } else {
        echo json_encode(array('message'=> 'author_id Not Found'));
    }
} else {
    print_r(json_encode(array('message'=> 'Missing Required Parameters')));
}
