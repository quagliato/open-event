<?php
  setcookie('user_id', '', (time()-1000), '/');
  Structure::redir('/');
?>
