<?php
    $user = Structure::verifyAdminSession();
    Structure::header();

    $genericDAO = new GenericDAO;
?>
        <main>
          <header class="center">
            <h1>Gerar listas</h1>
          </header>
          <section class="wrapper center">
            <form method="GET" action="<?=APP_URL?>/admin/transaction/action/export">
              <div class="input_line center">
                <div class="input_container fourth fnone">
                  <label for="status">Status</label>
                  <select id="status" name="status">
                    <option value="1">Confirmadas</option>
                    <option value="2">Credenciadas</option>
                    <option value="0">Pagamentos Pendentes</option>
                  </select>
                </div>
              </div>
              <div class="input_line submit_line center">
                <input type="submit" name="gerar" value="Gerar" class="positive">
              </div>
            </form>
          </section>
        </main>
<?php Structure::footer(); ?>
