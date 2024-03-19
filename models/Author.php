<?php
class Author {
    private $conn;
    private $table = 'authors';

    public $id;
    public $author;

    //constructor
    public function __construct($db){
        $this->conn = $db;
    }

    //get posts
    public function read(){
        $sql = "SELECT * FROM authors";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute();

        return $stmt;
    }

    public function read_single(){
        $sql = "SELECT * FROM authors WHERE id=:id";

        $stmt = $this->conn->prepare($sql);        

        $stmt->execute(['id' => $this->id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row > 0)
            $this->author = $row['author'];        
    }

    public function update(){

        $sql = "UPDATE authors SET author = :author WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $this->author = htmlspecialchars((strip_tags(($this->author))));

        if ($stmt->execute([':author' => $this->author, ':id' => $this->id])){
            return true;
        }
        return false;
    }

    public function create(){
        $sql = 'INSERT INTO authors(id, author) VALUES(DEFAULT, :author)';

        $stmt = $this->conn->prepare($sql);
        $this->author = htmlspecialchars((strip_tags(($this->author))));

        if ($stmt->execute(['author'=> $this->author])){

            $this->id = $this->getMaxID();
            return true;
        }
        printf("ERROR: %s. \n", $stmt->error);
        return false;
        
    }

    public function delete(){
        $sql = 'DELETE FROM authors WHERE id = :id';

        $stmt = $this->conn->prepare($sql);
        $this->id = htmlspecialchars((strip_tags(($this->id))));

        if($stmt->execute(['id'=> $this->id])){
            return true;
        }
        return false;        
    }

    private function getMaxID(){
        $maxID = 'SELECT MAX(id) FROM authors';
        $newStmt = $this->conn->prepare($maxID);
        
        $newStmt->execute();
        
        $row = $newStmt->fetch(PDO::FETCH_ASSOC);

        return $row['max'];
    }
}