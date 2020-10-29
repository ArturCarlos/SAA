<?php require_once '../../config.php'; ?>
<?php require_once DBAPI; ?>
<?php
require_once USUARIO;
viewUsuario($_GET['id']);
verificaID();
?>
<?php
require_once LOGIN2;
verificaLoginOperador();
?>
<?php include(HEADER_TEMPLATE_OPERACIONAL); ?>

<section class="content-header">
    <div class="row">
        <div class="col-sm-6 text-left">
            <ol class="breadcrumb">
                <li><a href="index.php"><i class="fa fa-home"></i>Página Inicial</a></li>
                <li><i class="fa fa-users"></i>
                    <small> Listagem de Usuários</small>
                </li>
                <li><i class="glyphicon glyphicon-eye-open"></i>
                    <small> Visualizar usuário</small>
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
                    <h3 class="text-center">Informações do usuário</h3>
                    <hr/>

                    <!--Verifica se a imagem está cadastrada-->
                    <?php if ($usuario['img'] != null) { ?>
                        <img src="<?php echo BASEURL; ?>imagens/usuario/<?php echo $usuario['img']; ?>"
                             class="img-rounded center_img img-responsive" alt="Cinque Terre"/>
                    <?php } else { ?>
                        <img src="<?php echo BASEURL; ?>dist/img/semFoto.png?>" width="500" height="400"
                             class="img-rounded center_img img-responsive" alt="Cinque Terre"/>

                    <?php } ?>

                    <dl class="dl-horizontal">
                        <dt>Nome:</dt>
                        <dd><?php echo $usuario['nome']; ?></dd>
                        <dt>Matrícula:</dt>
                        <dd><?php echo $usuario['matricula']; ?></dd>
                        <dt>E-mail:</dt>
                        <dd><?php echo $usuario['email']; ?></dd>
                        <dt>Categoria:</dt>
                        <dd><?php echo $usuario['categoria']; ?></dd>
                        <dt>Permissão:</dt>
                        <!-- Mostra a nível do usuário -->
                        <?php if ($usuario['permissao'] == 1) : ?>
                            <dd>Nível 1 - Administrador</dd>
                        <?php elseif ($usuario['permissao'] == 2) : ?>
                            <dd>Nível 2 - Operacional</dd>
                        <?php else : ?>
                            <dd>Nível 3 - Comum</dd>
                        <?php endif; ?>
                    </dl>
                    <div id="actions" class="row">
                        <div class="col-md-12">
                            <a href="edit.php?id=<?php echo $usuario['id']; ?>" class="btn btn-primary">
                                <i class="fa fa-pencil"></i> Editar</a>
                            <a href="index.php" class="btn btn-default">
                                <i class="glyphicon glyphicon-arrow-left"></i> Voltar</a>
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
                                    
                                    
                        