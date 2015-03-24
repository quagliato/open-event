<?php

    // Add your customized URLs as $custom_urlpatterns[key] = value.
    $custom_urlpatterns = array(
        // Override noisy-cricket
        "/usuario/cadastrar" => "view/usuario.php",
        "/action/usuario/cadastrar" => "action/usuario_cadastrar.php",

        "/admin/edital" => "view/edital_admin.php",
        "/admin/edital/action/insert" => "action/edital_01_insert.php",
        "/admin/edital/action/update" => "action/edital_02_update.php",
        "/admin/edital/action/delete" => "action/edital_03_delete.php",
        "/admin/edital/action/list" => "action/edital_04_list.php",

        "/admin/edital/buscar" => "view/edital_admin_buscar.php",
        "/admin/edital/buscar/action" => "action/edital_admin_buscar.php",

        "/admin/resposta-edital/action/approve" => "action/resposta-edital_approve.php",
        "/admin/resposta-edital/action/deny" => "action/resposta-edital_deny.php",
        "/admin/resposta-edital/action/pre-select" => "action/resposta-edital_pre-select.php",
        "/admin/resposta-edital/action/status" => "action/resposta-edital_status.php",

        "/admin/pergunta" => "view/pergunta_admin.php",
        "/admin/pergunta/action/insert" => "action/pergunta_01_insert.php",
        "/admin/pergunta/action/update" => "action/pergunta_02_update.php",
        "/admin/pergunta/action/delete" => "action/pergunta_03_delete.php",
        "/admin/pergunta/action/list" => "action/pergunta_04_list.php",
        "/admin/pergunta/action/max-ordem_exibicao" => "action/pergunta_05_max-ordem_exibicao.php",

        "/admin/valor-possivel" => "view/valor-possivel_admin.php",
        "/admin/valor-possivel/action/insert" => "action/valor-possivel_01_insert.php",
        "/admin/valor-possivel/action/update" => "action/valor-possivel_02_update.php",
        "/admin/valor-possivel/action/delete" => "action/valor-possivel_03_delete.php",
        "/admin/valor-possivel/action/list" => "action/valor-possivel_04_list.php",

        "/edital" => "view/edital.php",
        "/edital/action" => "action/edital.php",
        "/edital/confirmacao" => "view/edital_confirmacao.php",

        "/admin/edital/email/approved" => "action/edital_email_approved.php",
    );

?>
