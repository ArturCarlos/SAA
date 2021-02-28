<?php require_once '../../config.php'; ?>
<?php require_once DBAPI; ?>
<?php
require_once LOGIN2;
verificaLoginAdmin();

/*Destroi a sessão ao acessar a pagina*/

header('location: 404.php');

?>
<?php require_once SETOR;
?>

<?php require_once LOCAL; ?>

<?php require_once CHAMADO;

viewchamado(id_chamado($_GET['id']));
edit_resp_chamado();
?>

<?php include(HEADER_TEMPLATE); ?>

    <section class="content-header">
        <div class="row">
            <div class="col-sm-6 text-left">
                <ol class="breadcrumb">
                    <li><a href="<?php echo BASEURL; ?>index.php"><i class="fa fa-home"></i>Página Inicial</a></li>
                    <li><a href="index.php"><i class="glyphicon glyphicon-bullhorn"></i> Chamado</a></li>
                    <li><a href="javascript:history.back()"><i class="fa fa-eye"></i> Visualizar</a></li>
                    <li><i class="glyphicon glyphicon-pencil "></i><small>Editar Resposta</small></li>
                </ol>
            </div>
            <div class="breadcrumb text-right">
                <a class="btn btn-default" href="javascript:history.back()"><i
                            class="glyphicon glyphicon-arrow-left"></i> Voltar</a>
            </div>
        </div>
    </section>

    <section class="content">
<?php if ($resp_chamado['user_id'] == $_SESSION['id']): ?>



        <div class="row">
            <div class="col-md-12">
                <div class="row">

                    <div class="col-md-6">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <h3 class="box-title">Resposta</h3>
                            </div>
                            <div class="box-body">
                                <form action=edit_resp.php?id=<?php echo $resp_chamado['id']; ?> method="post"
                                      enctype="multipart/form-data">

                                    <div class="form-group">
                                    <textarea class="form-control" id="mensagem"
                                              placeholder="Sua Resposta..."
                                              rows="6" name="resp_chamado['resposta']" required=""
                                              maxlength="1000"><?php print_r($resp_chamado['resposta']); ?></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="anexo">Atualizar Anexo </label><em> (Opcional)</em>
                                        <input type="file" accept="image/png, image/jpeg, image/jpg, application/pdf"
                                               name='anexo'>
                                    </div>
                                    <div class="form-group">
                                        <?php if ($resp_chamado['anexo']): ?>
                                            <a href="<?php echo(anexo($resp_chamado['anexo'],'resp_chamado')); ?>" target="_blank"
                                               class="btn btn-primary btn-xs" download="anexo">Anexo atual</a>
                                        <?php endif; ?>
                                    </div>
                                    <div id="actions" class="form-group">
                                        <hr>
                                        <button type="submit" class="btn btn-warning">
                                            <i class="fa fa-file-pdf-o"></i> Atualizar
                                        </button>
                                        <a href="javascript:history.back()" class="btn btn-default">
                                            <i class="fa fa-close"></i> Cancelar</a>
                                    </div>
                                </form>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Título: <?php echo($chamado['titulo']) ?></h3>
                                <hr>
                                <h5>Autor(a)
                                    : <?php echo(nome_usuario($chamado['user_id'])) ?></h5>
                                <em>
                                    De: <?php echo(nome_setor($chamado['setor_origem'])) ?>
                                </em>
                                <br>
                                <em>
                                    Para: <?php echo(nome_setor($chamado['setor_destino'])) ?>
                                </em>

                            </div>
                            <div class="box-body">
                                <pre><?php echo(nl2br($chamado['mensagem'])) ?></pre>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>


                </div>
            </div>
        </div>
    </section>
<?php else: ?>
    <section class="content">
        <div class="error-page ">
            <div class="box-danger text-center">
                <h3><i class="fa fa-warning text-yellow"></i> Oops! Página não encontrada.</h3>
            </div>
            <!-- /.error-content -->
        </div>
        <!-- /.error-page -->
    </section>
<?php endif; ?>


<?php include(FOOTER_TEMPLATE); ?>