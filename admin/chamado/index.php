<?php require_once '../../config.php'; ?>
<?php require_once DBAPI; ?>
<?php
require_once LOGIN2;
verificaLoginAdmin();
?>
<?php require_once CHAMADO;
index_chamado_setor();
index_chamado_user();
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
        <h2 class="page-header">Chamados abertos</h2>

        <div class='row'>
            <div class="col-md-6">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <i class="fa fa-th-large"></i>
                        <h3 class="box-title">Chamados do setor</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th title="Ordenar Tabela">Título</th>

<!--                                    <th>Ações</th>
-->                                </tr>
                                </thead>
                                <tbody>
                                <?php if ($chamado_setor) : ?>


                                    <?php foreach ($chamado_setor as $cham) : ?>
                                        <tr>
                                            <td><?php echo $cham['titulo']; ?></td>

                                           <!-- <td class="actions text-center">

                                                <a href=# class="btn btn-sm btn-danger" data-toggle="modal"
                                                   data-target="#delete-modal"
                                                   data-customer="<?php /*echo '&id=' . $cham['id']; */?>">
                                                    <i class="fa fa-trash"></i> Excluir </a>
                                            </td>-->
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
                <div class="box box-default">
                    <div class="box-header with-border">
                        <i class="fa fa-user-circle"></i>

                        <h3 class="box-title">Meus Chamados</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="box-body">
                            <table id="tab_setor" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th title="Ordenar Tabela">Título</th>

<!--                                    <th>Ações</th>
-->                                </tr>
                                </thead>
                                <tbody>
                                <?php if ($chamados) : ?>

                                    <?php foreach ($chamados as $chamado) : ?>
                                        <tr>
                                            <td><?php echo $chamado['titulo']; ?></td>

                                           <!-- <td class="actions text-center">

                                               <a href=# class="btn btn-sm btn-danger" data-toggle="modal"
                                                   data-target="#delete-modal"
                                                   data-customer="<?php /*echo '&id=' . $chamado['id']; */?>">
                                                    <i class="fa fa-trash"></i> Excluir </a>
                                            </td>-->
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