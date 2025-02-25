<?php
// Inclui o arquivo config.php e obtém o array de configuração
$config = include(LIB_PATH_INC . "config.php");

// Define constantes com base nas credenciais do banco de dados
define('DB_HOST', $config['db_host']);
define('DB_USER', $config['db_user']);
define('DB_PASS', $config['db_pass']);
define('DB_NAME', $config['db_name']);

class PDO_DB extends PDO
{

  public $query_id;

  public function __construct()
  {
    try {
      parent::__construct("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
      $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->exec("set names utf8");
    } catch (PDOException $e) {
      die("Falha ao conectar com o banco de dados: " . $e->getMessage());
    }
  }

  /*--------------------------------------------------------------*/
  /* Function for Close database connection
  /*--------------------------------------------------------------*/
  public function db_disconnect()
  {
    $this->query_id = null;
  }

  /*--------------------------------------------------------------*/
  /* Function for Query Helper
  /*--------------------------------------------------------------*/
  public function fetch_array($statement)
  {
    return $statement->fetch(PDO::FETCH_BOTH);
  }

  public function fetch_object($statement)
  {
    return $statement->fetch(PDO::FETCH_OBJ);
  }

  public function fetch_assoc($statement)
  {
    return $statement->fetch(PDO::FETCH_ASSOC);
  }

  public function num_rows($statement)
  {
    return $statement->rowCount();
  }

  public function insert_id()
  {
    return $this->lastInsertId();
  }

  public function affected_rows()
  {
    return $this->query_id->rowCount();
  }

  /*--------------------------------------------------------------*/
  /* Function for Remove escapes special
  /* characters in a string for use in an SQL statement
  /*--------------------------------------------------------------*/
  public function escape($str)
  {
    return $this->quote($str);
  }

  /*--------------------------------------------------------------*/
  /* Function for while loop
  /*--------------------------------------------------------------*/
  public function while_loop($loop)
  {
    $results = array();
    while ($result = $this->fetch_array($loop)) {
      $results[] = $result;
    }
    return $results;
  }
}

$db = new PDO_DB();
