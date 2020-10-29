<?php require_once '../../config.php'; ?>
<?php require_once DBAPI; ?>
<?php
require_once LOGIN2;
verificaLoginAdmin();
?>
<?php
require_once ACHADOS_E_PERDIDOS;
viewAchados_e_Perdidos($_GET['id']);
?>
<?php
require_once SETOR;
indexSetor();
?>
<?php
require_once LOCAL;
indexLocal();
?>
<?php include(HEADER_TEMPLATE); ?>

<section class="content-header">
    <div class="row">
        <div class="col-sm-6 text-left">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASEURL; ?>index.php"><i class="fa fa-home"></i>Página Inicial</a></li>
                <li><a href="index.php"><i class="fa fa-search"></i> Listagem de Itens perdidos</a></li>
                <li><i class="glyphicon glyphicon-eye-open"></i>
                    <small> Visualizar Item perdido</small>
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
                    <h3 class="text-center">Informações do <?php echo status($item['status']) ?></h3>
                    <hr/>
                    <div class="form-group">
                        <!--Verifica se a imagem está cadastrada-->
                        <?php if ($item['img'] != null) { ?>
                            <img src="<?php echo BASEURL; ?>imagens/achados_e_perdidos/<?php echo $item['img']; ?>"
                                 class="img-rounded img-responsive center_img " alt="Cinque Terre"/>
                        <?php } else { ?>
                            <img src="<?php echo BASEURL; ?>dist/img/semFoto.png?>" width="500" height="400"
                                 class="img-rounded img-responsive center_img" alt="Cinque Terre"/>

                        <?php } ?>
                    </div>
                    <dl class="dl-horizontal">
                        <dt>Código:</dt>
                        <dd><?php echo $item['id']; ?></dd>
                        <dt>Nome:</dt>
                        <dd><?php echo $item['nome']; ?></dd>
                        <dt>Descrição:</dt>
                        <dd><?php echo $item['descricao']; ?></dd>
                        <dt>Status:</dt>
                        <!-- Mostra o status do item -->
                        <?php if ($item['status'] == 1) : ?>
                            <dd>Item perdido</dd>
                        <?php else : ?>
                            <dd>Item devolvido</dd>
                            <dt>Recebeu o item:</dt>
                            <dd><?php echo $item['nome_pessoa_entregou']; ?> -
                                Telefone: <?php echo $item['telefone']; ?></dd>
                        <?php endif; ?>

                        <dt>Setor onde o item foi encontrado:</dt>
                        <!-- Mostra o setor onde o item foi encontrado -->
                        <?php if ($setores) : ?>
                            <?php foreach ($setores as $setor) : ?>
                                <?php if ($setor['id'] == $item['id_setor']) : ?>
                                    <dd><?php echo $setor['nome']; ?>
                                        - <?php echo $nome_setor = (nome_setor_local($setor['local_id'])); ?></dd>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <dd>Setor não encontrado</dd>
                        <?php endif; ?>
                    </dl>
                    <div id="actions" class="row">
                        <div class="col-md-12">
                            <a href="edit.php?id=<?php echo $item['id']; ?>" class="btn btn-primary">
                                <i class="fa fa-pencil"></i> Editar</a>
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
                                    
                                    
                        