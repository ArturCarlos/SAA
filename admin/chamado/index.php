<?php require_once '../../config.php'; ?>
<?php require_once DBAPI; ?>
<?php
require_once LOGIN2;
verificaLoginAdmin();
?>

<?php include(HEADER_TEMPLATE); ?>

    <!-- Main conteudoCentral -->

    <section class="content-header">
        <div class="row">
            <div class="col-sm-6 text-left">
                <ol class="breadcrumb">
                    <li><a href="<?php echo BASEURL; ?>index.php"><i class="fa fa-home"></i>Página Inicial</a></li>
                    <li><i class="glyphicon glyphicon-bullhorn"></i>

                        <small> Chamados</small>
                    </li>
                </ol>
            </div>
            <div class="breadcrumb text-right">
                <a class="btn btn-primary" href="./add.php"><i class="fa fa-plus">
                    </i> &nbsp Criar Chamado </a>
            </div>
        </div>
    </section>

    <section class="content">

        <?php include(ALERT_MSG); ?>

        <div class='row'>
            <div class="col-xs-12">
                <div class='box'>

                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->

<?php include('modal.php'); ?>
<?php include(FOOTER_TEMPLATE); ?>