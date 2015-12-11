<?php
    $user = Structure::verifySession();
    Structure::header();
?>
        <main>
            <header class="center">
                <h1>Painel</h1>
            </header>
            <section class="wrapper">
                <?php include_once("custom/custom_dashboard.php"); ?>
                <?php if($user->get('role') == 'ADM') : ?>
                <?php include_once("custom/custom_dashboard_admin.php"); ?>
                <?php endif; ?>
            </section>
        </main>
<?php Structure::footer(); ?>
