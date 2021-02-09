<?php require_once '../../config.php'; ?>
<?php require_once DBAPI; ?>

<?php
require_once LOGIN2;
verificaLoginOperador();
?>
<?php
require_once CHAMADO;
index_acesso_chamado();
indextag();

$result = filtro();

?>
<?php
require_once LOCAL;
indexLocal();
?>

<?php
require_once SETOR;
?>


<?php include(HEADER_TEMPLATE_OPERACIONAL); ?>

<section class="content-header">
    <div class="row">
        <div class="col-sm-6 text-left">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASEURL; ?>index.php"><i class="fa fa-home"></i>Página Inicial</a></li>
                <li><a href="index.php"><i class="glyphicon glyphicon-bullhorn"></i> Chamados</a></li>
                <li><a href="historico.php"><i class="fa fa-history"></i> Histórico</a></li>
                <li><i class="fa fa-filter"></i>

                    <small>Filtrar</small>
                </li>
            </ol>
        </div>
        <div class="breadcrumb text-right">
            <a class="btn btn-default" href="historico.php"><i
                        class="glyphicon glyphicon-arrow-left"></i> Voltar</a>
        </div>
    </div>
</section>

<section class="content">
    <!-- *****Alertas de Operações*****-->
    <?php include(ALERT_MSG); ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header text-center">
                    <h3>Preencha os campos para filtrar</h3>
                    <hr/>
                </div>

                <form class="form-horizontal" method="get" action="filtro.php">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="titulo">Título</label>
                        <div class="col-sm-9">
                            <input class="form-control" name="titulo" type="text"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"> Tag: </label>
                        <div class="col-sm-9">

                            <select class="form-control" id="tag" name="tag">
                                <option value=""></option>

                                <!--Verificar se o usuario é nivel 1 ou 2-->
                                <?php if ($tags) : ?>
                                    <?php foreach ($tags as $tag) : ?>
                                        <option value="<?php echo $tag['id']; ?>"><?php echo $tag['nome']; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"> Setor Origem: </label>
                        <div class="col-sm-9">
                            <select class="form-control" id="setor_origem" name="setor_origem">
                                <option value=""></option>
                                <?php if ($acesso_chamado) : ?>
                                    <?php foreach ($acesso_chamado as $setor) : ?>
                                        <option value="<?php echo $setor['setor_id']; ?>"><?php echo nome_setor($setor['setor_id']); ?>
                                            - <?php echo nome_setor_local(local_id_setor($setor['setor_id'])); ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"> Setor Destino: </label>
                        <div class="col-sm-9">
                            <select class="form-control" id="setor_destino" name="setor_destino">
                                <option value=""></option>
                                <?php if ($acesso_chamado) : ?>
                                    <?php foreach ($acesso_chamado as $setor) : ?>
                                        <option value="<?php echo $setor['setor_id']; ?>"><?php echo nome_setor($setor['setor_id']); ?>
                                            - <?php echo nome_setor_local(local_id_setor($setor['setor_id'])); ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group text-center">

                        <button title="Filtrar itens" type="submit" class="btn btn-primary">
                            <i class="fa fa-filter"></i> Filtrar
                        </button>

                        <a title="Limpar busca" class="btn btn-warning" href="filtro.php"><i
                                    class="fa fa-close"></i> Limpar</a>

                        <hr/>
                    </div>
                </form>


                <?php if ($result): ?>

                    <div class="box-body">
                        <div class="box-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th title="Ordenar Tabela">Número</th>
                                    <th title="Ordenar Tabela">Título</th>
                                    <th>Data</th>
                                    <th>Tag</th>

                                    <th>Ações</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if ($chamados) : ?>

                                    <?php foreach ($chamados as $chamado) : ?>
                                        <tr>
                                            <td><?php echo ($chamado['id']); ?></td>

                                            <td><?php echo substr($chamado['titulo'], 0, 30);
                                                if (strlen($chamado['titulo']) > 20):?>
                                                    <a href="view.php?id=<?php echo $chamado['id']; ?>">[...]</a>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo formata_data($chamado['date']); ?></td>
                                            <td>
                                                <?php
                                                index_tag_chamado($id = $chamado['id']);

                                                if ($tags_chamado):
                                                    foreach ($tags_chamado as $tag_chamado):?>
                                                        <?php echo nome_tag($tag_chamado['tag_id']) . ",&nbsp";
                                                    endforeach;
                                                    else:
                                                        echo "Sem tags";
                                                endif; ?>
                                            </td>

                                            <td class="actions text-center">
                                                <a href="view.php?id=<?php echo $chamado['id']; ?>"
                                                   class="btn btn-sm btn-success" data-toggle="tooltip"
                                                   data-placement="left" title="Visualizar"><i class="fa fa-eye"></i>
                                                    Visualizar
                                                </a>

                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="6">Nenhum registro encontrado.</td>
                                    </tr>

                                <?php endif; ?>
                                </tbody>
                                <tfoot>
                                <tr style="background: #F4F4F4">

                                </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php include(FOOTER_TEMPLATE); ?>
