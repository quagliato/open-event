<?php
    Structure::verifyAdminSession();
    Structure::header();

    $genericDAO = new GenericDAO;
?>
        <main>
            <header class="center">
                <h1>Inscrição > Transferir</h1>
            </header>
            <section class="wrapper">
                <form method="POST" action="<?=APP_URL?>/admin/transaction/action/transfer" class="new_submit needs-confirmation" data-confirm-msg="Deseja realmente transferir essa inscrição?">

                    <div class="half fleft">
                        <h3>Origem</h3>
                        <p>Buscar usuário
                        <div class="input_line">
                            <div class="input_container three-fourths">
                                <label for="origin_user_search">Nome, e-mail ou CPF</label>
                                <input type="text" name="origin_user_search" id="origin_user_search">
                            </div><!-- /.input_container-->
                            <div class="input_container sixth last">
                                <label for="">&nbsp;</label>
                                <button class="user_search_btn search_transaction" data-value="origin_user_search" data-target="origin_user_info" data-transaction-target="origin_user_products">Buscar</button>
                            </div><!-- /.input_container-->
                        </div><!-- /.input_line-->
                        <div id="origin_user_info" class="full">
                            <input type="hidden" class="id" name="origin_user_id" id="origin_user_id" required>
                            <p><strong>ID:</strong> <span class="id"></span></p>
                            <p><strong>Nome:</strong> <span class="nome"></span></p>
                            <p><strong>CPF:</strong> <span class="cpf"></span></p>
                            <p><strong>E-mail:</strong> <span class="email"></span></p>
                        </div><!--/#origin_user_info-->
                        <div id="origin_user_products" class="full">
                        </div><!--/#origin_user_products-->
                    </div><!--/.half-->

                    <div class="half fleft last">
                        <h3>Destino</h3>
                        <p>Buscar usuário
                        <div class="input_line">
                            <div class="input_container three-fourths">
                                <label for="destiny_user_search">Nome, e-mail ou CPF</label>
                                <input type="text" name="destiny_user_search" id="destiny_user_search">
                            </div><!-- /.input_container-->
                            <div class="input_container sixth last">
                                <label for="">&nbsp;</label>
                                <button class="user_search_btn" data-value="destiny_user_search" data-target="destiny_user_info">Buscar</button>
                            </div><!-- /.input_container-->
                        </div><!-- /.input_line-->
                        <div id="destiny_user_info" class="full">
                            <input type="hidden" class="id" name="destiny_user_id" id="destiny_user_id" required>
                            <p><strong>ID:</strong> <span class="id"></span></p>
                            <p><strong>Nome:</strong> <span class="nome"></span></p>
                            <p><strong>CPF:</strong> <span class="cpf"></span></p>
                            <p><strong>E-mail:</strong> <span class="email"></span></p>
                        </div><!--/#destiny_user_info-->
                    </div><!--/.half-->

                    <div class="input_line submit_line right">
                        <a href="#" class="submit negative cancel">Cancelar</a>
                        <input type="submit" name="Transferir" value="Transferir" class="positive disabled" disabled>
                    </div>

                    <script>
                        $(document).delegate('input.transaction', 'click', function(event){
                            validateValuesAndEnableSubmit();
                        });

                        $(document).delegate('.user_search_btn', 'click', function(event){
                            event.preventDefault();

                            var btn = $(this);

                            var action = rootURL + "/admin/user/action/search";
                            var values = {}
                            values['term'] = $('#' + $(this).attr('data-value')).val();

                            var target = $("#" + $(this).attr("data-target"));

                            $.post(
                                action,
                                values,
                                function(data){
                                    if (data.length > 0) {
                                        var jsonObj = JSON.parse(data);
                                        if (jsonObj && jsonObj.status == 1 && jsonObj.users.length == 1) {
                                            var user = jsonObj.users[0];
                                            for (var key in user) {
                                                if (user.hasOwnProperty(key)) {
                                                    var targetItem = target.find("." + key);
                                                    if (targetItem.is("input")) {
                                                        targetItem.val(user[key]);
                                                    } else {
                                                        targetItem.html(user[key]);
                                                    }
                                                    validateValuesAndEnableSubmit();
                                                }
                                            }

                                            if (btn.hasClass("search_transaction")) {
                                                // TODO: Think a way to trigger this action as a callback os user's search
                                                var showTransactions = function(transactions) {
                                                    if (transactions !== false && transactions !== undefined) {
                                                        var html = "<h3 class=\"mt20\">Transações</h3><div class=\"input_line\"><div class=\"input_container full\"><ul>";
                                                        transactions.forEach(function(entry){
                                                            html += "<li><input class=\"transaction\" type=\"checkbox\" name=\"product_transfer\" value=\"" + entry.id + "\">" + entry.id + "</li>";
                                                        });
                                                        html += "</ul></div></div>";
                                                        $('#' + btn.attr('data-transaction-target')).html(html); // TODO: Think a way to set this selector as a parameter
                                                        validateValuesAndEnableSubmit();
                                                    }
                                                };

                                                searchTransactionsByUser(user.id, showTransactions);
                                            }
                                        } else {
                                            alert("Usuário não encontrado.");
                                        }
                                    }
                                }
                            );
                        });

                        function searchTransactionsByUser(idUser, callback) {
                            var action = rootURL + "/admin/transaction/action/search_by_user";
                            var values = {}
                            values['idUser'] = idUser;

                            $.post(
                                action,
                                values,
                                function(data){
                                    if (data.length > 0) {
                                        var jsonObj = JSON.parse(data);
                                        if (jsonObj && jsonObj.status == 1 && jsonObj.transactions.length > 0) {
                                            console.log(jsonObj);
                                            callback(jsonObj.transactions);
                                            return jsonObj.transactions;
                                        }
                                    }
                                    return false;
                                }
                            );
                        }

                        function validateValuesAndEnableSubmit() {
                            var transactionsChecked = false;

                            $('input.transaction').each(function(){
                                if ($(this).is(":checked")) transactionsChecked = true;
                            });

                            if ($('#destiny_user_id').val() != "" && $('#origin_user_id').val() != "" && transactionsChecked) {
                                $('input[name=Transferir]').removeClass("disabled").removeAttr("disabled");
                            }
                        }
                    </script>
                </form>
            </section>
        </main>
<?php Structure::footer(); ?>
