<h2>Editais abertos</h2>
<?php
    $editalDAO = new editalDAO;
    $respostaEditalDAO = new RespostaEditalDAO;
    $editais = $editalDAO->getOpenEdital();
    if ($editais) :
?>
    <p class="light">Os editais são o melhor caminho para você participar ativamente na construção de um encontro único. Leia o manual com as instruções para cada edital e inscreva-se em quantos desejar. <strong>Estamos torcendo por você (:</strong></p>
    <ul id="edital_list" class="wrapper">
<?php
        if (!is_array($editais)) :
          $editais = array($editais);
        endif;
        foreach ($editais as $edital) :
            $hasAnsweredEdital = $respostaEditalDAO->hasAnsweredEdital($usuario->get('id'), $edital->get('id'));
?>
        <li>
            <span class="fleft left upper"><?=$edital->get('nome')?>
                <?php if ($hasAnsweredEdital) : ?>
                <span class="no-transform note">
                    Você respondeu esse edital há <?=Utils::getRelativeDate(new DateTime($hasAnsweredEdital->get('dt_fim_resposta')))?>.
                </span>
                <?php endif; ?>
            </span>
            <span class="fright right">
                <a href="<?=APP_URL?>/edital?id=<?=$edital->get('id')?>">Inscrição</a>
            </span>
        </li>
<?php
        endforeach;
?>
    </ul>
<?php
    else:
?>
    <h3>Nenhum edital aberto.</h3>
<?php
    endif;
?>