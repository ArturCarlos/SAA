<?php require_once '../../config.php'; ?>
<?php require_once DBAPI; ?>
<?php
    require_once LOGIN2;
    verificaLoginAdmin();
?>
<?php include(HEADER_TEMPLATE); ?>
<!-- Main conteudoCentral -->
    <section class="content">
        <img src="<?php echo BASEURL; ?>dist/img/saa.png" class="img-responsive" alt="User Image">
    </section>
<!-- /.content -->
<?php include(FOOTER_TEMPLATE); ?>