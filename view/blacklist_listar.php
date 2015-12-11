<?php
    $user = Structure::verifyAdminSession();
    Structure::header();
    $blacklist_dao = new BlacklistDAO;;
    $blacklist = $blacklist_dao->selectAll("Blacklist", NULL);
    if (!is_array($blacklist)) {
        $blacklist = array($blacklist);
    }
?>
    <h1>Blacklist > Listar</h1>
    <a href="<?=APP_URL?>/admin/blacklist/cadastrar">Cadastrar novo backlisted</a>
    <h2>Blacklist</h2>
    <?php if ($blacklist) : ?>
    <table>
        <thead>
            <th style="width:10%;" class="right">ID</th>
            <th style="width:70%;">E-mail</th>
            <th style="width:10%;" class="center">Editar</th>
            <th style="width:10%;" class="center">Excluir</th>
        </thead>
    <?php foreach ($blacklist as $blacklisted) { ?>
        <tr>
            <td class="right"><?=$blacklisted->get('id')?></td>
            <td><?=$blacklisted->get('user_email')?></td>
            <td class="center"><a href="<?=APP_URL?>/admin/blacklist/editar?id=<?=$blacklisted->get('id')?>">Editar</a></td>
            <td class="center"><a class="post" href="<?=APP_URL?>/admin/action/blacklist/excluir" id="<?=$blacklisted->get('id')?>">Excluir</a></td>
        </tr>
    <?php } ?>
    </table>
    <?php else : ?>
        <p>Nenhum e-mail cadastrado</p>
    <?php endif; ?>
<?php Structure::footer(); ?>
