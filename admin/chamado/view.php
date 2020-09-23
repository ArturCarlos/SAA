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
index_tag_chamado();
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
                        <a class="btn" href="./tag_chamado.php?id=<?php echo $chamado['id'] ?>" data-placement="left"
                           title="Adicionar/Remover Tags">
                            <?php if ($tags_chamado):
                                foreach ($tags_chamado as $tag_chamado):?>
                                    <i class="fa fa-tag"></i>
                                    <?php echo nome_tag($tag_chamado['tag_id']) . "&nbsp";
                                endforeach;
                            else: ?>

                            <i class="fa fa-tags"></i>Tags:</a>
                        <?php
                        endif;
                        ?>
                        </a>
                    </li>
                    <li>
                        <i class="glyphicon glyphicon-bullhorn bg-blue"></i>

                        <div class="timeline-item">
                            <span class="time"><i class="fa fa-clock-o"></i>
                                <?php echo formata_data_hora($chamado['date'], 'hora') ?>
                            </span>
                            <h3 class="timeline-header"><a>Título</a> <?php echo($chamado['titulo']) ?></h3>
                            <span class="time">
                                <em class="timeline-footer">
                                    De: <?php echo(nome_setor($chamado['setor_origem'])) ?>
                                </em>
                                <br>
                                <em class="timeline-footer">
                                    Para: <?php echo(nome_setor($chamado['setor_destino'])) ?>
                                </em>
                            </span>
                            <br>
                            <em class="timeline-footer">Autor(a) : <?php echo(nome_usuario($chamado['user_id'])) ?></em>
                            <hr>
                            <div class="timeline-body">
                                <?php echo(nl2br($chamado['mensagem'])) ?>
                            </div>
                            <div class="timeline-footer">
                                <?php if ($chamado['anexo']): ?>
                                    <a href="<?php echo(anexo($chamado['anexo'])); ?>" target="_blank"
                                       class="btn btn-default btn-xs" download="anexo"> <b>Baixar Anexo</b></a>
                                <?php endif; ?>

                                <a href=resp_chamado.php?id=<?php echo $chamado['id']; ?>
                                   class="btn btn-warning btn-xs">Responder</a>
                                <a href=# class="btn btn-danger btn-xs" data-toggle="modal"
                                   data-target="#fechar-modal"
                                   data-customer="<?php echo $chamado['id']; ?>">
                                    Fechar </a>
                            </div>
                        </div>
                    </li>

                    <li class="time-label">
                  <span class="bg-green">
                    3 Jan. 2014
                  </span>
                    </li>
                    <li>
                        <i class="fa fa-comments bg-yellow"></i>

                        <div class="timeline-item">
                            <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>

                            <h3 class="timeline-header no-border"><a href="#">Autor(a):</a> accepted your friend
                                request</h3>
                        </div>
                    </li>

                    <li>
                        <i class="fa fa-clock-o bg-gray"></i>
                    </li>
                </ul>

            </div>
    </section>
<?php include('modal.php'); ?>

<?php include(FOOTER_TEMPLATE); ?>