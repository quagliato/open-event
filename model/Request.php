<?php

class Request extends GenericClass{
  protected static $sys_tablename = "request";

  protected $code;
  protected $id_user;
  protected $email_sent;
  protected $sent_time;
  protected $status;

  protected $sys_type = array(
    'code' => 'str',
    'id_user' => 'int',
    'email_sent' => 'str',
    'sent_time' => 'str',
    'status' => 'int'
  );

  protected static $createSQL = "
    CREATE TABLE IF NOT EXISTS request (
      code VARCHAR(60) NOT NULL,
      id_user INT NOT NULL,
      email_sent VARCHAR(100) NOT NULL,
      sent_time VARCHAR(30) NOT NULL,
      status INT NOT NULL,
      PRIMARY KEY (code)
    );
  ";
}
?>
