<?php require_once '../../config.php'; ?>
<?php require_once DBAPI; ?>
<?php
    require_once LOGIN2;
    verificaLoginAdmin();
?>
<?php 
    require_once CHAMADO;
    $setores = Setor_all();    

?>

<?php
    require_once LOCAL;
    addLocal();
?>
<?php include(HEADER_TEMPLATE); ?>

<section class="content-header">
    <div class="row">
        <div class="col-sm-6 text-left">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASEURL; ?>index.php"><i class="fa fa-home"></i>Página Inicial</a></li>
                <li><a href="index.php"><i class="glyphicon glyphicon-bullhorn"></i> Chamado</a></li>
                <li><i class="glyphicon glyphicon-plus-sign"></i><small> Criar Chamado</small></li>
            </ol>
        </div>
        <div class="breadcrumb text-right">
            <a class="btn btn-default" href="./index.php"><i class="glyphicon glyphicon-arrow-left"></i> Voltar</a>
        </div>
    </div>
</section>

<section class="content">

    <?php include(ALERT_MSG); ?>

    <div class="row">
        <div class="col-md-12 ">
            <div class="box">
                <!-- /.box-header -->
                <div class="box-body">
                    <form action='' method="post" enctype="multipart/form-data">
                        <!-- area de campos do form -->
                        <h3 class="text-center">Preencha os campos abaixo para criar um chamado</h3>
                        <hr />
                        <div class="form-group">
                            <label for="nome">Matricula do Solicitante </label>
                            <input type="text" class="form-control"
                                value="<?php echo $_SESSION['matricula'];  ?>" required="false" disabled="true">                            
                        </div>

                        <div class="form-group">
                            <label for="setor_id_user ">Setor Solicitante</label>
                            <input type="text" class="form-control" id="setor_id_user"   required="false" disabled="true" value="Casa">
                            <input type="hidden" name="setor_id_user" value="1" required="true">

                        </div>

                        <div class="form-group">
                            <label for="setor_id_pedido">Setor Solicitado </label>
                            <select class="form-control" id="setor_id_pedido" name="setor_id_pedido" required="true">
                                <option value=""></option>
                                <?php if ($setores) : ?>
                                <?php foreach ($setores as $setor) : ?>
                                <option value="<?php echo $setor['id']; ?>"><?php echo $setor['nome'];?> -
                                    <?php echo nome_setor_local($setor['local_id']) ; ?></option>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>                        

                        <div class="form-group">
                            <label for="descricao">Descriação Chamado </label>
                            <textarea type="text" rows='10' class="form-control" id="descricao"
                                name="mensagem_chamado" required="true" maxlength="1000"
                                style="resize:none;"  > </textarea>
                        </div>

                        <div class="form-group">
                            <label for="imagem">Foto do Local </label>
                            <input id="imagem" type="file" accept="image/png, image/jpeg, image/jpg" name="img">
                        </div>

                        <div id="actions" class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" name='cadastrar_chamado'>
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