<?php require_once '../../config.php'; ?>
<?php require_once DBAPI; ?>
<?php
    require_once LOGIN2;
    verificaLoginOperador();
?>
<?php
    require_once LOCAL;
    viewLocal($_GET['id']);
?>
<?php include(HEADER_TEMPLATE_OPERACIONAL); ?>

<section class="content-header">		
    <div class="row">			
        <div class="col-sm-6 text-left">				
            <ol class="breadcrumb">
                <li><a href="<?php echo BASEURL; ?>index.php"><i class="fa fa-home"></i>Página Inicial</a></li>
                <li><a href="index.php"><i class="fa fa-cube"></i> Listagem de Localidades</a></li>
                <li><i class="glyphicon glyphicon-eye-open"></i>
                    <small> Visualizar Local</small>
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
                    <h3 class="text-center">Informações do local</h3>
                    <hr/>

                    <!--Verifica se a imagem está cadastrada-->
                    <?php if ($local['img'] != null) { ?>
                        <img src="<?php echo BASEURL; ?>imagens/locais/<?php echo $local['img']; ?>"
                             class="img-rounded center_img img-responsive" alt="Cinque Terre"/>
                    <?php } else { ?>
                        <img src="<?php echo BASEURL; ?>dist/img/semFoto.png?>" width="500" height="400"
                             class="img-rounded center_img img-responsive" alt="Cinque Terre"/>

                    <?php } ?>

                        <dl class="dl-horizontal">		
                            <dt>Nome:</dt>		
                            <dd><?php echo $local['nome']; ?></dd>	
                            <dt>Rua:</dt>		
                            <dd><?php echo $local['rua']; ?></dd>	
                            <dt>Bairro:</dt>		
                            <dd><?php echo $local['Bairro']; ?></dd>	
                            <dt>Número:</dt>
                            <dd><?php echo $local['numero']; ?></dd>	
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
                                    
                                    
                        