<?php require_once '../../config.php'; ?>
<?php require_once DBAPI; ?>
<?php
require_once LOGIN2;
verificaLoginAdmin();
?>

<?php
require_once SETOR;
indexSetor();
index_user_setor(); ?>

<?php
require_once LOCAL;
indexLocal();
?>

<?php
require_once USUARIO;
index();
?>
<?php include(HEADER_TEMPLATE); ?>

    <section class="content-header">
        <div class="row">
            <div class="col-sm-6 text-left">
                <ol class="breadcrumb">
                    <li><a href="<?php echo BASEURL; ?>index.php"><i class="fa fa-home"></i>Página Inicial</a></li>
                    <li><i class="fa fa-cubes"></i>
                        <small> Listagem de Setores</small>
                    </li>
                </ol>
            </div>
            <div class="breadcrumb text-right">
                <a class="btn btn-primary" href="add.php">
                    <i class="fa fa-plus">
                    </i> Novo Setor</a>
                <a class="btn btn-default" href="index.php"><i class="fa fa-refresh"></i> Atualizar</a>
            </div>
        </div>
    </section>

    <section class="content">

        <!-- *****Alertas de Operações*****-->
        <?php include(ALERT_MSG); ?>

        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header text-center">
                        <h3>Listagem de setores do sitema</h3>
                        <hr/>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="tab_setor" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th title="Ordenar Tabela">Nome</th>
                                <th title="Ordenar Tabela">Número</th>
                                <th title="Ordenar Tabela">Local pertencente</th>
                                <th style="width:400px"title="Ordenar Tabela">Usuário responsável</th>
                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if ($setores) :?>

                                <?php foreach ($setores as $setor) : ?>
                                    <tr>
                                        <td><?php echo $setor['nome']; ?></td>
                                        <td><?php echo $setor['numero']; ?></td>
                                        <!-- Mostra o local responsável do setor -->
                                        <?php if ($locais) : ?>
                                            <?php foreach ($locais as $local) : ?>
                                                <?php if ($local['id'] == $setor['local_id']) : ?>
                                                    <td><?php echo $local['nome']; ?></td>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <td>Local não encontrado</td>
                                        <?php endif; ?>


                                        <!-- Mostra o usuário responsável do setor -->
                                        <?php if ($user_setor) : ?>
                                            <td>
                                                <?php foreach ($user_setor as $usuario) :?>

                                                    <?php if ($usuario['setor_id'] == $setor['id']) :
                                                        echo nome_usuario_setor($usuario['user_id']).", ";
                                                        ?>

                                                    <?php endif; ?>
                                                <?php endforeach; ?>                                                        </td>

                                        <?php else : ?>
                                            <td>Usuário não encontrado</td>
                                        <?php endif; ?>


                                        <td class="actions text-center">
                                            <a href="view.php?id=<?php echo $setor['id']; ?>"
                                               class="btn btn-sm btn-success"><i class="fa fa-eye"></i> Visualizar</a>
                                            <a href="edit.php?id=<?php echo $setor['id']; ?>"
                                               class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i> Editar</a>
                                            <a href=# class="btn btn-sm btn-danger" data-toggle="modal"
                                               data-target="#delete-modal" data-customer="<?php echo $setor['id']; ?>">
                                                <i class="fa fa-trash"></i> Excluir </a>
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
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>

<?php include('modal.php'); ?>
<?php include(FOOTER_TEMPLATE); ?>