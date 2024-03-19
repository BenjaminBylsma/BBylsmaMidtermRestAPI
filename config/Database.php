<?php
    class Database{
        private $host;
        private $dbname;
        private $username;
        private $password;
        private $port;
        private $conn;

        //DB Construct
        public function __construct(){
            $this->username = getenv('DBUSERNAME');
            $this->password = getenv('DBPASSWORD');
            $this->dbname = getenv('DBDBNAME');   
            $this->host = getenv('DBHOST');
            $this->port = getenv('DBPORT');
        }
        //DB Connnect
        public function connect(){
            if ($this->conn)
                return $this->conn;
            else{
                $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->dbname}";
                try{
                    $this->conn = new PDO($dsn, $this->username, $this->password);
                    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    return $this->conn;                    
                } catch(PDOException $e){
                    echo "Connection Error: " . $e->getMessage();
                }
            }
        }
    }