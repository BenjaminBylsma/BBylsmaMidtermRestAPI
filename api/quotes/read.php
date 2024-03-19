<?php
include_once '../../config/Database.php';
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->connect();

$quotes = new Quote($db);

if ($quotes->author_id = isset($_GET['author_id'])){
    $quotes->author_id = $_GET['author_id'];

    if($quotes->getAuthorName() != null){

        if($quotes->category_id = isset($_GET['category_id'])){
            $quotes->category_id = $_GET['category_id'];

            if($quotes->getCategoryName() != null){
                $result = $quotes->read_author_and_category();
                print_query_results($result);

            } else{
                echo json_encode(array('message'=> 'category_id Not Found'));
            }

        } else {
            $result = $quotes->read_author();
            print_query_results($result);        
        }

    } else {
        echo json_encode(array('message'=> 'author_id Not Found'));
    }

} else if ($quotes->category_id = isset($_GET['category_id'])){
    $quotes->category_id = $_GET['category_id'];

    if($quotes->getCategoryName() != null){
        $result = $quotes->read_category();
        print_query_results($result);

    } else {
        echo json_encode(array('message'=> 'category_id Not Found'));
    }

} else {
    //quote query
    $result = $quotes->read();
    print_query_results($result);
}

function print_query_results($result){
    $num = $result->rowCount();

    if($num > 0){
        //post array
        $quotes_arr = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            
            $quotes_item = array(
                'id' => $id,
                'quote' => $quote,
                'author' => $author,
                'category' => $category
            );
            array_push($quotes_arr, $quotes_item);
        }

        //turn to JSON for output
        echo json_encode($quotes_arr);

    } else {
        //no quotes
        echo json_encode(array('message' => 'No Posts Found'));
    }
}