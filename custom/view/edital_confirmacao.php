<?php
    $usuario = Structure::verifySession();
    Structure::header();

    $genericDAO = new GenericDAO;
    $editalDAO = new EditalDAO;

    $id = $_GET['id'];
    $edital = $genericDAO->selectAll("Edital", "id = $id");

    if (!$edital || !$editalDAO->isEditalOpen($edital->get('id'))) {
        Structure::redir("/");
    }

    $notification = new Notification;
    $subject = DEFAULT_EMAIL_SUBJECT." / ".$edital->get("nome")." - Confirmação de inscrição";
    $mailResult = $notification->sendEmail($usuario->get('email'), $subject, $message)
    $mailHTML = "";
    $mailHTML .= "<br /><br /><h2>Parabéns! Sua submissão ao edital de {$edital->get('nome')} foi recebida.</h2>
        <p>Caso tenha dúvidas, entre em contato através de <a href=\"mailto:editais@nsp2015.com.br\" alt=\"E-mail para editais@nsp2015.com.br\" title=\"E-mail para editais@nsp2015.com.br\" href=\"mailto:editais@nsp2015.com.br\">editais@nsp2015.com.br</a>.</p>";

?>
        <main>
            <header class="center">
                <h1><?=$edital->get('nome')?></h1>
            </header>
            <section class="wrapper center">
                <p><i class="fa fa-check-circle-o" style="color:#1DA075; font-size:100px; text-align:center;"></i>
                <h2>Parabéns! Sua submissão ao edital de <?=$edital->get('nome')?> foi recebida.</h2>
                <p>Caso tenha dúvidas, entre em contato através de <a href="mailto:editais@nsp2015.com.br" alt="E-mail para editais@nsp2015.com.br" title="E-mail para editais@nsp2015.com.br" href="mailto:editais@nsp2015.com.br">editais@nsp2015.com.br</a>.</p>
                <p class="center"><a href="<?=APP_URL?>/dashboard" alt="Voltar para o painel" title="Voltar para o painel" class="submit positive">Voltar para o painel.</a></p>
            </section>
        </main>
<?php Structure::footer(); ?>
