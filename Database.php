<?php

class Database
{
  public $conn;

  /**
   * Constructor
   * 
   * @param array $config
   * 
   * @return void
   */
  public function __construct($config)
  {
    $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']}";

    $options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ];

    try {
      $this->conn = new PDO($dsn, $config['username'], $config['password'], $options);
    } catch (PDOException $e) {
      throw new Exception("Database connection failed: " . $e->getMessage());
    }
  }

  /**
   * Query the database.
   *
   * @param string $sql
   * @param array $params
   * 
   * @return PDOStatement
   * @throws PDOException
   */
  public function query($query, $params = [])
  {
    try {
      $stmt = $this->conn->prepare($query);

      foreach ($params as $key => $value) {
        $stmt->bindValue(":$key", $value);
      }

      $stmt->execute();
      return $stmt;
    } catch (PDOException $e) {
      throw new PDOException("Failed to query database: {$e->getMessage()}");
    }
  }
}
