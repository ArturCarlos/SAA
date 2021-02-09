<?php require_once '../../config.php'; ?>
<?php require_once DBAPI; ?>
<?php
require_once LOGIN2;
verificaLoginOperador();
?>
<?php require_once SETOR;
indexSetor_operacional();
?>

<?php require_once LOCAL; ?>

<?php require_once CHAMADO;
index_acesso_chamado();
add_chamado();
?>

<?php include(HEADER_TEMPLATE_OPERACIONAL); ?>

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
                <a class="btn btn-default" href="javascript:history.back()"><i class="glyphicon glyphicon-arrow-left"></i> Voltar</a>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12 ">
                <div class="box">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form action=add.php method="post" enctype="multipart/form-data">
                            <!-- area de campos do form -->
                            <h4 class="text-center">Preencha os campos abaixo para criar um chamado</h4>
                            <hr/>

                            <div class="col-md-6 ">

                                <div class="form-group">
                                    <label for="titulo">Título</label>
                                    <input type="text" class="form-control" id="titulo"
                                           placeholder="Título do chamado"
                                           name="chamado['titulo']" required="">
                                </div>
                            </div>
                            <div class="col-md-3 ">


                                <div class="form-group">
                                    <label for="nome">Nome </label>
                                    <input type="text" class="form-control"
                                           value="<?php echo $_SESSION['nome']; ?>" disabled="true">
                                </div>
                            </div>

                            <div class="col-md-3 ">

                                <div class="form-group">
                                    <label for="nome">Matrícula </label>
                                    <input type="text" class="form-control"
                                           value="<?php echo $_SESSION['matricula']; ?>" disabled="true">
                                </div>
                            </div>

                            <div class="col-md-6 ">
                                <div class="form-group">
                                    <label for="setor_destino">Setor Solicitado</label><em> (Selecione o setor de
                                        destino)</em>
                                    <select class="form-control" id="setor_destino"
                                            name="chamado['setor_destino']" required="">
                                        <option value=""></option>

                                        <?php if ($acesso_chamado) : ?>
                                            <?php foreach ($acesso_chamado as $ac_setor) : ?>
                                                <option value="<?php echo $ac_setor['setor_id']; ?>"> <?php echo nome_setor($ac_setor['setor_id']); ?>
                                                    - <?php echo nome_setor_local(local_id_setor($ac_setor['setor_id'])); ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>

                                    </select>

                                </div>
                            </div>

                            <div class="col-md-6 ">
                                <div class="form-group">
                                    <label for="setor_origem">Setor Solicitante</label><em> (Selecione seu setor)</em>
                                    <select class="form-control" id="setor_origem"
                                            name="chamado['setor_origem']" required="">

                                        <?php if ($setores) : ?>
                                            <?php foreach ($setores as $setor) : ?>
                                                <option value="<?php echo $setor['setor_id']; ?>"> <?php echo nome_setor($setor['setor_id']); ?>
                                                    - <?php echo nome_setor_local(local_id_setor($setor['setor_id'])); ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>

                                    </select>

                                </div>
                            </div>

                            <div class="col-md-6 ">
                                <div class="form-group">
                                    <label for="mensagem">Descriação Chamado </label>
                                    <textarea class="form-control" id="mensagem"
                                              placeholder="Descriação Chamado"
                                              rows="6" name="chamado['mensagem']" required="true"
                                              maxlength="1000"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <div class="form-group">
                                    <label for="imagem">Anexo </label><em> (Opcional)</em>
                                    <input type="file" accept="image/png, image/jpeg, image/jpg, application/pdf" name='anexo'>

                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <div id="actions" class="form-group">
                                    <hr>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-file-pdf-o"></i> Cadastrar
                                    </button>
                                    <a href="index.php" class="btn btn-default">
                                        <i class="fa fa-close"></i> Cancelar</a>
                                    <hr>
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


            <!-- /.row -->
    </section>
<?php include('modal.php'); ?>

<?php include(FOOTER_TEMPLATE); ?>