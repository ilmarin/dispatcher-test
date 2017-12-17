<?php
namespace cls;

class Db
{

    /**
     * Connection instance
     *
     * @var \PDO
     */
    private $conn;

    public function __construct()
    {
        try {
            $this->conn = new \PDO('mysql:host=' . MYSQL_HOST . ';dbname=' . MYSQL_DB . ';charset=utf8', MYSQL_USER, MYSQL_PASSWORD);
        } catch (\PDOException $e) {
            echo 'Connection error: ' . $e;
        }
    }

    /**
     * Query data
     *
     * @param string $sql
     * @return array
     */
    public function query($sql)
    {
        return $this->conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }
}
