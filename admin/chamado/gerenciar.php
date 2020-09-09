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
                    <li><i class="fa fa-gears "></i>

                        <small> Gerenciar</small>
                    </li>
                </ol>
            </div>

        </div>
    </section>

    <section class="content">

        <!-- *****Alertas de Operações*****-->
        <?php include(ALERT_MSG); ?>


        <div class='row'>

            <div class="col-xs-12">
                <div class='box'>

                    <div class="box-header text-center">
                        <h3>Gerenciamento do chamado</h3>
                        <hr/>

                        <div class="box-body col-xs-6">
                            <a class="btn-lg btn-primary btn-block" href="./acesso.php"><i class="fa fa-th-large">
                                </i> &nbsp Gerenciar acesso ao chamado </a>
                        </div>

                        <div class="box-body col-xs-6">
                            <a class="btn-lg btn-primary btn-block" href="tag.php"><i class="fa fa-tags">
                                </i> &nbsp Gerenciar Tags de classificação </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->

<?php include('modal.php'); ?>
<?php include(FOOTER_TEMPLATE); ?>