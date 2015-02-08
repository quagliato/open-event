<?php

class Notification {

    public static function formatMessage($message) {
        $message = DEFAULT_EMAIL_GREETING.$message;
        $message .= "<p>Dúvidas? Entre em contato pelo endereço e-mail ".DEFAULT_HUMAN_EMAIL.".</p>";
        $message .= DEFAULT_EMAIL_SIGN;

        return $message;
    }

    public function sendEmail($to, $subject, $message) {
        $from = DEFAULT_EMAIL_FROM;

        $additional_headers = "MIME-Version: 1.0\n";
        $additional_headers .= "Content-type: text/html; charset=utf-8\n";
        $additional_headers .= "From: ".$from;

        $message = Notification::formatMessage($message);

        $result = mail($to, $subject, $message, $additional_headers);

        return $result;
    }

    public function sendEmailRestorePassword($to, $customized_message) {
        $subject = APP_TITLE." - Restauração de Senha";

        $message = "<p>Um pedido de restauração de senha para sua conta foi requisitado em nosso site.</p>";
        $message .= "<p>Caso você não tenha realizado esse pedido, ignore essa mensagem.<br />";
        $message .= " Caso tenha realizado, clique no link abaixou (ou copie ele para a barra de endereços do seu navegador) e altere sua senha.</p>";
        $message .= $customized_message;

        return $this->sendEmail($to, $subject, $message);
    }

    public function sendEmailConfirmSignUp($to) {
        $subject = APP_TITLE." - Cadastro";

        $message = "<p>Muito obrigado por se cadastro em nosso sistema.</p>";
        $message .= "<p>Algumas dicas sobre o funcionamento dele pra você</p>";
        $message .= "<ul>";
        $message .= "<li>Login: Sempre que quiser entrar em nosso sistema, rume para ".APP_URL.".</li>";
        $message .= "<li>Painel: No painel que você tem acesso a todas suas informações de inscrição.</li>";
        $message .= "<li>Alterar cadastro: altere informações mais sensíveis de seu cadastro.</li>";
        $message .= "</ul>";

        return $this->sendEmail($to, $subject, $message);
    }
}
