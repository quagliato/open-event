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

    public static function verifySession($where2go = false, $values = false, $verbose = true) {
        if (!isset($_COOKIE['user_id'])) {
            if ($where2go) {
                $where2goAux = $where2go."?";
                if ($values) {
                    foreach($_GET as $key => $value) {
                        $where2goAux .= "$key=$value";
                    }
                }
                
                setcookie('noisy-cricket_goto',$where2goAux->get('id'),0,'/');
            }
            if ($verbose) {
                Structure::redirWithMessage("Não se esqueça de fazer login ou se cadastrar.", '/');
            } else {
                Structure::redir('/');
            }
        } else {
            $userDAO = new UserDAO;
            $user = $userDAO->getUserById($_COOKIE['user_id']);
            if (!$user) {
                
                if ($verbose) {
                    Structure::redirWithMessage("Você não foi encontrado no sistema.","/");
                } else {
                    Structure::redir('/');
                }
            } else {
                return $user;
            }
        }
    }

    public static function verifySpecificRole($role) {
        $user = Structure::verifySession();

        if ($user->get('role') == $role) {
            return $user;
        }

        Structure::redirWithMessage("Area restrita.", "/"); //TODO: Adicionar acento
    }


    public static function verifyAdminSession() {
        return Structure::verifySpecificRole('ADM');
    }

    public static function header($header = null) {
        if ($header && !is_null($header) && strlen($header) > 0) {
            include_once("theme/".THEME."/header-$header.php");
        } else {
            include_once("theme/".THEME."/header.php");
        }
        
    }

    public static function footer($footer = null) {
        if ($footer && !is_null($footer) && strlen($footer) > 0) {
            include_once("theme/".THEME."/footer-$footer.php");
        } else {
            include_once("theme/".THEME."/footer.php");
        }
    }
}
?>
