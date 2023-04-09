<?php

class Post{
    //DB Stuff

    private $conn;
    private $table = 'posts';

    //Posts Properties
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $author;
    public $created_at;

    //Constructor with DB
    public function __construct($db) 
    {
        $this->conn= $db;
    }

    //Get Post
    public function read(){
        //CREATE QUERY
        $query = 'SELECT c.name as category_name,
        p.id,
        p.category_id,
        p.title,
        p.body,
        p.author,
        p.created_at
        FROM
        '. $this->table .' p
         LEFT JOIN
         categories c ON p.category_id = c .id
         ORDER BY 
         p.created_at DESC';

         //Prepared statement
         $stmt = $this->conn->prepare($query);

         //Execute the query
         $stmt ->execute();

         return $stmt;
    }

    //Get Single Post
    public function read_single_post(){
        //Query
        $query = 'SELECT c.name as category_name,
        p.id,
        p.category_id,
        p.title,
        p.body,
        p.author,
        p.created_at
        FROM
         '. $this->table .' p
        LEFT JOIN
         categories c ON p.category_id = c .id
        WHERE
         p.id = ?
        LIMIT 0,1';

        //Prepared statement
        $stmt = $this->conn->prepare($query);

        //Bind ID 
        $stmt ->bindParam(1, $this->id);
        
        //Execute statement
        $stmt ->execute();

        $row = $stmt ->fetch(PDO::FETCH_ASSOC);

        //Set Property
        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];
    }

    //CREATE TABLE IF NOT EXISTS
    public function create(){
        //CREATE QUERY
        $query = 'INSERT INTO '. $this->table. '
        SET 
            title = :title,
            body = :body,
            author = :author,
            category_id = :category_id';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean Data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
    
        //Bind Data
        $stmt ->bindParam(':title', $this->title);
        $stmt ->bindParam(':body', $this->body);
        $stmt ->bindParam(':author', $this->author);
        $stmt ->bindParam(':category_id', $this->category_id);

        //Excecute Query
        if($stmt->execute()){
            return true;
        }else{
            //Print Error if something is wrong
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }

    //Update Post
    public function update(){
        //CREATE QUERY
        $query = 'UPDATE '. $this->table. '
        SET 
            title = :title,
            body = :body,
            author = :author,
            category_id = :category_id
            
            WHERE 
            ID = :id';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean Data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));
    
        //Bind Data
        $stmt ->bindParam(':title', $this->title);
        $stmt ->bindParam(':body', $this->body);
        $stmt ->bindParam(':author', $this->author);
        $stmt ->bindParam(':category_id', $this->category_id);
        $stmt ->bindParam(':id', $this->id);

        //Excecute Query
        if($stmt->execute()){
            return true;
        }else{
            //Print Error if something is wrong
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }
    
    //Delete Post
    public function delete(){

        $query ='DELETE FROM '.$this->table.'
        WHERE ID = :id';

        
        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean the id
        $this->id = htmlspecialchars(strip_tags($this->id));

        //Bind the ID
        $stmt ->bindParam(':id', $this->id);

        //Execute the query
        if($stmt->execute()){
            return true;
        }else{
            //Print Error if something is wrong
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }
}
