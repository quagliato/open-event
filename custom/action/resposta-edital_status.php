<?php
    $usuario = Structure::verifyAdminSession();
    $genericDAO = new GenericDAO;
    $return = array();

    $idRespostaEdital = false;
    if (array_key_exists('idRespostaEdital', $_GET) &&
        !is_null($_GET['idRespostaEdital']) &&
        $_GET['idRespostaEdital'] != '') {
        $idRespostaEdital = $_GET['idRespostaEdital'];
    }

    $respostaEdital = $genericDAO->selectAll('RespostaEdital', "id = $idRespostaEdital");

    if ($respostaEdital) {
        $repostaEditalStatuses = $genericDAO->selectAll("RespostaEditalStatus", "id_resposta_edital = $idRespostaEdital");

        if ($repostaEditalStatuses) {
            if (!is_array($repostaEditalStatuses)) $repostaEditalStatuses = array($repostaEditalStatuses);
            echo "<h2>Log de Alterações de Status</h2>";
            foreach ($repostaEditalStatuses as $respostaEditalStatus) {
                $user = $genericDAO->selectAll("Usuario", "id = ".$respostaEditalStatus->get('id_user'));
                echo '<p><strong>'.RespostaEditalStatus::getTextStatus($respostaEditalStatus->get('status'))."</strong> as <em>".Utils::sqlTimestamp2BrFormat($respostaEditalStatus->get('dt_update'))."</em> por <u>".$user->get('nome').'</u></p>';
            }
        }
    }
?>