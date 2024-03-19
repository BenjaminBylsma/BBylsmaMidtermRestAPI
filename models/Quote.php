<?php
class Quote {
    private $conn;
    private $table = 'quotes';

    public $id;
    public $quote;
    public $author_id;
    public $category_id;
    
    //constructor
    public function __construct($db){
        $this->conn = $db;
    }

    //get posts
    public function read(){
        $sql = "SELECT 
            q.id,
            q.quote,
            a.author,
            c.category
        FROM quotes q
        LEFT JOIN authors a ON q.author_id = a.id
        LEFT JOIN categories c ON q.category_id = c.id";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute();

        return $stmt;
    }

    public function read_single(){
        $sql = "SELECT 
            q.id,
            q.quote,
            a.author,
            c.category
        FROM quotes q
        LEFT JOIN authors a ON q.author_id = a.id
        LEFT JOIN categories c ON q.category_id = c.id
        WHERE q.id = :id";

        $stmt = $this->conn->prepare($sql);        

        $stmt->execute(['id' => $this->id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row > 0){
            $this->quote = $row['quote'];
            $this->author_id = $row['author'];
            $this->category_id = $row['category'];
        }
    }

    public function update(){

        $sql = "UPDATE quotes SET quote = :quote, author_id = :author_id, category_id = :category_id WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $this->quote = htmlspecialchars((strip_tags(($this->quote))));
        $this->author_id = htmlspecialchars((strip_tags(($this->author_id))));
        $this->category_id = htmlspecialchars((strip_tags(($this->category_id))));

        if ($stmt->execute([':quote' => $this->quote, ':author_id' => $this->author_id, ':category_id' => $this->category_id, ':id' => $this->id])){
            return true;
        }
        return false;
    }

    public function create(){
        $sql = 'INSERT INTO quotes(id, quote, author_id, category_id) VALUES(DEFAULT, :quote, :author_id, :category_id)';

        $stmt = $this->conn->prepare($sql);
        $this->quote = htmlspecialchars((strip_tags(($this->quote))));
        $this->author_id = htmlspecialchars((strip_tags(($this->author_id))));
        $this->category_id = htmlspecialchars((strip_tags(($this->category_id))));

        if ($stmt->execute(['quote'=> $this->quote, 'author_id' => $this->author_id, 'category_id'=> $this->category_id])){

            $this->id = $this->getMaxID();
            return true;
        }
        return false;
        
    }

    public function delete(){
        $sql = 'DELETE FROM quotes WHERE id = :id';

        $stmt = $this->conn->prepare($sql);
        $this->id = htmlspecialchars((strip_tags(($this->id))));

        if($stmt->execute(['id'=> $this->id])){
            return true;
        }
        return false;

        
    }

    public function read_author(){
        $sql = "SELECT 
            q.id,
            q.quote,
            a.author,
            c.category
        FROM quotes q
        LEFT JOIN authors a ON q.author_id = a.id
        LEFT JOIN categories c ON q.category_id = c.id
        WHERE q.author_id = :author_id";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute(['author_id' => $this->author_id]);

        return $stmt;
    }

    public function read_category(){
        $sql = "SELECT 
            q.id,
            q.quote,
            a.author,
            c.category
        FROM quotes q
        LEFT JOIN authors a ON q.author_id = a.id
        LEFT JOIN categories c ON q.category_id = c.id
        WHERE q.category_id = :category_id";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute(['category_id' => $this->category_id]);

        return $stmt;
    }

    public function read_author_and_category(){
        $sql = "SELECT 
            q.id,
            q.quote,
            a.author,
            c.category
        FROM quotes q
        LEFT JOIN authors a ON q.author_id = a.id
        LEFT JOIN categories c ON q.category_id = c.id
        WHERE q.author_id = :author_id AND q.category_id = :category_id";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute(['author_id' => $this->author_id, 'category_id' => $this->category_id]);

        return $stmt;
    }

    public function missingData(){
        print_r(json_encode(array('message'=> 'Missing Required Parameters')));
    }

    private function getMaxID(){
        $maxID = 'SELECT MAX(id) FROM quotes';
            $newStmt = $this->conn->prepare($maxID);
            
            $newStmt->execute();
            
            $row = $newStmt->fetch(PDO::FETCH_ASSOC);

            return $row['max'];
    }

    public function getAuthorName(){
        $authorSql = "SELECT * FROM authors WHERE id=:id";
        $authorStmt = $this->conn->prepare($authorSql);

        $authorStmt->execute(['id' => $this->author_id]);
        $row = $authorStmt->fetch(PDO::FETCH_ASSOC);

        if($row > 0)
            return $row['author'];
    }

    public function getCategoryName(){
        $categorySql = "SELECT * FROM categories WHERE id=:id";
        $categoryStmt = $this->conn->prepare($categorySql);

        $categoryStmt->execute(['id' => $this->category_id]);
        $row = $categoryStmt->fetch(PDO::FETCH_ASSOC);

        if($row > 0)
            return $row['category'];
    }

    public function getQuote(){
        $quoteSql = "SELECT * FROM quotes WHERE id=:id";
        $quoteStmt = $this->conn->prepare($quoteSql);

        $quoteStmt->execute(['id' => $this->id]);
        $row = $quoteStmt->fetch(PDO::FETCH_ASSOC);

        if($row > 0)
            return $row['quote'];
    }
}