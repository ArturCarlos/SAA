<?php require_once '../../config.php'; ?>
<?php require_once DBAPI; ?>
<?php
    require_once LOGIN2;
    verificaLoginAdmin();
?>
<?php
    require_once SETOR;
    addSetor();
?>

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
                <li><a href="index.php"><i class="fa fa-cubes"></i> Listagem de Setores</a></li>
                <li><i class="glyphicon glyphicon-plus-sign"></i>
                    <small> Adicionar setor</small>
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
                    <form action=add.php method="post" enctype="multipart/form-data">
                        <!-- area de campos do form -->
                        <h3 class="text-center">Preencha os campos abaixo para adicionar um setor</h3>
                        <hr />	      
                        <div class="form-group">	      
                            <label for="nome">Nome </label>	      
                            <input type="text" class="form-control" id="nome" 
                                   placeholder="Nome do setor" 
                                   name="setor['nome']" required="">	    
                        </div>
                        <div class="form-group">	      
                            <label for="numero">Número </label>	      
                            <input type="text" class="form-control" id="numero" 
                                   placeholder="Número do setor"
                                   name="setor['numero']" required="">	    
                        </div>


                        <div class="form-group">
                            <label for="usuario_id">Usuário responsável </label>
                            <select class="form-control select2" id="usuario_id"
                                    name="user_setor['usuario_id'][]" multiple="multiple" required="">

                                <!--Verificar se o usuario é nivel 1 ou 2-->
                                <?php if ($usuarios) : ?>
                                    <?php foreach ($usuarios as $usuario) : ?>
                                        <?php if ($usuario['permissao'] == 1 || $usuario['permissao'] == 2) : ?>
                                            <option value="<?php echo $usuario['id']; ?>"><?php echo $usuario['nome'];?> - <?php echo $usuario['matricula'];?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>


                            </select>
                        </div>
                        <div class="form-group">
                            <label for="local_id">Localidade </label>
                            <select class="form-control" id="local_id" 
                                    name="setor['local_id']" required="">
                                <option value="" ></option>
                                <?php if ($locais) : ?>	
                                    <?php foreach ($locais as $local) : ?>					
                                    <option value="<?php echo $local['id']; ?>"><?php echo $local['nome']; ?></option>			
                                    <?php endforeach; ?>		
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="imagem">Foto do Local </label>
                            <input type="file" accept="image/png, image/jpeg, image/jpg" name='img'>

                        </div>

                        <div id="actions" class="row">	    
                            <div class="col-md-12">	      
                                <button type="submit" class="btn btn-primary">
                                <i class="fa fa-check"></i> Cadastrar</button>
                                <a href="index.php" class="btn btn-default">
                                    <i class="fa fa-close"></i> Cancelar</a>	    
                            </div>	  
                        </div>
                    </form>
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

<script src="<?php echo BASEURL; ?>bower_components/select2/dist/js/select2.full.min.js"></script>


<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()
    })
</script>