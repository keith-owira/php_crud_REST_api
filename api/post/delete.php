<?php

//headers

header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:DELETE');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers:,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

//Instantiate DB & Connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$post = new Post($db);

//GET RAW POSTED DATA IN THIS CASE JUST THE ID
$data = json_decode(file_get_contents("php://input"));

//SET ID TO DELETED POST
$post ->id =$data->id;

//Delete Post
if($post ->delete()){
    echo json_encode(
        array('message'=>'Post Deleted')
    );
}else{
    echo json_encode(
        array('message'=>'Post Not Deleted')
    ); 
}
