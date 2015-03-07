<?php
    $usuario = Structure::verifySession();
    Structure::header();

    $genericDAO = new GenericDAO;

    $where = "";

    if (array_key_exists('email', $_GET) && 
        !is_null($_GET['email']) && 
        $_GET['email'] != '') {
        $usuario = $genericDAO->selectAll("Usuario", "email = '".$_GET['email']."'");
        if ($usuario) {
            if (is_array($usuario)) {
                $usuario = $usuario[0];
            }
            $where .= "id_user = ".$usuario->get('id');
        }
    }

    if (array_key_exists('id_user', $_GET) && 
        !is_null($_GET['id_user']) && 
        $_GET['id_user'] != '') {
        if (strlen($where) > 0) {
            $where .= " AND ";
        }
        $where .= "id_user = ".$_GET['id_user'];
    }

    if (array_key_exists('edital', $_GET) && 
        !is_null($_GET['edital']) && 
        $_GET['edital'] != '') {
        if (strlen($where) > 0) {
            $where .= " AND ";
        }
        $where .= "id_edital = ".$_GET['edital'];
    }

    if (array_key_exists('status', $_GET) && 
        !is_null($_GET['status']) && 
        $_GET['status'] != '') {
        if (strlen($where) > 0) {
            $where .= " AND ";
        }
        $where .= "status = ".$_GET['status'];
    }

    $respostasEdital = $genericDAO->selectAll("RespostaEdital", $where);
?>
        <main>
            <header class="center">
                <h1>Respostas de Editais</h1>
            </header>
            <section class="wrapper">
            <?php
                if ($respostasEdital) :
                    if (!is_array($respostasEdital)) :
                        $respostasEdital = array($respostasEdital);
                    endif;
            ?>
                <div class="input_line submit_line right">
                    <a href="#" class="submit negative cancel">Voltar</a>
                </div>
                <table style="font-size:12px;" class="jquerydatatable">
                    <thead>
                        <td class="center" style="width:5%;">ID</td>
                        <td class="left" style="width:30%;">Edital</td>
                        <td class="left" style="width:30%;">Usuário</td>
                        <td class="left" style="width:15%;">Status</td>
                        <td class="center" style="width:20%;" colspan="5"></td>
                    </thead>
                    <?php
                        $count = 0;
                        foreach ($respostasEdital as $respostaEdital) :
                            $edital = $genericDAO->selectAll('Edital', 'id = '.$respostaEdital->get('id_edital'));
                            $usuario = $genericDAO->selectAll('Usuario', 'id = '.$respostaEdital->get('id_user'));
                    ?>
                        <tr <?php if ($count % 2 == 0) { echo 'style="background-color: #CCCCCC;"'; } ?>>
                            <td class="center"><?=$respostaEdital->get('id')?></td>
                            <td class="left"><?=$edital->get('nome')?></td>
                            <td class="left"><?=$usuario->get('nome')?></td>
                            <td class="left"><?=RespostaEditalStatus::getTextStatus($respostaEdital->get('status'))?></td>
                            <td class="center"><a class="btn black" target="_blank" href="<?=APP_URL?>/edital?idRespostaEdital=<?=$respostaEdital->get('id')?>"><i class="fa fa-eye"></a></td>
                            <td class="center"><a class="btn black lightbox-open" href="<?=APP_URL?>/admin/resposta-edital/action/status?idRespostaEdital=<?=$respostaEdital->get('id')?>"><i class="fa fa-history"></a></td>
                            <td class="center">
                                <?php if ($respostaEdital->get('status') == 1) : ?>
                                <a class="btn light_gray"><i class="fa fa-check-circle-o"></i></a>
                                <?php else : ?>
                                <a class="post btn dark_green" id="<?=$respostaEdital->get('id')?>" href="<?=APP_URL?>/admin/resposta-edital/action/approve"><i class="fa fa-check-circle-o"></i></a>
                                <?php endif; ?>
                            </td>
                            <td class="center">
                                <?php if ($respostaEdital->get('status') == 3 || $respostaEdital->get('status') == 1) : ?>
                                <a class="btn light_gray"><i class="fa fa-dot-circle-o"></i></a>
                                <?php else : ?>
                                <a class="post btn black" id="<?=$respostaEdital->get('id')?>" href="<?=APP_URL?>/admin/resposta-edital/action/pre-select"><i class="fa fa-dot-circle-o"></a>
                                <?php endif; ?>
                            </td>
                            <td class="center">
                                <?php if ($respostaEdital->get('status') == 2) : ?>
                                <a class="btn light_gray"><i class="fa fa-times-circle-o"></i></a>
                                <?php else : ?>
                                <a class="post btn dark_red" id="<?=$respostaEdital->get('id')?>" href="<?=APP_URL?>/admin/resposta-edital/action/deny"><i class="fa fa-times-circle-o"></i></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php 
                            $count++; 
                        endforeach;
                    ?>
                </table>
            <?php else: ?>
                <h2 class="center">Nenhum registro encontrado</h2>
            <?php endif; ?>
            </section>
        </main>

<?php Structure::footer(); ?>