<?php require_once '../../config.php'; ?>
<?php require_once DBAPI; ?>
<?php
    require_once PATRIMONIO;
    viewPatrimonio($_GET['id']);
?>
<?php
    require_once SETOR;
    indexSetor();
?>
<?php include(HEADER_TEMPLATE_OPERACIONAL); ?>

<section class="content-header">		
    <div class="row">			
        <div class="col-sm-6 text-left">				
            <ol class="breadcrumb">
                <li><a href="<?php echo BASEURL; ?>index.php"><i class="fa fa-home"></i>Página Inicial</a></li>
                <li><a href="index.php"><i class="fa fa-bank"></i> Listagem de Patrimônios</a></li>
                <li><i class="glyphicon glyphicon-eye-open"></i>
                    <small> Visualizar Patrimônio</small>
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
                    <center><h3>Informações do patrimônio</h3></center>
                        <hr />
                        <center><img src="<?php echo BASEURL; ?>dist/img/semFoto.png" 
                                     class="img-rounded" alt="Cinque Terre"></center>
                        <dl class="dl-horizontal">		
                            <dt>Nome:</dt>		
                            <dd><?php echo $patrimonio['nome']; ?></dd>	
                            <dt>Especificação:</dt>		
                            <dd><?php echo $patrimonio['especificacao']; ?></dd>	
                            <dt>Tombo:</dt>		
                            <dd><?php echo $patrimonio['tombo']; ?></dd>	
                            <dt>Emprestável:</dt>		
                            
                            <!-- Mostra se o patrimônio é emprestável -->
                            <?php if ($patrimonio['permissao'] == 1) : ?>	
                            <dd>Sim</dd>
                            <?php else : ?>				
                            <dd>Não</dd>		
                            <?php endif; ?>
                            <dt>Setor responsável:</dt>
                            <!-- Mostra o setor responsável do patrimônio -->
                            <?php if ($setores) : ?>	
                                <?php foreach ($setores as $setor) : ?>
                                    <?php if ($setor['id'] == $patrimonio['setor_id']) : ?>	
                                        <dd><?php echo $setor['nome']; ?></dd>
                                    <?php endif; ?>                            
                                <?php endforeach; ?>	
                            <?php else : ?>				
                                <dd>Setor não encontrado</dd>		
                            <?php endif; ?>
                            	
                        </dl>	
                        <div id="actions" class="row">		
                            <div class="col-md-12">		  
                                <a href="edit.php?id=<?php echo $patrimonio['id']; ?>" class="btn btn-primary">
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
                                    
                                    
                        