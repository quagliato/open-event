<?php

class Blacklist extends GenericClass{
    protected static $sys_tablename = "blacklist";

    protected $id;
    protected $user_email;

    protected $sys_type = array(
        'id' => 'int',
        'user_email' => 'str'
    );
}

?>
