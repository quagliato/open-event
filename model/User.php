<?php

class User extends GenericClass{
  protected static $sys_tablename = "user";

  protected $id;
  protected $name;
  protected $password;
  protected $email;
  protected $dt_register;
  protected $dt_last_login;
  protected $role;

  protected $sys_type = array(
    'id' => 'int',
    'name' => 'str',
    'password' => 'str',
    'email' => 'str',
    'dt_register' => 'date',
    'dt_last_login' => 'date',
    'role' => 'str'
  );

  protected static $createSQL = "
    CREATE TABLE IF NOT EXISTS user (
      id int(11) NOT NULL AUTO_INCREMENT,
      name VARCHAR(100) NOT NULL,
      password VARCHAR(64) NOT NULL,
      email VARCHAR(100) NOT NULL,
      dt_register timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
      dt_last_login timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
      role VARCHAR(3) NOT NULL DEFAULT 'USR',
      PRIMARY KEY (id)
    );
  ";
}
?>
