<?php

    session_start();
    $_SESSION['user_id'] = "";
    unset($_SESSION['user_id']);
    session_destroy();

    Structure::redir('/');
?>
