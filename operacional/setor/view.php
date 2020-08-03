<?php require_once '../../config.php'; ?>
<?php require_once DBAPI; ?>
<?php
    require_once LOGIN2;
    verificaLoginOperador();
?>
<?php
    require_once SETOR;
    viewSetor($_GET['id']);
    index_user_setor();

?>

<?php
    require_once LOCAL;
    indexLocal();
?>

<?php
    require_once USUARIO;
    index();
?>
<?php include(HEADER_TEMPLATE_OPERACIONAL); ?>

<section class="content-header">		
    <div class="row">			
        <div class="col-sm-6 text-left">				
            <ol class="breadcrumb">
                <li><a href="<?php echo BASEURL; ?>index.php"><i class="fa fa-home"></i>Página Inicial</a></li>
                <li><a href="index.php"><i class="fa fa-cubes"></i> Listagem de Setores</a></li>
                <li><i class="glyphicon glyphicon-eye-open"></i>
                    <small> Visualizar Setor</small>
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
                    <h3 class="text-center">Informações do setor</h3>
                        <hr />

                    <!--Verifica se a imagem está cadastrada-->
                    <?php if ($setor['img'] != null) { ?>
                        <img src="<?php echo BASEURL; ?>imagens/setor/<?php echo $setor['img']; ?>"
                             class="img-rounded center_img view_img" alt="Cinque Terre"/>
                    <?php } else { ?>
                        <img src="<?php echo BASEURL; ?>dist/img/semFoto.png?>" width="500" height="400"
                             class="img-rounded center_img" alt="Cinque Terre"/>

                    <?php } ?>

                    <dl class="dl-horizontal">
                            <dt>Nome:</dt>		
                            <dd><?php echo $setor['nome']; ?></dd>
                            <dt>Número:</dt>		
                            <dd><?php echo $setor['numero']; ?></dd>	
                            <dt>usuário responsável:</dt>

                        <!-- Mostra o usuário responsável do setor -->
                        <?php if ($user_setor) : ?>
                            <?php foreach ($user_setor as $usuario) : ?>
                                <?php if ($usuario['setor_id'] == $setor['id']) : ?>
                                    <dd>
                                    <?php echo nome_usuario_setor($usuario['user_id']). ", ";?>
                                    </dd>
                               <?php  endif; ?>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <td>Usuário não encontrado</td>
                        <?php endif; ?>

                            <dt>Localização:</dt>
                            <!-- Mostra o local do setor -->
                            <?php if ($locais) : ?>	
                                <?php foreach ($locais as $local) : ?>
                                    <?php if ($local['id'] == $setor['local_id']) : ?>	
                                        <dd><?php echo $local['nome']; ?></dd>
                                    <?php endif; ?>                            
                                <?php endforeach; ?>	
                            <?php else : ?>				
                                <dd>Local não encontrado</dd>		
                            <?php endif; ?>	
                        </dl>	
                        <div id="actions" class="row">		
                            <div class="col-md-12">
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
                                    
                                    
                        