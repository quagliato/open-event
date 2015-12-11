<?php

class DBStuff {

    private $db_host;
    private $db_user;
    private $db_pass;
    private $db_name;
    private $sql;
    private $conn;

    function __construct() {
      $this->set('db_host', DB_HOST);
      $this->set('db_user', DB_USER);
      $this->set('db_pass', DB_PASS);
      $this->set('db_name', DB_NAME);
    }

    public function connect() {
      $conn = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name );
      if ($conn->connect_error) {
        $this->error($conn->connect_error);
      }
      $this->conn = $conn;
      return $conn;
    }

    public function query() {
      $query = $this->conn->query($this->sql);
      $logEngine = new LogEngine(LOG_FILE);
      $logEngine->log("SQL", $this->sql);

      // TODO: How to catch error in SQL Query?

      return $query;
    }

    public function set($prop, $value) {
      $this->$prop = $value;
    }

    private function error($error) {
      $logEngine = new LogEngine(LOG_FILE);
      $logEngine->log("SQL_ERROR", $error);
    }

    public function testDB(){
      try {
        $this->connect();
        if (is_null($this->conn) || $this->conn->connect_error) {
          return false;
        }
        return true;
      } catch (Exception $e) {
        $this->error($e);
        return false;
      }
    }

    public function execute($sql) {
      $this->connect();
      if (UTF8ENCODED === true) {
          $sql = utf8_decode($sql);
      }
      $this->set('sql',$sql);

      $rs = $this->query();
      $thread = $this->conn->thread_id;
      $this->conn->close();
      $this->conn->kill($thread);
      return $rs;
    }
}

?>