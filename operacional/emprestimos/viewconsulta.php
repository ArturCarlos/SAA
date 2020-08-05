<?php require_once '../../config.php'; ?>
<?php require_once DBAPI; ?>
<?php require_once LOGIN2;
verificaLoginOperador();
?>
<?php
require_once PATRIMONIO;
viewPatrimonio($_GET['id']);
?>
<?php
require_once SETOR;
indexSetor();
?>
<?php require_once LOCAL;
indexLocal();
?>

<?php include(HEADER_TEMPLATE_OPERACIONAL); ?>

<section class="content-header">
    <div class="row">
        <div class="col-sm-6 text-left">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASEURL; ?>index.php"><i class="fa fa-home"></i>Página Inicial</a></li>
                <li><a href="consulta.php"><i class="glyphicon glyphicon-search"></i>
                        <small> Consultar itens emprestáveis</small></a>
                </li>
                <li><i class="glyphicon glyphicon-eye-open"></i>
                    <small> Visualizar Item</small>
                </li>

            </ol>
        </div>
        <div class="breadcrumb text-right">
            <a class="btn btn-default" href="consulta.php"><i class="glyphicon glyphicon-arrow-left"></i> Voltar</a>
        </div>
    </div>
</section>


<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <!-- /.box-header -->
                <div class="box-body">
                    <h3 class="text-center">Informações do patrimônio</h3>
                    <hr/>
                    <div class="form-group">
                        <!--Verifica se a imagem está cadastrada-->
                        <?php if ($patrimonio['img'] != null) { ?>
                            <img src="<?php echo BASEURL; ?>imagens/patrimonio/<?php echo $patrimonio['img']; ?>"
                                 class="img-rounded center_img view_img" alt="Cinque Terre"/>
                        <?php } else { ?>
                            <img src="<?php echo BASEURL; ?>dist/img/semFoto.png?>" width="500" height="400"
                                 class="img-rounded center_img" alt="Cinque Terre"/>

                        <?php } ?>
                    </div>


                    <dl class="dl-horizontal">
                        <dt>Nome:</dt>
                        <dd><?php echo $patrimonio['nome']; ?></dd>
                        <dt>Especificação:</dt>
                        <dd><?php echo $patrimonio['especificacao']; ?></dd>
                        <dt>Tombo:</dt>
                        <dd><?php echo $patrimonio['tombo']; ?></dd>
                        <dt>Status:</dt>

                        <!-- Mostra se o patrimônio é emprestável -->
                        <?php if ($patrimonio['status'] == 'indisponivel') : ?>
                            <dd>Indisponível para empréstimo</dd>
                        <?php else : ?>
                            <dd>Disponivel para empréstimo</dd>
                        <?php endif; ?>
                        <dt>Setor responsável:</dt>
                        <!-- Mostra o setor responsável do patrimônio -->
                        <?php if ($setores) : ?>
                            <?php foreach ($setores as $setor) : ?>
                                <?php if ($setor['id'] == $patrimonio['setor_id']) : ?>
                                    <dd><?php echo $setor['nome']; ?></dd>
                                <?php endif; ?>
                            <?php endforeach; ?>

                        <?php endif; ?>

                        <dt>Local:</dt>

                        <!-- Mostra o local responsável do patrimônio -->
                        <?php if ($locais) : ?>
                            <?php foreach ($locais as $local) : ?>
                                <?php if ($local['id'] == $setor['local_id']) : ?>
                                    <dd><?php echo $local['nome']; ?></dd>
                                <?php endif; ?>
                            <?php endforeach; ?>

                        <?php endif; ?>

                    </dl>
                    <div id="actions" class="row">
                        <div class="col-md-12">

                            <a href="javascript:history.back()" class="btn btn-default">
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


