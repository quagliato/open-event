<?php
    $user = Structure::verifySession();
    Structure::header();
?>
        <main>
            <header class="center">
                <h1>Usuário > Alterar Cadastro</h1>
            </header>
            <section class="wrapper">
                <form action="<?=APP_URL?>/action/user/atualizar" method="post" class="new_submit">
                
                    <div class="input_line">
                        <div class="input_container half">
                            <label for="nome">Nome completo*</label>
                            <input name="User-nome" type="text" id="nome" required="required" value="<?=$user->get('nome')?>">
                        </div>

                        <div class="input_container fourth">
                            <label for="cpf">CPF*</label>
                            <input name="User-cpf" type="text" id="cpf" required="required" class="cpf" value="<?=$user->get('cpf')?>">
                        </div>

                        <div class="input_container fourth last">
                            <label for="data_nasc">Data de Nascimento*</label>
                            <input name="User-data_nasc" type="text" id="data_nasc" required="required" class="date" value="<?=$user->get('data_nasc')?>">
                        </div>
                    </div>

                    <div class="input_line">
                        <div class="input_container half">
                            <label for="deficiencia">Pessoa com deficiência?</label>
                            <input name="User-deficiencia" type="text" id="deficiencia" value="<?=$user->get('deficiencia')?>">
                        </div>
                    </div>

                    <div class="input_line">
                        <div class="input_container third">
                            <label for="password">Senha*</label>
                            <input name="User-password" type="password" id="password">
                        </div>

                        <div class="input_container third last">
                            <label for="confirmacao_senha">Confirmação Senha*</label>
                            <input name="confirmacao_senha" type="password" id="confirmacao_senha" placeholder="Confirme sua senha" onchange="validatePassword()">
                        </div>
                    </div>

                    <h2>Informações de Contato</h2>
                    <div class="input_line">
                        <div class="input_container half">
                            <label for="email">E-mail*</label>
                            <input name="User-email" type="email" id="email" required="required" value="<?=$user->get('email')?>">
                        </div>

                        <div class="input_container fourth">
                            <label for="telefone_residencial">Telefone Residencial</label>
                            <input name="User-telefone_residencial" type="text" id="telefone_residencial" class="phone" value="<?=$user->get('telefone_residencial')?>">
                        </div>

                        <div class="input_container fourth last">
                            <label for="telefone_celular">Telefone Celular*</label>
                            <input name="User-telefone_celular" type="text" id="telefone_celular" class="mobile" value="<?=$user->get('telefone_celular')?>">
                        </div>
                    </div>

                    <div class="input_line">
                      <div class="input_container half">
                        <label for="facebook">Facebook</label>
                        <input name="User-facebook" type="text" id="facebook" value="<?=$user->get('facebook')?>">
                      </div>
                    </div>

                    <h2>Informações Acadêmicas</h2>
                    <div class="input_line">
                        <div class="input_container third">
                            <label for="inst_ens">Instituição de Ensino*</label>
                            <input name="User-inst_ens" type="text" id="inst_ens" required="required" value="<?=$user->get('inst_ens')?>">
                        </div>

                        <div class="input_container third">
                            <label for="curso">Curso*</label>
                            <input name="User-curso" type="text" id="curso" required="required" value="<?=$user->get('curso')?>">
                        </div>

                        <div class="input_container third last">
                            <label for="periodo">Período</label>
                            <select id="periodo" name="User-periodo">
                                <option value="1o" <?=$user->get('periodo') == '1o' ? 'selected' : ''?>>1º Período</option>
                                <option value="2o" <?=$user->get('periodo') == '2o' ? 'selected' : ''?>>2º Período</option>
                                <option value="3o" <?=$user->get('periodo') == '3o' ? 'selected' : ''?>>3º Período</option>
                                <option value="4o" <?=$user->get('periodo') == '4o' ? 'selected' : ''?>>4º Período</option>
                                <option value="5o" <?=$user->get('periodo') == '5o' ? 'selected' : ''?>>5º Período</option>
                                <option value="6o" <?=$user->get('periodo') == '6o' ? 'selected' : ''?>>6º Período</option>
                                <option value="7o" <?=$user->get('periodo') == '7o' ? 'selected' : ''?>>7º Período</option>
                                <option value="8o" <?=$user->get('periodo') == '8o' ? 'selected' : ''?>>8º Período</option>
                                <option value="9o" <?=$user->get('periodo') == '9o' ? 'selected' : ''?>>9º Período</option>
                                <option value="10o" <?=$user->get('periodo') == '10o' ? 'selected' : ''?>>10º Período</option>
                                <option value="GR" <?=$user->get('periodo') == 'GR' ? 'selected' : ''?>>Graduado</option>
                            </select>
                        </div>
                    </div>

                    <h2>Endereço</h2>
                    <div class="input_line">
                        <div class="input_container half">
                            <label for="end_logradouro">Logradouro*</label>
                            <input name="User-end_logradouro" type="text" id="end_logradouro" required="required" value="<?=$user->get('end_logradouro')?>">
                        </div>

                        <div class="input_container fourth">
                            <label for="end_numero">Número*</label>
                            <input name="User-end_numero" type="text" id="end_numero" required="required" value="<?=$user->get('end_numero')?>">
                        </div>

                        <div class="input_container fourth last">
                            <label for="end_complemento">Complemento</label>
                            <input name="User-end_complemento" type="text" id="end_complemento" value="<?=$user->get('end_complemento')?>">
                        </div>
                    </div>

                    <div class="input_line">
                        <div class="input_container fourth">
                            <label for="end_cep">CEP*</label>
                            <input name="User-end_cep" type="text" id="end_cep" required="required" class="cep" value="<?=$user->get('end_cep')?>">
                        </div>

                        <div class="input_container fourth">
                            <label for="end_bairro">Bairro*</label>
                            <input name="User-end_bairro" type="text" id="end_bairro" required="required" value="<?=$user->get('end_bairro')?>">
                        </div>

                        <div class="input_container fourth">
                            <label for="end_estado">Estado</label>
                            <select id="end_estado" name="User-end_estado">
                                <option value="AC" <?=$user->get('end_estado') == 'AC' ? 'selected' : ''?>>Acre</option>
                                <option value="AL" <?=$user->get('end_estado') == 'AL' ? 'selected' : ''?>>Alagoas</option>
                                <option value="AP" <?=$user->get('end_estado') == 'AP' ? 'selected' : ''?>>Amapá</option>
                                <option value="AM" <?=$user->get('end_estado') == 'AM' ? 'selected' : ''?>>Amazonas</option>
                                <option value="BA" <?=$user->get('end_estado') == 'BA' ? 'selected' : ''?>>Bahia</option>
                                <option value="CE" <?=$user->get('end_estado') == 'CE' ? 'selected' : ''?>>Ceará</option>
                                <option value="DF" <?=$user->get('end_estado') == 'DF' ? 'selected' : ''?>>Distrito Federal</option>
                                <option value="ES" <?=$user->get('end_estado') == 'ES' ? 'selected' : ''?>>Espírito Santo</option>
                                <option value="GO" <?=$user->get('end_estado') == 'GO' ? 'selected' : ''?>>Goiás</option>
                                <option value="MA" <?=$user->get('end_estado') == 'MA' ? 'selected' : ''?>>Maranhão</option>
                                <option value="MT" <?=$user->get('end_estado') == 'MT' ? 'selected' : ''?>>Mato Grosso</option>
                                <option value="MS" <?=$user->get('end_estado') == 'MS' ? 'selected' : ''?>>Mato Grosso do Sul</option>
                                <option value="MG" <?=$user->get('end_estado') == 'MG' ? 'selected' : ''?>>Minas Gerais</option>
                                <option value="PA" <?=$user->get('end_estado') == 'PA' ? 'selected' : ''?>>Pará</option>
                                <option value="PB" <?=$user->get('end_estado') == 'PB' ? 'selected' : ''?>>Paraíba</option>
                                <option value="PR" <?=$user->get('end_estado') == 'PR' ? 'selected' : ''?>>Paraná</option>
                                <option value="PE" <?=$user->get('end_estado') == 'PE' ? 'selected' : ''?>>Pernambuco</option>
                                <option value="PI" <?=$user->get('end_estado') == 'PI' ? 'selected' : ''?>>Piauí</option>
                                <option value="RJ" <?=$user->get('end_estado') == 'RJ' ? 'selected' : ''?>>Rio de Janeiro</option>
                                <option value="RN" <?=$user->get('end_estado') == 'RN' ? 'selected' : ''?>>Rio Grande do Norte</option>
                                <option value="RS" <?=$user->get('end_estado') == 'RS' ? 'selected' : ''?>>Rio Grande do Sul</option>
                                <option value="RO" <?=$user->get('end_estado') == 'RO' ? 'selected' : ''?>>Rondônia</option>
                                <option value="RR" <?=$user->get('end_estado') == 'RR' ? 'selected' : ''?>>Roraima</option>
                                <option value="SC" <?=$user->get('end_estado') == 'SC' ? 'selected' : ''?>>Santa Catarina</option>
                                <option value="SP" <?=$user->get('end_estado') == 'SP' ? 'selected' : ''?>>São Paulo</option>
                                <option value="SE" <?=$user->get('end_estado') == 'SE' ? 'selected' : ''?>>Sergipe</option>
                                <option value="TO" <?=$user->get('end_estado') == 'TO' ? 'selected' : ''?>>Tocantins</option>
                                <option value="ES" <?=$user->get('end_estado') == 'ES' ? 'selected' : ''?>>Estrangeiro</option>
                            </select>
                        </div>

                        <div class="input_container fourth last">
                            <label for="end_cidade">Cidade*</label>
                            <input name="User-end_cidade" type="text" id="end_cidade" required="required" value="<?=$user->get('end_cidade')?>">
                        </div>
                    </div>

                    <h2>Contato de Emergência</h2>
                    <div class="input_line">
                        <div class="input_container half">
                            <label for="responsavel_nome">Nome*</label>
                            <input name="User-responsavel_nome" type="text" id="responsavel_nome" required="required" value="<?=$user->get('responsavel_nome')?>">
                        </div>

                        <div class="input_container fourth last">
                            <label for="responsavel_telefone">Telefone*</label>
                            <input name="User-responsavel_telefone" type="text" id="responsavel_telefone" required="required" class="mobile" value="<?=$user->get('responsavel_telefone')?>">
                        </div>
                    </div>

                    <h2>Informações alimentares</h2>
                    <div class="input_line">
                        <div class="input_container half">
                            <label for="tipo_alimentacao">Tipo de Alimentação</label>
                            <select id="tipo_alimentacao" name="User-tipo_alimentacao" required="required">
                                <option value="vegana" <?=$user->get('tipo_alimentacao') == 'vegana' ? 'selected' : ''?>>Vegana</option>
                                <option value="vegetariano" <?=$user->get('tipo_alimentacao') == 'vegetariano' ? 'selected' : ''?>>Vegetariana</option>
                                <option value="onivoro" <?=$user->get('tipo_alimentacao') == 'onivoro' ? 'selected' : ''?>>Onívora</option>
                            </select>
                        </div>

                        <div class="input_container fourth last">
                            <label for="restricao_alimenta">Alguma restrição alimentar?</label>
                            <input type="text" id="restricao_alimentar" name="User-restricao_alimentar" value="<?=$user->get('restricao_alimentar')?>">
                        </div>
                    </div>

                    <h2>Informações Médicas</h2>
                    <div class="input_line">
                        <div class="input_container third">
                            <label for="alergias">Alergias</label>
                            <input name="User-alergias" type="text" id="alergias" value="<?=$user->get('alergias')?>">
                        </div>

                        <div class="input_container third">
                            <label for="medicacao_continua">Medicação Contínua</label>
                            <input name="User-medicacao_continua" type="text" id="medicacao_continua" value="<?=$user->get('medicacao_continua')?>">
                        </div>

                        <div class="input_container third last">
                            <label for="plano_saude">Plano de Saúde</label>
                            <input name="User-plano_saude" type="text" id="plano_saude" value="<?=$user->get('plano_saude')?>">
                        </div>
                    </div>
                    
                    <div class="input_line submit_line right">
                      <a href="#" class="submit negative cancel">Cancelar</a>
                      <input type="submit" name="salvar" value="Salvar" class="positive">
                    </div>
                </form>
            </section>
        </main>
<?php Structure::footer(); ?>
