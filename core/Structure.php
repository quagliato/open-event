<?php

class Structure {
    public static function redir($page) {
        $page = APP_URL.$page;
        echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page' />";
        exit;
    }

    public static function redirWithMessage($message, $page) {
        echo "<script>alert('".$message."');</script>";
        Structure::redir($page);
    }

    public static function dashboardLink() {
        $text = NULL;
        if (!isset($text) || is_null($text) || $text == "") {
            $text = "Voltar ao painel";
        }

        return "<a href=\"".APP_URL."/dashboard\">$text</a>";
    }

    public static function verifySession() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            Structure::redirWithMessage("Usuario nao logado.", '/'); //TODO: Adicionar acento
        } else {
            $usuario_dao = new UsuarioDAO;
            $usuario = $usuario_dao->getUserById($_SESSION['user_id']);
            if (!$usuario) {
                Structure::redirWithMessage("Usuario nao encontrado no sistema.","/"); //TODO: Adicionar acento
            } else {
                return $usuario;
            }
        }
    }

    public static function verifySpecificRole($role) {
        $usuario = Structure::verifySession();

        if ($usuario->get('privilegio') == $role) {
            return $usuario;
        }

        Structure::redirWithMessage("Area restrita.", "/"); //TODO: Adicionar acento
    }


    public static function verifyAdminSession() {
        return Structure::verifySpecificRole('ADM');
    }

    public static function header() {
        include_once("theme/header.php");
    }

    public static function customHeader($header) {
        include_once("theme/header-$header.php");
    }

    public static function footer() {
        include_once("theme/footer.php");
    }

    public static function customFooter($footer) {
        include_once("theme/footer-$footer.php");
    }
}
?>
