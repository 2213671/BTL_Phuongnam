<?php
class DB {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "phuongnam_db";
    private $port = 3306;
    public $con;

    public function __construct() {
        try {
            $this->con = new PDO(
                "mysql:host={$this->host};port={$this->port};dbname={$this->dbname};charset=utf8mb4",
                $this->username,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    protected function nextUsersPrimaryKey(): int {
        $row = $this->single('SELECT COALESCE(MAX(user_id), 0) + 1 AS n FROM users');
        $n = (int) ($row['n'] ?? 1);

        return $n >= 1 ? $n : 1;
    }

    public function query($sql, $params = []) {
        $stmt = $this->con->prepare($sql);
        $stmt->execute($params);

        return $stmt;
    }

    public function single($sql, $params = []) {
        $stmt = $this->query($sql, $params);

        return $stmt->fetch();
    }

    public function all($sql, $params = []) {
        $stmt = $this->query($sql, $params);

        return $stmt->fetchAll();
    }
}
