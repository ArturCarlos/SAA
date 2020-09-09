<?php require_once '../../config.php'; ?>
<?php require_once DBAPI; ?>

<?php
require_once CHAMADO;

add_tag();

indextag();

?>
<?php include(HEADER_TEMPLATE); ?>

<!-- Main conteudoCentral -->

<section class="content-header">
    <div class="row">
        <div class="col-sm-12 text-left">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASEURL; ?>index.php"><i class="fa fa-home"></i>Página Inicial</a></li>
                <li><a href="<?php echo BASEURL; ?>admin/chamado/gerenciar.php"><i
                                class="fa fa-gears"></i>Gerenciar</a></li>
                <li><i class="fa fa-tags"></i>

                    <small>Tags</small>
                </li>
            </ol>
        </div>

    </div>
</section>

<section class="content">

    <!-- *****Alertas de Operações*****-->
    <?php include(ALERT_MSG); ?>

    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-header text-center">
                    <h3>Listagem de Tags</h3>
                    <hr/>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="box-body">

                        <table id="tab_setor" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th title="Ordenar Tabela">Nome</th>

                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if ($tags) : ?>

                                <?php foreach ($tags as $tag) : ?>
                                    <tr>
                                        <td><?php echo $tag['nome']; ?></td>

                                        <td class="actions text-center">

                                            <a href=# class="btn btn-sm btn-danger" data-toggle="modal"
                                               data-target="#delete-modal" data-customer="<?php echo '&id-tag='.$tag['id']; ?>">
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

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-6">


            <div class="box">
                <div class="box-body">
                    <form action=tag.php method="post">
                        <h3 class="text-center">Adicionar Tag</h3>
                        <hr/>
                        <div class="form-group">
                            <label for="nome">Nome </label>
                            <input type="text" class="form-control" id="nome"
                                   placeholder="Nome do setor"
                                   name="tag['nome']" required="">
                        </div>

                        <div id="actions" class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-check"></i> Adicionar
                                </button>

                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>


    </div>
    <!-- /.row -->
</section>
<!-- /.content -->

<?php include('modal.php'); ?>
<?php include(FOOTER_TEMPLATE); ?>

