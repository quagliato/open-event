<?php
    session_start();
    if(isset($_SESSION['user_id'])) unset($_SESSION['user_id']);

    Structure::header();
?>
        <main>
            <header class="center">
                <h1>Cadastre-se</h1>
            </header>
            <section class="wrapper">
                <form method="POST" action="<?=APP_URL?>/action/usuario/cadastrar" class="new_submit">

                    <div class="input_line">
                        <div class="input_container half">
                            <label for="nome">Nome completo*</label>
                            <input name="Usuario-nome" type="text" id="nome" required="required">
                        </div>

                        <div class="input_container fourth">
                            <label for="cpf">CPF*</label>
                            <input name="Usuario-cpf" type="text" id="cpf" required="required" class="cpf">
                        </div>

                        <div class="input_container fourth last">
                            <label for="data_nasc">Data de Nascimento*</label>
                            <input name="Usuario-data_nasc" type="text" id="data_nasc" required="required" class="date">
                        </div>
                    </div>

                    <div class="input_line">
                        <div class="input_container half">
                            <label for="deficiencia">Portador de deficiência?</label>
                            <input name="Usuario-deficiencia" type="text" id="deficiencia">
                        </div>
                    </div>

                    <div class="input_line">
                        <div class="input_container third">
                            <label for="senha">Senha*</label>
                            <input name="Usuario-senha" type="password" id="senha" required="required">
                        </div>

                        <div class="input_container third last">
                            <label for="confirmacao_senha">Confirmação Senha*</label>
                            <input name="confirmacao_senha" type="password" id="confirmacao_senha" placeholder="Confirme sua senha" required="required" onchange="validatePassword()">
                        </div>
                    </div>

                    <h2>Informações de Contato</h2>
                    <div class="input_line">
                        <div class="input_container half">
                            <label for="email">E-mail*</label>
                            <input name="Usuario-email" type="email" id="email" required="required">
                        </div>

                        <div class="input_container fourth">
                            <label for="telefone_residencial">Telefone Residencial</label>
                            <input name="Usuario-telefone_residencial" type="text" id="telefone_residencial" class="phone">
                        </div>

                        <div class="input_container fourth last">
                            <label for="telefone_celular">Telefone Celular*</label>
                            <input name="Usuario-telefone_celular" type="text" id="telefone_celular" class="mobile">
                        </div>
                    </div>

                    <div class="input_line">
                      <div class="input_container half">
                        <label for="facebook">Facebook</label>
                        <input name="Usuario-facebook" type="text" id="facebook">
                      </div>
                    </div>

                    <h2>Informações Acadêmicas</h2>
                    <div class="input_line">
                        <div class="input_container third">
                            <label for="inst_ens">Instituição de Ensino*</label>
                            <input name="Usuario-inst_ens" type="text" id="inst_ens" required="required">
                        </div>

                        <div class="input_container third">
                            <label for="curso">Curso*</label>
                            <input name="Usuario-curso" type="text" id="curso" required="required">
                        </div>

                        <div class="input_container third last">
                            <label for="periodo">Período</label>
                            <select id="periodo" name="Usuario-periodo">
                                <option value="1o">1º Período</option>
                                <option value="2o">2º Período</option>
                                <option value="3o">3º Período</option>
                                <option value="4o">4º Período</option>
                                <option value="5o">5º Período</option>
                                <option value="6o">6º Período</option>
                                <option value="7o">7º Período</option>
                                <option value="8o">8º Período</option>
                                <option value="9o">9º Período</option>
                                <option value="10o">10º Período</option>
                                <option value="GR">Graduado</option>
                            </select>
                        </div>
                    </div>

                    <h2>Endereço</h2>
                    <div class="input_line">
                        <div class="input_container half">
                            <label for="end_logradouro">Logradouro*</label>
                            <input name="Usuario-end_logradouro" type="text" id="end_logradouro" required="required">
                        </div>

                        <div class="input_container fourth">
                            <label for="end_numero">Número*</label>
                            <input name="Usuario-end_numero" type="text" id="end_numero" required="required">
                        </div>

                        <div class="input_container fourth last">
                            <label for="end_complemento">Complemento*</label>
                            <input name="Usuario-end_complemento" type="text" id="end_complemento" required="required">
                        </div>
                    </div>

                    <div class="input_line">
                        <div class="input_container fourth">
                            <label for="end_cep">CEP*</label>
                            <input name="Usuario-end_cep" type="text" id="end_cep" required="required" class="cep">
                        </div>

                        <div class="input_container fourth">
                            <label for="end_bairro">Bairro*</label>
                            <input name="Usuario-end_bairro" type="text" id="end_bairro" required="required">
                        </div>

                        <div class="input_container fourth">
                            <label for="end_estado">Estado</label>
                            <select id="end_estado" name="Usuario-end_estado">
                                <option value="AC">Acre</option>
                                <option value="AL">Alagoas</option>
                                <option value="AP">Amapá</option>
                                <option value="AM">Amazonas</option>
                                <option value="BA">Bahia</option>
                                <option value="CE">Ceará</option>
                                <option value="DF">Distrito Federal</option>
                                <option value="ES">Espírito Santo</option>
                                <option value="GO">Goiás</option>
                                <option value="MA">Maranhão</option>
                                <option value="MT">Mato Grosso</option>
                                <option value="MS">Mato Grosso do Sul</option>
                                <option value="MG">Minas Gerais</option>
                                <option value="PA">Pará</option>
                                <option value="PB">Paraíba</option>
                                <option value="PR">Paraná</option>
                                <option value="PE">Pernambuco</option>
                                <option value="PI">Piauí</option>
                                <option value="RJ">Rio de Janeiro</option>
                                <option value="RN">Rio Grande do Norte</option>
                                <option value="RS">Rio Grande do Sul</option>
                                <option value="RO">Rondônia</option>
                                <option value="RR">Roraima</option>
                                <option value="SC">Santa Catarina</option>
                                <option value="SP">São Paulo</option>
                                <option value="SE">Sergipe</option>
                                <option value="TO">Tocantins</option>
                                <option value="ES">Estrangeiro</option>
                            </select>
                        </div>

                        <div class="input_container fourth last">
                            <label for="end_cidade">Cidade*</label>
                            <input name="Usuario-end_cidade" type="text" id="end_cidade" required="required">
                        </div>
                    </div>

                    <h2>Informações do Responsável</h2>
                    <div class="input_line">
                        <div class="input_container half">
                            <label for="responsavel_nome">Nome*</label>
                            <input name="Usuario-responsavel_nome" type="text" id="responsavel_nome" required="required">
                        </div>

                        <div class="input_container fourth last">
                            <label for="responsavel_telefone">Telefone*</label>
                            <input name="Usuario-responsavel_telefone" type="text" id="responsavel_telefone" required="required" class="mobile">
                        </div>
                    </div>

                    <h2>Informações Médicas</h2>
                    <div class="input_line">
                        <div class="input_container third">
                            <label for="alergias">Alergias</label>
                            <input name="Usuario-alergias" type="text" id="alergias">
                        </div>

                        <div class="input_container third">
                            <label for="medicacao_continua">Medicação Contínua</label>
                            <input name="Usuario-medicacao_continua" type="text" id="medicacao_continua">
                        </div>

                        <div class="input_container third last">
                            <label for="plano_saude">Plano de Saúde</label>
                            <input name="Usuario-plano_saude" type="text" id="plano_saude">
                        </div>
                    </div>

                    <div class="input_line submit_line right">
                        <a href="#" class="submit negative cancel">Cancelar</a>
                        <input type="submit" name="cadastrar" value="Cadastrar" class="positive">
                    </div>
                </form>
            </section>
        </main>
<?php Structure::footer(); ?>
