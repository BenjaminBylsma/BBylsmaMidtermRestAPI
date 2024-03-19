<?php
class Category {
    private $conn;
    private $table = 'categories';

    public $id;
    public $category;

    //constructor
    public function __construct($db){
        $this->conn = $db;
    }

    //get posts
    public function read(){
        $sql = "SELECT * FROM categories";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute();

        return $stmt;
    }

    public function read_single(){
        $sql = "SELECT * FROM categories WHERE id=:id";

        $stmt = $this->conn->prepare($sql);        

        $stmt->execute(['id' => $this->id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row > 0)
            $this->category = $row['category'];        
    }

    public function update(){

        $sql = "UPDATE categories SET category = :category WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $this->category = htmlspecialchars((strip_tags(($this->category))));

        if ($stmt->execute([':category' => $this->category, ':id' => $this->id])){
            return true;
        }
        return false;
    }

    public function create(){
        $sql = 'INSERT INTO categories(id, category) VALUES(DEFAULT, :category)';

        $stmt = $this->conn->prepare($sql);
        $this->category = htmlspecialchars((strip_tags(($this->category))));

        if ($stmt->execute(['category'=> $this->category])){

            $this->id = $this->getMaxID();

            return true;
        }
        printf("ERROR: %s. \n", $stmt->error);
        return false;
        
    }

    public function delete(){
        $sql = 'DELETE FROM categories WHERE id = :id';

        $stmt = $this->conn->prepare($sql);
        $this->id = htmlspecialchars((strip_tags(($this->id))));

        if($stmt->execute(['id'=> $this->id])){
            return true;
        }
        return false;

        
    }

    private function getMaxID(){
        $maxID = 'SELECT MAX(id) FROM categories';
            $newStmt = $this->conn->prepare($maxID);
            
            $newStmt->execute();

            $row = $newStmt->fetch(PDO::FETCH_ASSOC);

            return $row['max'];
    }
}