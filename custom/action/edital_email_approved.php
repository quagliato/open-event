<?php
    $user = Structure::verifyAdminSession();
    Structure::header();

    $genericDAO = new GenericDAO;



    $respostasEdital = $genericDAO->selectAll("RespostaEdital", "status = 1");
?>
        <main>
            <header class="center">
                <h1>Respostas de Editais</h1>
            </header>
            <section class="wrapper">
            <?php
                if ($respostasEdital) :
                    if (!is_array($respostasEdital)) :
                        $respostasEdital = array($respostasEdital);
                    endif;
            ?>
                <div class="input_line submit_line right">
                    <a href="#" class="submit negative cancel">Voltar</a>
                </div>
                <table style="font-size:12px;" class="jquerydatatable">
                    <thead>
                        <td class="center" style="width:5%;">ID</td>
                        <td class="left" style="width:20%;">Edital</td>
                        <td class="left" style="width:20%;">Usuário</td>
                        <td class="left" style="width:20%;">Data</td>
                        <td class="left" style="width:15%;">Status</td>
                        <td class="center" style="width:20%;"></td>
                    </thead>
                    <?php
                        $count = 0;

                        foreach ($respostasEdital as $respostaEdital) :
                            $edital = $genericDAO->selectAll('Edital', 'id = '.$respostaEdital->get('id_edital'));
                            $user = $genericDAO->selectAll('User', 'id = '.$respostaEdital->get('id_user'));
                            $message = "";
                            $message .= "<p>Parabéns! Você foi aprovado no edital de <strong>".$edital->get('nome')."</strong> do ".APP_TITLE."!</p>";
                            $message .= "<p>Gostaríamos de te agradecer por essa vontade de nos ajudar na construção do nosso encontro. Caso não tenha marcado na sua agenda, o ".APP_TITLE." vai acontecer dos dias ".DATE_EVENT_STR.". :D</p>";
                            $message .= "<p><strong>IMPORTANTE:</strong> Precisamos que você responda esse e-mail confirmando a sua participação nesse edital o qual foi aprovado até dia <strong>".DATE_EDITAL_CONFIRMATION."!</strong></p>";
                            $message .= "<p>Se precisar falar alguma coisa que seja muito importante para nosso conhecimento, a hora também é essa! ;)</p>";
                            $message .= "<p>Com carinho,</p>";

                            $notification = new Notification;
                            $subject = DEFAULT_EMAIL_SUBJECT." / ".$edital->get("nome")." - ".$respostaEdital->get('id')." - Confirmação";

                            $mailResult = $notification->sendEmail($user->get('email'), $subject, $message, DEFAULT_EMAIL_FROM_EDITAIS);
                    ?>
                        <tr <?php if ($count % 2 == 0) { echo 'style="background-color: #CCCCCC;"'; } ?>>
                            <td class="center"><?=$respostaEdital->get('id')?></td>
                            <td class="left"><?=$edital->get('nome')?></td>
                            <td class="left"><?=$user->get('nome')?></td>
                            <td class="left"><?=Utils::sqlTimestamp2BrFormat($respostaEdital->get('dt_fim_resposta'))?></td>
                            <td class="left"><?=RespostaEditalStatus::getTextStatus($respostaEdital->get('status'))?></td>
                            <td class="center"><?=$mailResult ? "E-mail enviado." : "E-mail não enviado."?></td>
                        </tr>
                    <?php 
                            $count++; 
                        endforeach;
                    ?>
                </table>
            <?php else: ?>
                <h2 class="center">Nenhum registro encontrado</h2>
            <?php endif; ?>
            </section>
        </main>

<?php Structure::footer(); ?>