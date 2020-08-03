<?php require_once '../../config.php'; ?>
<?php require_once DBAPI; ?>
<?php
require_once LOGIN2;
verificaLoginOperador();
?>
<?php
require_once PATRIMONIO;
editPatrimonio();
verifica_editPatrimonio();
 ;?>
<?php
require_once SETOR;
indexSetor_operacional();
?>
<?php
require_once LOCAL;
?>
<?php include(HEADER_TEMPLATE_OPERACIONAL); ?>

<section class="content-header">
    <div class="row">
        <div class="col-sm-6 text-left">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASEURL; ?>index.php"><i class="fa fa-home"></i>Página Inicial</a></li>
                <li><a href="index.php"><i class="fa fa-bank"></i> Listagem de Patrimônios</a></li>
                <li><i class="glyphicon glyphicon-pencil"></i>
                    <small> Editar Patrimônio</small>
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
                    <form action="edit.php?id=<?php echo $patrimonio['id']; ?>" method="post"
                          enctype="multipart/form-data">
                        <!-- area de campos do form -->
                        <h3 class="text-center">Edite nos campos abaixo as informações do patrimônio</h3></
                    >
                    <hr/>
                    <div class="form-group">
                        <label for="nome">Nome </label>
                        <input type="text" class="form-control" id="nome"
                               value="<?php echo $patrimonio['nome']; ?>"
                               name="patrimonio['nome']" required="">
                    </div>

                    <div class="form-group">
                        <label for="especificacao">Especificação </label>
                        <textarea class="form-control" id="especificacao"
                                  rows="3" name="patrimonio['especificacao']"
                                  required=""><?php echo trim($patrimonio['especificacao']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="tombo">Tombo </label>
                        <input type="text" class="form-control" id="tombo"
                               value="<?php echo $patrimonio['tombo']; ?>"
                               name="patrimonio['tombo']" required="">
                    </div>
                    <div class="form-group">
                        <label for="setor_id">Setor responsável </label>
                        <select class="form-control" id="setor_id"
                                name="patrimonio['setor_id']" required="">
                            <?php if ($setores) : ?>
                                <?php foreach ($setores as $setor) : ?>
                                    <?php if ($setor['setor_id'] == $patrimonio['setor_id']) { ?>
                                        <option value="<?php echo $setor['setor_id']; ?>"><?php echo nome_setor($setor['setor_id']); ?>
                                            - <?php echo nome_setor_local(local_id_setor($setor['setor_id'])); ?></option>

                                    <?php } else { ?>
                                        <option value="<?php echo $setor['setor_id']; ?>"><?php echo nome_setor($setor['setor_id']); ?>
                                            - <?php echo nome_setor_local(local_id_setor($setor['setor_id'])); ?></option>
                                    <?php } endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="permissao">Emprestável</label></br>
                        <select class="form-control" id="permissao"
                                name="patrimonio['permissao']" required="">
                            <!-- Mostra se o patrimônio é emprestável -->
                            <?php if ($patrimonio['permissao'] == 1) : ?>
                                <option value=1>Sim</option>
                                <option value=0>Não</option>
                            <?php else : ?>
                                <option value=0>Não</option>
                                <option value=1>Sim</option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <?php if ($patrimonio['img'] != null) { ?>
                            <img src="<?php echo BASEURL; ?>imagens/patrimonio/<?php echo $patrimonio['img']; ?>"
                                 class="img-rounded view_img_1" alt="Cinque Terre"/>
                        <?php } else { ?>
                            <img src="<?php echo BASEURL; ?>dist/img/semFoto.png?>"
                                 class="img-rounded view_img_1" alt="Cinque Terre"/>
                        <?php } ?>
                    </div>

                    <div class="form-group">
                        <label for="imagem">Alterar Imagem</label>
                        <input type="file" accept="image/png, image/jpeg, image/jpg" name='img'>
                    </div>

                    <div id="actions" class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Salvar
                            </button>
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


