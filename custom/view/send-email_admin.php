<?php
    Structure::verifyAdminSession();
    Structure::header();

    $genericDAO = new GenericDAO;
?>
        <main>
            <header class="center">
                <h1>E-mails</h1>
            </header>
            <section class="wrapper">
                <form method="POST" action="<?=APP_URL?>/admin/action/send-email">

                    <div class="input_line">
                        <div class="input_container third">
                            <label for="criteria">Para</label>
                            <select name="criteria" id="criteria">
                                <option value="all">Todos os cadastrados</option>
                                <option value="buyers">Todos os inscritos</option>
                                <option value="buyers_cancelled">Todos os inscritos cancelados</option>
                                <option value="edital">Todos os inscritos em editais</option>
                                <option value="edital_approved">Todos os selecionados em edital</option>
                                <option value="edital_approved_not_buyers">Todos os selecionados em edital não inscritos</option>
                                <option value="edital_with_exemption_approved">Todos os selecionados em edital com isenção</option>
                                <option value="exemptions">Todos os isentos</option>
                                <option value="transaction_less">ID Transação menor que o especificado</option>
                                <option value="specific">Critério específico</option>
                            </select>
                        </div>

                        <div class="input_container third">
                            <label for="specific">Critério específico</label>
                            <input type="text" name="specific" id="specific">
                        </div>
                    </div>

                    <div class="input_line">
                        <div class="input_container full">
                            <label for="subject">Assunto</label>
                            <input type="text" name="subject" id="subject" required="required">
                        </div>
                    </div>

                    <div class="input_line">
                        <div class="input_container full">
                            <label for="message">Texto do E-mail</label>
                            <textarea name="message" id="message" required="required" class="s"></textarea>
                        </div>
                    </div>

                    <div class="input_line">
                        <div class="input_container full">
                            <label for="preview">Prévia</label>
                            <p><strong>Assunto: </strong><span id="subject_preview"><?=DEFAULT_EMAIL_SUBJECT?></span></p>
                            <p><strong>Mensagem: </strong></p>
                            <div class="full" id="preview">
                                <?=DEFAULT_EMAIL_GREETING?>
                                <?=DEFAULT_EMAIL_SIGN?>
                            </div>
                        </div>
                    </div>

                    <div class="input_line submit_line right">
                        <a href="#" class="submit negative cancel">Cancelar</a>
                        <input type="submit" name="cadastrar" value="Cadastrar" class="positive">
                    </div>
                </form>
            </section>
        </main>
        <script>
            var defaultSubject = "<?=DEFAULT_EMAIL_SUBJECT?>";
            var defaultGreeting = "<?=DEFAULT_EMAIL_GREETING?>";
            var defaultSignature = "<?=DEFAULT_EMAIL_SIGN?>";

            // $(document).ready(function(){
                $('#message').keydown(function(e){
                    console.log($(this));
                    console.log($(this).html());
                    console.log($(this).val());
                    $('#preview').html(defaultGreeting + $(this).val() + defaultSignature);
                });

                $('#subject').keydown(function(e){
                    console.log($(this));
                    console.log($(this).html());
                    console.log($(this).val());
                    $('#subject_preview').html(defaultSubject + " - " + $(this).val());
                });
            // });
        </script>
<?php Structure::footer(); ?>
