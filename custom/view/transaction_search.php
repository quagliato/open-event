<?php
    Structure::header();

    $genericDAO = new GenericDAO;
?>
        <main>
            <header class="center">
                <h1>Buscar Inscrição</h1>
            </header>
            <section class="wrapper center">
                <form method="POST">
                    <div class="input_line center">
                        <div class="input_container fourth">
                            <label for="id">Número de Inscrição</label>
                            <input name="id" type="text" id="id">
                        </div>
                        <div class="input_container fourthfnone">
                            <label for="">&nbsp;</label>
                            <a class="submit positive" id="searchTransactionID" href="#">Buscar</a>
                            <script>
                              var searchTransaction = function(){
                                var values = {};
                                values['id'] = $('#id').val();
                                $.post(
                                  rootURL + '/transaction/action/search',
                                  values,
                                  function(data) {
                                    if (data.length > 0) {
                                      jsonObj = JSON.parse(data);
                                      $('#searchResult #status').html(jsonObj.status);
                                      $('#searchResult #name').html(jsonObj.name);
                                    }
                                  }
                                );
                              }
                              $('body').delegate('#searchTransactionID', 'click', function(event){
                                event.preventDefault();
                                searchTransaction();
                              });

                              $('body').delegate('form', 'submit', function(event){
                                event.preventDefault();
                                searchTransaction();
                              });
                            </script>
                        </div>
                    </div>

                    <div class="input_line center">
                        <div class="input_container half" id="searchResult">
                            <h2 id="status"><h2>
                            <p id="name"></p>
                        </div>
                    </div>
                </form>
            </section>
        </main>
<?php Structure::footer(); ?>
