<?php
    $user = Structure::verifyAdminSession();
    
    $perguntaDAO = new PerguntaDAO;

    if (array_key_exists("edital", $_POST)) {
        echo $perguntaDAO->maxOrdemExibicaoByEdital(intval($_POST['edital'])) ;
    } else {
        echo 1;
    }
?>
