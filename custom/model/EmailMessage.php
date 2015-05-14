<?php

class EmailMessage extends GenericClass{

    protected static $sys_tablename = "email_message";

    protected $id;
    protected $dt_sent;
    protected $email;
    protected $subject;
    protected $message;
    protected $status;

    protected $sys_type = array(
        'id' => 'int',
        'dt_sent' => 'date',
        'email' => 'str',
        'subject' => 'str',
        'message' => 'str',
        'status' => 'int',
    );

    // protected static $createSQL = "
        // CREATE TABLE IF NOT EXISTS email_message (
        //     id INT NOT NULL AUTO_INCREMENT,
        //     dt_sent TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        //     email VARCHAR(200) NOT NULL,
        //     subject VARCHAR(1000) NOT NULL,
        //     message VARCHAR(50000) NOT NULL,
        //     status INT NOT NULL DEFAULT 0,
        //     PRIMARY KEY (id)
        // );
    // ";
}
?>
