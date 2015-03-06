<h1 class="center">Admin</h1>
<section id="info">
    <header>
        <h2 class="clickable fade-block" data-target="#info .content">Info</h2>
    </header>
    <div class="content hidden">
        <?php
            $editalDAO = new EditalDAO;
            $editais = $editalDAO->selectAll("Edital", NULL);
            if ($editais) :
                if (!is_array($editais)) $editais = array($editais);
        ?>
        <ul id="info">
            <?php foreach ($editais as $edital) : ?>
            <li class="fourth fleft">
                <p class="title center upper thin"><?=$edital->get('nome')?></p>
                <p class="number center light"><?=$editalDAO->countAnswersPerEdital($edital->get('id'))?></p>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>
</section>

<section id="editais">
    <header>
        <h2 class="clickable fade-block" data-target="#editais .content">Editais</h2>
    </header>
    <div class="content hidden">
        <div class="menu_block third fleft">
            <a href="<?=APP_URL?>/admin/edital">Buscar editais</a>  
        </div>
    </div>
</section>

<section id="cadastros">
    <header>
        <h2 class="clickable fade-block" data-target="#cadastros .content">Cadastros</h2>
    </header>
    <div class="content hidden">
        <div class="menu_block third fleft">
            <h3>Editais</h3>
            <ul>
                <li><a href="<?=APP_URL?>/admin/edital">Cadastrar</a></li>
                <li><a href="<?=APP_URL?>/admin/edital/action/list">Listar</a></li>
                <li><a href="<?=APP_URL?>/admin/edital/buscar">Buscar</a></li>
            </ul>
        </div>

        <div class="menu_block third fleft">
            <h3><!--i class="fa fa-question"></i--> Perguntas</h3>
            <ul>
                <li><a href="<?=APP_URL?>/admin/pergunta">Cadastrar</a></li>
                <li><a href="<?=APP_URL?>/admin/pergunta/action/list">Listar</a></li>
                <li><a href="<?=APP_URL?>/admin/pergunta/buscar">Buscar</a></li>
            </ul>
        </div>

        <div class="menu_block third fleft">
            <h3><!--i class="fa fa-list-ol"></i-->Valores Possíveis</h3>
            <ul>
                <li><a href="<?=APP_URL?>/admin/valor-possivel">Cadastrar</a></li>
                <li><a href="<?=APP_URL?>/admin/valor-possivel/action/list">Listar</a></li>
                <li><a href="<?=APP_URL?>/admin/valor-possivel/buscar">Buscar</a></li>
            </ul>
        </div>
    </div>
</section>
