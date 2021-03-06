<?php require_once '../../config.php'; ?>
<?php require_once DBAPI; ?>
<?php
require_once LOGIN2;
verificaLoginOperador();
?>
<?php require_once CHAMADO;
index_chamado_setor();
index_chamado_setor_origem();
index_chamado_user();
notificacao_lida();
?>
<?php include(HEADER_TEMPLATE_OPERACIONAL); ?>

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
                <a class="btn btn-info" href="historico.php"><i class="fa fa-history">
                    </i> &nbsp Histórico de Chamado </a>

                <a class="btn btn-primary" href="./add.php"><i class="fa fa-plus">
                    </i> &nbsp Criar Chamado </a>
                <a class="btn btn-default" href="index.php"><i class="fa fa-refresh"></i> Atualizar</a>
            </div>
        </div>
    </section>

    <section class="content">

        <?php include(ALERT_MSG); ?>

        <h2 class="page-header">Chamados abertos</h2>

        <div class='row'>
            <div class="col-md-6">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <i class="fa fa-th-large"></i>
                        <h3 class="box-title">Chamados enviados para o setor</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body ">
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th title="Número do Chamado">Número</th>
                                    <th title="Ordenar Tabela">Título</th>
                                    <th>Data</th>
                                    <th>Ações</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if ($chamado_setor) : ?>

                                    <?php foreach ($chamado_setor as $cham) : ?>
                                        <tr>
                                            <td><?php echo ($cham['id']); ?></td>

                                            <td><?php echo substr($cham['titulo'], 0, 30);
                                                if (strlen($cham['titulo']) > 20):?>
                                                    <a href="view.php?id=<?php echo $cham['id']; ?>">[...]</a>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo formata_data($cham['date']); ?></td>

                                            <td class="actions text-center">
                                                <a href="view.php?id=<?php echo $cham['id']; ?>"
                                                   class="btn btn-sm btn-success" data-toggle="tooltip"
                                                   data-placement="left" title="Visualizar"><i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="6">Nenhum registro encontrado.</td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                                <tfoot>
                                <tr style="background: #F4F4F4">

                                </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                    <!-- nav-tabs-custom -->
                </div>
            </div>


            <div class="col-md-6">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <i class="fa fa-user-circle"></i>

                        <h3 class="box-title">Meus Chamados</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="box-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th title="Número do Chamado">Número</th>
                                    <th title="Ordenar Tabela">Título</th>
                                    <th>Data</th>
                                    <th>Ações</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if ($chamados) : ?>

                                    <?php foreach ($chamados as $chamado) : ?>
                                        <tr>
                                            <td><?php echo ($chamado['id']); ?></td>

                                            <td><?php echo substr($chamado['titulo'], 0, 30);
                                                if (strlen($chamado['titulo']) > 20):?>
                                                    <a href="view.php?id=<?php echo $chamado['id']; ?>">[...]</a>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo formata_data($chamado['date']); ?></td>

                                            <td class="actions text-center">
                                                <a href="view.php?id=<?php echo $chamado['id']; ?>"
                                                   class="btn btn-sm btn-success" data-toggle="tooltip"
                                                   data-placement="left" title="Visualizar"><i class="fa fa-eye"></i>
                                                </a>


                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="6">Nenhum registro encontrado.</td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                                <tfoot>
                                <tr style="background: #F4F4F4">

                                </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>



        </div>
    </section>
    <!-- /.content -->

<?php include('modal.php'); ?>

<?php include(FOOTER_TEMPLATE); ?>