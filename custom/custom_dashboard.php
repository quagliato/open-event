<h2>Editais abertos</h2>
<?php
    $editalDAO = new editalDAO;
    $editais = $editalDAO->getOpenEdital();
    if ($editais) :
?>
    <p>Os editais são o melhor caminho para você participar ativamente na construção de um encontro único. Leia o manual com as instruções para cada edital e inscreva-se em quantos desejar. <strong>Estamos torcendo por você (:</strong></p>
    <ul id="edital_list" class="wrapper">
<?php
        if (!is_array($editais)) :
          $editais = array($editais);
        endif;
        foreach ($editais as $edital) :
?>
        <li><span class="desc fleft left"><?=$edital->get('nome')?></span> <span class="desc fright right"><a href="<?=APP_URL?>/edital?id=<?=$edital->get('id')?>">Inscreva-se!</a></span></li>
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