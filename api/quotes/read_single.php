<?php
include_once '../../config/Database.php';
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->connect();

$quotes = new Quote($db);


//quote query
if ($quotes->id = isset($_GET['id'])){
    $quotes->id = $_GET['id'];


    $quotes->read_single();

    if ($quotes->quote != null){
        $quote_arr = array(
            'id' => $quotes->id,
            'quote' => $quotes->quote,
            'author_id' => $quotes->author_id,
            'category_id'=> $quotes->category_id
        );

        //create json for output
        print_r(json_encode($quote_arr));
    } else {
        print_r(json_encode(array('error'=> 'No data found to match id')));
    }
} else {
    include_once('../quotes/read.php');
}