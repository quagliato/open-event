<?php
    // EMAILS - EDITAIS
    // Default no-reply e-mail
    define('DEFAULT_EMAIL_FROM_EDITAIS', 'noreply@open-event.net');
    define('DATE_EVENT_STR', '19 a 26 de julho');
    define('DATE_EDITAL_CONFIRMATION', '02 de abril');

    // Defines if blacklist is going to work as blacklist or if it's going to work as whitelist
    define('BLACKLIST', 1);

    define('TERMS_LINK', '#');

    // PAYMENTS
    define('PAY_BOLETO', false);
    define('PAY_PAYPAL', false);
    define('PAY_PAGSEGURO', false);
    define('PAY_DEPOSITO', false);

    define('DEFAULT_PAYMENT', 'PGS');

    // BOLETO
    define('BANCO', '');
    define('VENCIMENTO', '');
    define('AGENCIA', '');
    define('CARTEIRA', '');
    define('CONTA', '');
    define('CONVENIO', '');
    define('CEDENTE_NOME', '');
    define('CEDENTE_NR_DOCUMENTO', '');
    define('CEDENTE_ENDERECO', '');
    define('CEDENTE_CEP', '');
    define('CEDENTE_CIDADE', '');
    define('CEDENTE_ESTADO', '');

    // PAYPAL
    define('PAYPAL_EMAIL', '');
    define('PAYPAL_ITEM_NAME', '');

    // PAGSEGURO
    define('PAGSEGURO_EMAIL', '');
    define('PAGSEGURO_TOKEN', '');
    define('PAGSEGURO_MULTIPLIER', 1.05);
    define('PAGSEGURO_MULTIPLIER_LABEL', "5%");

    // DEPOSITO
    define('DEPOSITO_EMAIL', '');
    define('DEPOSITO_BANCO', '');
    define('DEPOSITO_NOME', '');
    define('DEPOSITO_CPF', '');
    define('DEPOSITO_AGENCIA', '');
    define('DEPOSITO_CONTA', '');

    define('TRANSACTION_CANCEL_INTERVAL', 'P7D');
    define('PAYMENT_CANCEL_INTERVAL', 'P3D');

    define('GOOGLE_ANALYTICS', 'UA-XXXXXX-X');
?>
