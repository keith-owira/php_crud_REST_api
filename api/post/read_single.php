<?php

//headers

header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

//Instantiate DB & Connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$post = new Post($db);

//GET ID 
$post ->id = isset($_GET['id']) ? $_GET['id'] : die();

//GET POST
$post ->read_single_post();

$post_arr = array(
    'id' => $post->id,
    'title' => $post->title,
    'body'=>$post->body,
    'author'=>$post->author,
    'category_id'=>$post->category_id,
    'category_name'=>$post->category_name
);

//Make JSON
print_r(json_encode($post_arr)); 