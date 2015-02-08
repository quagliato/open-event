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
}
?>
