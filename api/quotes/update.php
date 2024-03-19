<?php
include_once '../../config/Database.php';
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->connect();

$quotes = new Quote($db);

$data = json_decode(file_get_contents('php://input'));

if (!empty($data->id)) {

    $quotes->id = $data->id;
    $quotes->read_single();

    if ($quotes->quote != null){

        if (!empty($data->quote)){

            $quotes->quote = $data->quote;

            if (!empty($data->author_id)){

                $quotes->author_id = $data->author_id;

                if($quotes->getAuthorName() != null){

                    if (!empty($data->category_id)){

                        $quotes->category_id = $data->category_id;

                        if ($quotes->getCategoryName() != null){

                            if($quotes->update()){
                                echo json_encode(array(
                                    'id' => $quotes->id,
                                    'quote'=> $quotes->quote,
                                    'author_id' => $quotes->author_id,
                                    'category_id' => $quotes->category_id
                                ));
                            } else {
                                echo json_encode(array('message'=> 'No Quotes Found'));
                            }
                        } else {
                            echo json_encode(array('message'=> 'category_id Not Found'));
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

        } else {
            print_r(json_encode(array('message'=> 'Missing Required Parameters')));       
        }
    } else {
        echo json_encode(array('message'=> 'No Quotes Found'));
    }
} else {
    echo json_encode(array('message'=> 'No Quotes Found'));
}