<?php
    $user = Structure::verifyAdminSession();
    Structure::header();

    $genericDAO = new GenericDAO;
?>
        <main>
          <header class="center">
            <h1>Exportar listas de credenciamento</h1>
          </header>
          <section class="wrapper">
            <form method="GET" action="<?=APP_URL?>/admin/transaction/action/export">
              <div class="input_line">
                <div class="input_container half">
                  <label for="status">Status</label>
                  <select id="status" name="status">
                    <option value="1">Confirmadas</option>
                    <option value="2">Credenciadas</option>
                    <option value="0">Pagamentos Pendentes</option>
                  </select>
                </div>
              </div>

              <div class="input_line">
                <div class="input_container fourth">
                  <br>
                  <input type="checkbox" id="show_edital" name="show_edital" value="1">
                  <label for="show_edital">Editais</label>
                </div>

                <div class="input_container fourth last">
                <br>
                  <input type="checkbox" id="show_exempted" name="show_exempted" value="1">
                  <label for="show_exempted">Isentos</label>
                </div>

                <div class="input_container fourth">
                  <br>
                  <input type="checkbox" id="only_edital" name="only_edital" value="1">
                  <label for="only_edital">Somente Editais</label>
                </div>

                <div class="input_container fourth last">
                <br>
                  <input type="checkbox" id="only_exempted" name="only_exempted" value="1">
                  <label for="only_exempted">Somente Isentos</label>
                </div>
              </div>

              <div class="input_line submit_line center">
                <input type="submit" name="gerar" value="Exportar" class="positive">
              </div>
            </form>
          </section>
        </main>
<?php Structure::footer(); ?>
