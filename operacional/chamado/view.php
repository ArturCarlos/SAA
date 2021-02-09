<?php require_once '../../config.php'; ?>
<?php require_once DBAPI; ?>
<?php
require_once LOGIN2;
verificaLoginOperador();
?>
<?php require_once SETOR;
?>

<?php require_once LOCAL; ?>

<?php require_once CHAMADO;
viewchamado($_GET['id']);
index_tag_chamado();
index_resp_chamado();
notificacao_lida();
?>

<?php include(HEADER_TEMPLATE_OPERACIONAL); ?>

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
                <a class="btn btn-default" href="javascript:history.back()"><i
                            class="glyphicon glyphicon-arrow-left"></i> Voltar</a>
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
                  <span class="bg-blue">
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
                            <h3 class="timeline-header">
                                <a>Título:</a> <?php echo($chamado['titulo']) ?> -
                                <strong title="Número do chamado">N°: <?php echo($chamado['id']) ?></strong>

                            </h3>
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
                                    <a href="<?php echo(anexo($chamado['anexo'], 'chamado')); ?>" target="_blank"
                                       class="btn btn-default btn-xs" download="anexo"> <b>Baixar Anexo</b></a>
                                <?php endif; ?>
                                <?php if ($chamado['status'] == 1): ?>
                                    <a href=resp_chamado.php?id=<?php echo $chamado['id']; ?>
                                       data-toggle="tooltip"
                                       data-placement="top" title="Adicionar uma resposta" class="btn bg-purple btn-xs">Responder</a>

                                    <a href=# class="btn bg-navy btn-xs" data-toggle="modal"
                                       data-target="#fechar-modal"
                                       data-customer="<?php echo $chamado['id']; ?>">
                                        Fechar </a>
                                <?php else: ?>
                                    <a href=# class="btn bg-navy btn-xs" data-toggle="modal"
                                       data-target="#abrir-modal"
                                       data-customer="<?php echo $chamado['id']; ?>">
                                        Abrir </a>
                                <?php endif; ?>

                                <a href=# class="btn btn-xs btn-danger" data-toggle="modal"
                                   data-target="#delete-modal" data-customer="<?php echo $chamado['id']; ?>">
                                    <i class="fa fa-trash"></i> Excluir </a>
                            </div>
                        </div>
                    </li>

                    <?php if ($resp_chamado):
                        foreach ($resp_chamado as $resp):?>


                            <li class="time-label">
                                <span class="bg-purple-gradient"><?php echo formata_data_hora($resp['date'], 'data'); ?></span>
                            </li>
                            <li>

                                <i class="fa fa-comments bg-purple"></i>

                                <div class="timeline-item">
                                    <span class="time"><i
                                                class="fa fa-clock-o"></i> <?php echo formata_data_hora($resp['date'], 'hora'); ?></span>


                                    <h3 class="timeline-header no-border">
                                        <a>Autor(a):</a> <?php echo(nome_usuario($resp['user_id'])); ?>
                                    </h3>
                                    <hr>
                                    <div class="timeline-body">
                                        <?php echo(nl2br($resp['resposta'])) ?>
                                    </div>
                                    <div class="timeline-footer">
                                        <?php if ($resp['anexo']): ?>
                                            <a href="<?php echo(anexo($resp['anexo'], 'resp_chamado')); ?>"
                                               target="_blank"
                                               class="btn btn-default btn-xs" download="anexo"> <b>Baixar Anexo</b></a>
                                        <?php endif; ?>
                                        <?php if ($resp['user_id'] == $_SESSION['id'] & $chamado['status'] == 1): ?>
                                            <a href="edit_resp.php?id=<?php echo $resp['id']; ?>"
                                               class="btn bg-orange btn-xs" data-toggle="tooltip"
                                               data-placement="left" title="Editar">Editar</a>

                                            <a href=# class="btn btn-xs btn-danger" data-toggle="modal"
                                               data-target="#delete-resp-modal"
                                               data-customer="<?php echo $resp['id']; ?>">
                                                <i class="fa fa-trash"></i> Excluir
                                            </a>
                                        <?php endif; ?>

                                    </div>
                                </div>

                            </li>

                        <?php endforeach;
                    endif; ?>
                    <?php if ($chamado['status'] == 1): ?>
                        <li>
                            <a href=resp_chamado.php?id=<?php echo $chamado['id']; ?> class="fa fa-clock-o bg-purple"
                               data-toggle="tooltip"
                               data-placement="top" title="Adicionar uma resposta"></a>
                        </li>
                    <?php else: ?>
                        <li>
                            <em class="fa fa-clock-o"></em>
                        </li>
                    <?php endif; ?>
                </ul>

            </div>


    </section>
<?php include('modal.php'); ?>

<?php include(FOOTER_TEMPLATE); ?>