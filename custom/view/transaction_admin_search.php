<?php
    $user = Structure::verifyAdminSession();
    Structure::header();

    $genericDAO = new GenericDAO;
?>
        <main>
          <header class="center">
            <h1>Buscar Inscrição</h1>
          </header>
          <section class="wrapper center">
            <form method="POST" action="<?=APP_URL?>/admin/transaction/action/search" class="new_submit">
              <div class="input_line">
                <p class="note"><em>Preencha pelo menos um dos dois</em></p>
              </div>
              <div class="input_line center">
                <!-- <div class="input_container fourth fnone">
                  <label for="id">Número de Inscrição</label>
                  <input name="id" type="text" id="id">
                </div> -->
                <div class="input_container fourth fnone">
                  <label for="cpf">CPF</label>
                  <input name="cpf" type="text" id="cpf" class="cpf">
                </div>
                <div class="input_container fourth fnone">
                  <label for="email">E-mail</label>
                  <input name="email" type="email" id="email">
                </div>
              </div>
              <div class="input_line submit_line center">
                <input type="submit" name="buscar" value="Buscar" class="positive">
              </div>
            </form>
          </section>
        </main>
<?php Structure::footer(); ?>
