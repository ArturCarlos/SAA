<?php require_once '../../config.php'; ?>
<?php require_once DBAPI; ?>
<?php
require_once LOGIN2;
verificaLoginAdmin();
?>
<?php require_once SETOR;
?>

<?php require_once LOCAL; ?>

<?php require_once CHAMADO;
viewchamado($_GET['id']);
?>

<?php include(HEADER_TEMPLATE); ?>

    <section class="content-header">
        <div class="row">
            <div class="col-sm-6 text-left">
                <ol class="breadcrumb">
                    <li><a href="<?php echo BASEURL; ?>index.php"><i class="fa fa-home"></i>Página Inicial</a></li>
                    <li><a href="index.php"><i class="glyphicon glyphicon-bullhorn"></i> Chamado</a></li>
                    <li><i class="fa fa-eye "></i><small> Visualizar</small></li>
                </ol>
            </div>
            <div class="breadcrumb text-right">
                <a class="btn btn-default" href="./index.php"><i class="glyphicon glyphicon-arrow-left"></i> Voltar</a>
            </div>
        </div>
    </section>

    <section class="content">

        <!-- *****Alertas de Operações*****-->
        <?php

        include(ALERT_MSG); ?>

        <div class="row">
            <div class="col-md-12 ">
                <ul class="timeline">
                    <li class="time-label">
                  <span class="bg-red">
                    <?php echo formata_data_hora($chamado['date'], 'data') ?>
                  </span>
                    </li>
                    <li>
                        <i class="glyphicon glyphicon-bullhorn bg-blue"></i>

                        <div class="timeline-item">
                            <span class="time"><i class="fa fa-clock-o"></i>
                                <?php echo formata_data_hora($chamado['date'], 'hora') ?>
                            </span>
                            <h3 class="timeline-header"><a>Título</a> <?php echo($chamado['titulo']) ?></h3>
                            <em class="timeline-footer">Autor(a) : <?php echo(nome_usuario($chamado['user_id'])) ?></em>
                            <br>
                            <div class="timeline-body">
                                <?php echo(nl2br($chamado['mensagem'])) ?>
                            </div>
                            <div class="timeline-footer">
                                <?php if ($chamado['anexo'] ): ?>
                                    <a href="view-anexo.php?id=<?php echo ($chamado['anexo'] ) ?>" target="_blank" class="btn btn-primary btn-xs">Baixar Anexo</a>
                                <?php endif; ?>

                                <a class="btn btn-warning btn-xs">Responder</a>
                                <a class="btn btn-danger btn-xs">Fechar</a>
                            </div>
                        </div>
                    </li>

                    <li>
                        <i class="fa fa-clock-o bg-gray"></i>
                    </li>
                </ul>

            </div>
            <!-- /.col -->


            <!-- /.row -->
    </section>
<?php include('modal.php'); ?>

<?php include(FOOTER_TEMPLATE); ?>