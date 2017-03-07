<?php

class PagSeguroNotification extends GenericClass{

    protected static $sys_tablename = "pagseguro_notification";

    protected $id;
    protected $dt_notification;
    protected $notification_type;
    protected $notification_code;
    protected $status;

    protected $sys_type = array(
        'id' => 'int',
        'dt_notification' => 'date',
        'notification_type' => 'str',
        'notification_code' => 'str',
        'status' => 'int'
    );

    protected static $createSQL = "
      CREATE TABLE IF NOT EXISTS pagseguro_notification (
        id INT NOT NULL AUTO_INCREMENT,
        dt_notification TIMESTAMP NOT NULL,
        notification_type VARCHAR(20) NOT NULL,
        notification_code VARCHAR(100) NOT NULL,
        status INT NOT NULL DEFAULT 0,
        PRIMARY KEY (id)
      );
    ";
}
?>
