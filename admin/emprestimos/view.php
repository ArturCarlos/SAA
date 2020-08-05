<?php require_once '../../config.php'; ?>
<?php require_once DBAPI; ?>
<?php
require_once LOGIN2;
verificaLoginAdmin();
?>

<?php
require_once EMPRESTIMOS;
view_emprestimos($_GET['id']);

?>
<?php
require_once PATRIMONIO;
indexPatrimonio();
?>
<?php
require_once USUARIO;
?>
<?php include(HEADER_TEMPLATE); ?>

<section class="content-header">
    <div class="row">
        <div class="col-sm-6 text-left">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASEURL; ?>index.php"><i class="fa fa-home"></i>Página Inicial</a></li>
                <li><a href="index.php"><i class="glyphicon glyphicon-list-alt"></i> Listagem de Itens Emprestados</a>
                </li>
                <li><i class="glyphicon glyphicon-eye-open"></i>
                    <small> Visualizar Item Emprestado</small>
                </li>

            </ol>
        </div>
        <div class="breadcrumb text-right">
            <a class="btn btn-default" href="index.php"><i class="glyphicon glyphicon-arrow-left"></i> Voltar</a>
        </div>
    </div>
</section>


<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <!-- /.box-header -->
                <div class="box-body">
                    <h3 class="text-center">Informações do item emprestado</h3>
                    <hr/>
                    <?php if ($patrimonios) : ?>
                        <?php foreach ($patrimonios as $patrimonio) : ?>
                            <?php if ($patrimonio['id'] == $item_emprestimos['patrimonio_id']) : ?>
                                <div class="form-group">
                                    <!--Verifica se a imagem está cadastrada-->
                                    <?php if ($patrimonio['img'] != null) { ?>
                                        <img src="<?php echo BASEURL; ?>imagens/patrimonio/<?php echo $patrimonio['img']; ?>"
                                             class="img-rounded center_img view_img" alt="Cinque Terre"/>
                                    <?php } else { ?>
                                        <img src="<?php echo BASEURL; ?>dist/img/semFoto.png?>"
                                             class="img-rounded center_img view_img" alt="Cinque Terre"/>
                                    <?php } ?>
                                </div>
                                <dl class="dl-horizontal">
                                    <dt>Nome:</dt>
                                    <dd><?php echo $patrimonio['nome']; ?></dd>
                                    <dt>Tombo:</dt>
                                    <dd><?php echo $patrimonio['tombo']; ?></dd>
                                    <?php if ($item_emprestimos['status'] == 'emprestado') { ?>
                                        <dt>Status de empréstimo:</dt>
                                        <dd><?php echo $item_emprestimos['status']; ?></dd>
                                        <dt>Data do empréstimo:</dt>
                                        <dd><?php echo date('d/m/Y', strtotime($item_emprestimos['data_emprestimo'])); ?></dd>
                                        <dt>Prazo de devolução:</dt>
                                        <dd><?php echo date('d/m/Y', strtotime($item_emprestimos['data_prazo_devolucao'])); ?></dd>
                                        <dt>Emprestado por:</dt>
                                        <dd><?php echo index_nome_user($item_emprestimos['user_realizou']); ?></dd>
                                        <dt>Emprestado para:</dt>
                                        <dd><?php echo index_nome_user($item_emprestimos['user_solicitou']); ?></dd>
                                    <?php } else { ?>
                                        <dt>Status de empréstimo:</dt>
                                        <dd><?php echo $item_emprestimos['status']; ?></dd>
                                        <dt>Data do empréstimo:</dt>
                                        <dd><?php echo date('d/m/Y', strtotime($item_emprestimos['data_emprestimo'])); ?></dd>
                                        <dt>Prazo de devolução:</dt>
                                        <dd><?php echo date('d/m/Y', strtotime($item_emprestimos['data_prazo_devolucao'])); ?></dd>
                                        <dt>Data de devolução:</dt>
                                        <dd><?php echo date('d/m/Y', strtotime($item_emprestimos['data_devolucao'])); ?></dd>
                                        <dt>Emprestado por:</dt>
                                        <dd><?php echo index_nome_user($item_emprestimos['user_realizou']); ?></dd>
                                        <dt>Emprestado para:</dt>
                                        <dd><?php echo index_nome_user($item_emprestimos['user_solicitou']); ?></dd>
                                        <dt>Entregado por:</dt>
                                        <dd><?php echo index_nome_user($item_emprestimos['user_entregou']); ?></dd>
                                        <dt>Entregado para:</dt>
                                        <dd><?php echo index_nome_user($item_emprestimos['user_recebeu']); ?></dd>
                                    <?php } ?>
                                </dl>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <div id="actions" class="row">
                        <div class="col-md-12">
                            <!-- Envia o id para funcao PDF-->

                            <form target="_blank" action="../../model/emprestimos/pdf.php?id=<?php echo $item_emprestimos['id']; ?>"
                                  method="post">

                                <?php if ($item_emprestimos['status'] == 'emprestado') { ?>
                                    <a href="devolucao.php?id=<?php echo $item_emprestimos['id']; ?>"
                                       class="btn btn-primary">
                                        <i class="fa fa-repeat"></i> Devolver item</a>

                                <?php } ?>

                                <button type="submit" class="btn btn-info"><i class="fa fa-file-pdf-o"></i> Termo de empréstimo</button>

                                <a href="index.php" class="btn btn-default">
                                    <i class="glyphicon glyphicon-arrow-left"></i> Voltar</a>
                            </form>
                        </div>
                    </div>
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

<?php include(FOOTER_TEMPLATE); ?>
                                    
                                    
                        