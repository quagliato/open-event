<?php

class Blacklist extends GenericClass{
  protected static $sys_tablename = "blacklist";

  protected $id;
  protected $user_email;

  protected $sys_type = array(
      'id' => 'int',
      'user_email' => 'str'
  );

  protected static $createSQL = "
    CREATE TABLE IF NOT EXISTS blacklist (
      id INT NOT NULL AUTO_INCREMENT,
      user_email VARCHAR(100) NOT NULL,
      PRIMARY KEY (id)
    );
  ";
}

?>
