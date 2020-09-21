<?php require_once '../../config.php'; ?>
<?php require_once DBAPI; ?>
<?php
require_once LOGIN2;
verificaLoginAdmin();
?>

<?php
require_once CHAMADO;
viewchamado($_GET['id']);
indextag();
index_tag_chamado();
add_tag_chamado();
?>
<?php include(HEADER_TEMPLATE); ?>

<!-- Main conteudoCentral -->

<section class="content-header">
    <div class="row">
        <div class="col-sm-6 text-left">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASEURL; ?>index.php"><i class="fa fa-home"></i>Página Inicial</a></li>
                <li><a href="index.php"><i class="glyphicon glyphicon-bullhorn"></i> Chamado</a></li>
                <li><a href="javascript:history.back()"><i class="fa fa-eye"></i> Visualizar</a></li>

                <li><i class="fa fa-tags"></i>

                    <small>Tag</small>
                </li>
            </ol>
        </div>
        <div class="breadcrumb text-right">
            <a class="btn btn-default" href="javascript:history.back()"><i class="glyphicon glyphicon-arrow-left"></i> Voltar</a>
        </div>

    </div>
</section>

<section class="content">

    <div class='row'>
        <div class="col-xs-12">
            <div class='box'>
                <div class="box-header text-center">
                    <h3>Gerenciar Tags</h3>
                    <hr/>
                </div>
                <div class="box-body">
                    <form action=tag_chamado.php?id=<?php echo $chamado['id'] ?> method="post">
                        <div class="form-group">
                            <label>Título</label>
                            <select class="form-control" name="chamado_id['chamado_id']">
                                <option value=<?php echo $chamado['id']; ?>><?php echo $chamado['titulo']; ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tags:</label>

                            <select class="form-control select2" id="setor_id"
                                    name="tag_chamado['tag_id'][]" multiple="multiple" >
                                <?php if ($tags) : ?>
                                    <?php foreach ($tags as $tag) :
                                        $aux = true;
                                        foreach ($tags_chamado as $cham_tag) :
                                            if (($tag['id'] == $cham_tag['tag_id'])) : ?>
                                                <option selected="selected"
                                                        value="<?php echo $cham_tag['tag_id']; ?>">
                                                    <?php echo $tag['nome']; ?> </option>
                                                <?php
                                                $aux = false;
                                                break;
                                            endif;
                                        endforeach;
                                        if ($aux):?>
                                            <option value="<?php echo $tag['id']; ?>">
                                                <?php echo $tag['nome']; ?> </option>

                                        <?php endif;
                                    endforeach;
                                endif; ?>

                            </select>
                        </div>
                        <div id="actions" class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-check"></i> Adicionar
                                </button>
                                <a href="gerenciar.php" class="btn btn-default">
                                    <i class="fa fa-close"></i> Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</section>
<!-- /.content -->

<?php include('modal.php'); ?>
<?php include(FOOTER_TEMPLATE); ?>

<script src="<?php echo BASEURL; ?>bower_components/select2/dist/js/select2.full.min.js"></script>


<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()
    })
</script>
