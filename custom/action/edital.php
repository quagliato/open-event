<?php
    $usuario = Structure::verifySession();
    $genericDAO = new GenericDAO;
    $return = array();

    $perguntaDAO = new PerguntaDAO;
    $valorPossivelDAO = new ValorPossivelDAO;

    $respostas = array();

    $editalId = $_POST['edital'];
    $dtInicioResposta = $_POST['dt_inicio_resposta'];

    foreach ($_POST as $key => $value) {
        $pergunta = $perguntaDAO->getPerguntaById(intval($key));

        if ($pergunta) :
            if (is_array($value)) :
                foreach ($value as $realValue) :
                    $respostaPergunta = new RespostaPergunta();
                    $respostaPergunta->set("id_pergunta", $pergunta->get('id'));

                    if ($valorPossivelDAO->getValorPossivelByPergunta($pergunta->get('id'))) {
                        $valorPossivel = $valorPossivelDAO->getValorPossivel($realValue);
                        if ($valorPossivel) :
                            $respostaPergunta->set("vl_resposta", $valorPossivel->get("label"));
                        else :
                            $respostaPergunta->set("vl_resposta", $realValue);
                        endif;
                    }

                    $respostas[] = $respostaPergunta;
                endforeach;
            else :
                $respostaPergunta = new RespostaPergunta();
                $respostaPergunta->set("id_pergunta", $pergunta->get('id'));

                if ($pergunta->get('tipo_resposta') == "number") {
                    $respostaPergunta->set("vl_resposta", intval($value));

                } elseif ($pergunta->get('tipo_resposta') == "datepicker") {
                    $respostaPergunta->set("vl_resposta", Utils::brFormat2SQLDate($value));

                } elseif ($pergunta->get('tipo_resposta') == "datetimepicker") {
                    $respostaPergunta->set("vl_resposta", Utils::brFormat2SQLTimestamp($value));

                } elseif (in_array($pergunta->get('tipo_resposta'), array("select", "checkbox", "slider"))) {

                    if ($valorPossivelDAO->getValorPossivelByPergunta($pergunta->get('id'))) {
                        $valorPossivel = $valorPossivelDAO->getValorPossivel(intval($value));

                        if ($valorPossivel) :
                            $respostaPergunta->set("vl_resposta", $valorPossivel->get("label"));
                        else :
                            $respostaPergunta->set("vl_resposta", $value);
                        endif;
                    }

                } else {
                    $respostaPergunta->set("vl_resposta", $value);
                }

                $respostas[] = $respostaPergunta;
            endif;
        endif;
    }

    $now = date("Y-m-d H:i:s");

    $respostaEdital = new RespostaEdital;
    $respostaEdital->set("id_edital", $editalId);
    $respostaEdital->set("id_user", $usuario->get('id'));
    $respostaEdital->set("dt_inicio_resposta", $dtInicioResposta);
    $respostaEdital->set("dt_fim_resposta", $now);

    if ($genericDAO->insert($respostaEdital)) {
        $inserted = $genericDAO->selectAll(
            "RespostaEdital", 
            "id_edital = $editalId AND ".
            "id_user = ".$usuario->get('id')." AND ".
            "dt_inicio_resposta = '$dtInicioResposta' AND ".
            "dt_fim_resposta = '$now'");

        if ($inserted) {
            if (is_array($inserted)) { // TODO: Add unique constraints on DB and remove this
                $inserted = $inserted[0];
            }
            $problem = false;
            foreach ($respostas as $respostaPergunta) {
                $respostaPergunta->set("id_resposta_edital", $inserted->get('id'));

                if (!$genericDAO->insert($respostaPergunta)) {
                    $return[] = array(
                        "Action" => "Error",
                        "Error" => "Problemas ocorreram ao cadastrar seu edital. Tente novamente em alguns minutos ou entre em contato com problemas@nsp2015.com.br."
                    );
                    $problem = true;
                }
            }
            if (!$problem) {
                $return[] = array(
                    "Action" => "Message",
                    "Message" => "Edital cadastrado com sucesso!"
                );

                $return[] = array(
                    "Action" => "Redir",
                    "Redir" => "/edital/confirmacao?id=".$editalId
                );
            }
        } else {
            $return[] = array(
            "Action" => "Error",
            "Error" => "Problemas ocorreram ao cadastrar seu edital. Tente novamente em alguns minutos ou entre em contato com problemas@nsp2015.com.br."
        );
        }
    } else {
        $return[] = array(
            "Action" => "Error",
            "Error" => "Problemas ocorreram ao cadastrar seu edital. Tente novamente em alguns minutos ou entre em contato com problemas@nsp2015.com.br."
        );
    }

    echo json_encode($return);
?>
