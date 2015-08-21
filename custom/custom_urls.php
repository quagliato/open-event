<?php

    // Add your customized URLs as $custom_urlpatterns[key] = value.
    $custom_urlpatterns = array(
        // Override noisy-cricket
        "/usuario/cadastrar" => "view/usuario.php",
        "/action/usuario/cadastrar" => "action/usuario_cadastrar.php",

        "/infopanel" => "view/infopanel.php",

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

        "/admin/exemption" => "view/exemption_admin.php",
        "/admin/exemption/action/insert" => "action/exemption_01_insert.php",
        "/admin/exemption/action/update" => "action/exemption_02_update.php",
        "/admin/exemption/action/delete" => "action/exemption_03_delete.php",
        "/admin/exemption/action/list" => "action/exemption_04_list.php",

        "/admin/exemption-email" => "view/exemption-email_admin.php",
        "/admin/exemption-email/action/insert" => "action/exemption-email_01_insert.php",
        "/admin/exemption-email/action/update" => "action/exemption-email_02_update.php",
        "/admin/exemption-email/action/delete" => "action/exemption-email_03_delete.php",
        "/admin/exemption-email/action/list" => "action/exemption-email_04_list.php",

        "/admin/product" => "view/product_admin.php",
        "/admin/product/action/insert" => "action/product_01_insert.php",
        "/admin/product/action/update" => "action/product_02_update.php",
        "/admin/product/action/delete" => "action/product_03_delete.php",
        "/admin/product/action/list" => "action/product_04_list.php",

        "/admin/product-exclude" => "view/product-exclude_admin.php",
        "/admin/product-exclude/action/insert" => "action/product-exclude_01_insert.php",
        "/admin/product-exclude/action/update" => "action/product-exclude_02_update.php",
        "/admin/product-exclude/action/delete" => "action/product-exclude_03_delete.php",
        "/admin/product-exclude/action/list" => "action/product-exclude_04_list.php",

        "/admin/product-father" => "view/product-father_admin.php",
        "/admin/product-father/action/insert" => "action/product-father_01_insert.php",
        "/admin/product-father/action/update" => "action/product-father_02_update.php",
        "/admin/product-father/action/delete" => "action/product-father_03_delete.php",
        "/admin/product-father/action/list" => "action/product-father_04_list.php",

        "/edital" => "view/edital.php",
        "/edital/action" => "action/edital.php",
        "/edital/confirmacao" => "view/edital_confirmacao.php",

        "/admin/edital/email/approved" => "action/edital_email_approved.php",

        "/admin/send-email" => "view/send-email_admin.php",
        "/admin/action/send-email" => "action/send-email_admin.php",

        "/pacotes" => "view/product_selection.php",
        "/pagamento/metodo" => "view/payment_method.php",
        "/pagamento/metodo/late" => "view/payment_method_late.php",
        "/pagamento" => "view/payment.php",

        "/admin/transaction/transfer" => "view/transaction_transfer_admin.php",
        "/admin/transaction/action/transfer" => "action/transaction_01_transfer.php",
        "/admin/transaction/action/search_by_user" => "action/transaction_00_search_by_user.php",
        "/admin/usuario/action/search" => "action/usuario_00_search.php",

        "/admin/resposta-edital/action/export" => "action/resposta-edital_export.php",

        "/transaction/search" => "view/transaction_search.php",
        "/transaction/action/search" => "action/transaction_search.php",

        "/admin/transaction/search" => "view/transaction_admin_search.php",
        "/admin/transaction/action/search" => "action/transaction_02_admin_search.php",
        "/admin/transaction" => "view/transaction.php",
        "/admin/transaction/action/confirm" => "action/transaction_03_credenciamento.php",

    );

?>
