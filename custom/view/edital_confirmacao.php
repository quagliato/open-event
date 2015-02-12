<?php
    $usuario = Structure::verifySession();
    Structure::header();

    $genericDAO = new GenericDAO;
    $editalDAO = new EditalDAO;

    $id = $_GET['id'];
    $edital = $genericDAO->selectAll("Edital", "id = $id");

    // TODO: Implementa isEditalOpen on EditalDAO
    // if (!$edital || !$editalDAO->isEditalOpen($edital->get('id'))) {
    if (!$edital) {
        Structure::redir("/");
    }

    $notification = new Notification;
    $subject = DEFAULT_EMAIL_SUBJECT." / ".$edital->get("nome")." - Confirmação de inscrição";
    $mailHTML = "";
    $mailHTML .= "<h2>Parabéns! Sua submissão ao edital de {$edital->get('nome')} foi recebida.</h2>
        <p>Caso tenha dúvidas, entre em contato através de <a href=\"mailto:".DEFAULT_EMAIL_FROM_EDITAIS."\" alt=\"E-mail para ".DEFAULT_EMAIL_FROM_EDITAIS."\" title=\"E-mail para ".DEFAULT_EMAIL_FROM_EDITAIS."\" href=\"mailto:".DEFAULT_EMAIL_FROM_EDITAIS."\">".DEFAULT_EMAIL_FROM_EDITAIS."</a>.</p>";

    $mailResult = $notification->sendEmail($usuario->get('email'), $subject, $mailHTML, DEFAULT_EMAIL_FROM_EDITAIS);

?>
        <main>
            <header class="center">
                <h1><?=$edital->get('nome')?></h1>
            </header>
            <section class="wrapper center">
                <p><i class="fa fa-check-circle-o" style="color:#1DA075; font-size:200px; text-align:center;"></i>
                <h2>Parabéns! Sua submissão ao edital de <?=$edital->get('nome')?> foi recebida.</h2>
                <p class="mt20">Caso tenha dúvidas, entre em contato através de <a href="mailto:<?=DEFAULT_EMAIL_FROM_EDITAIS?>" alt="E-mail para <?=DEFAULT_EMAIL_FROM_EDITAIS?>" title="E-mail para <?=DEFAULT_EMAIL_FROM_EDITAIS?>" href="mailto:<?=DEFAULT_EMAIL_FROM_EDITAIS?>"><?=DEFAULT_EMAIL_FROM_EDITAIS?></a>.</p>
                <p class="mt20 center"><a href="<?=APP_URL?>/dashboard" alt="Voltar para o painel" title="Voltar para o painel" class="submit positive">Voltar para o painel</a></p>
            </section>
        </main>
<?php Structure::footer(); ?>
