<?php require_once '../../config.php'; ?>
<?php require_once DBAPI; ?>

<?php
require_once LOGIN2;
verificaLoginAdmin();
?>
<?php
require_once PATRIMONIO;
?>
<?php
require_once LOCAL;
indexLocal();
?>

<?php
require_once SETOR;
indexSetor();
?>

<?php
require_once EMPRESTIMOS;
$result = filtro();
?>


<?php include(HEADER_TEMPLATE); ?>

<section class="content-header">
    <div class="row">
        <div class="col-sm-6 text-left">
            <ol class="breadcrumb">
                <li><a href="<?php echo BASEURL; ?>index.php"><i class="fa fa-home"></i>Página Inicial</a></li>
                <li><i class="glyphicon glyphicon-search"></i>
                    <small> Consultar Emprestimos</small>
                </li>
            </ol>
        </div>
        <div class="breadcrumb text-right">
            <a class="btn btn-default" href="<?php echo BASEURL; ?>index.php"><i
                        class="glyphicon glyphicon-arrow-left"></i> Voltar</a>
        </div>
    </div>
</section>

<section class="content">
    <!-- *****Alertas de Operações*****-->
    <?php include(ALERT_MSG); ?>
    <!-- Mostra o setor responsável do patrimônio -->
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <div class="box-header text-center">
                        <h3>Preencha os campos para a busca</h3>
                        <hr/>
                    </div>
                    <!-- /.box-header -->

                    <form class="form-horizontal" method="get" action="consulta.php">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="nome"> Nome</label>
                            <div class="col-sm-9">
                                <input class="form-control" name="nome" type="text"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"> Tombo </label>
                            <div class="col-sm-9">
                                <input class="form-control" name="tombo" type="text"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label"> Setor: </label>
                            <div class="col-sm-9">
                                <select class="form-control" id="setor" name="setor">
                                    <option value=""></option>
                                    <?php if ($setores) : ?>
                                        <?php foreach ($setores as $setor) : ?>
                                            <?php if ($setor['id']): ?>
                                                <option value="<?php echo $setor['id']; ?>"><?php echo $setor['nome']; ?>
                                                    - <?php echo(nome_setor_local($setor['local_id'])); ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group text-center">

                            <button title="Pesquisa itens" type="submit" class="btn btn-primary">
                                <i class="fa fa-search"></i> Pesquisar
                            </button>

                            <a title="Limpar busca" class="btn btn-warning" href="consulta.php"><i
                                        class="fa fa-close"></i> Limpar</a>

                            <hr/>
                        </div>
                    </form>


                    <?php if ($result): ?>

                        <div class="box-body">

                            <div class="box-body">

                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th title="Ordenar Tabela">Nome</th>
                                        <th title="Ordenar Tabela">Tombo</th>
                                        <th title="Ordenar Tabela">Especificação</th>
                                        <th title="Ordenar Tabela">Setor</th>
                                        <th title="Ordenar Tabela">Local</th>
                                        <th title="Ordenar Tabela">Status</th>
                                        <th>Visualizar</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if ($itens_emprestimos) : ?>
                                        <?php foreach ($itens_emprestimos as $patrimonio) : ?>
                                            <tr>
                                                <td><?php echo $patrimonio['nome']; ?></td>
                                                <td><?php echo $patrimonio['tombo']; ?></td>
                                                <td><?php echo substr($patrimonio['especificacao'], 0, 30);
                                                    if (strlen($patrimonio['especificacao']) > 50):?>
                                                        <a href="viewconsulta.php?id=<?php echo $patrimonio['id']; ?>">[...]</a>
                                                    <?php endif; ?>
                                                </td>

                                                <td>
                                                    <?php if ($setores) : ?>
                                                        <?php foreach ($setores as $setor) : ?>
                                                            <?php if ($setor['id'] == $patrimonio['setor_id']) : ?>
                                                                <dd><?php echo $setor['nome']; ?></dd>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($locais) : ?>
                                                        <?php foreach ($locais as $local) : ?>
                                                            <?php if ($local['id'] == $setor['local_id']) : ?>
                                                                <dd><?php echo $local['nome']; ?></dd>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>

                                                    <?php endif; ?>
                                                </td>

                                                <td><?php if ($patrimonio['status'] == 'indisponivel'): echo "Indisponível para empréstimo";
                                                    else: echo "Disponivel para empréstimo";
                                                    endif; ?>
                                                </td>

                                                <td><a href="viewconsulta.php?id=<?php echo $patrimonio['id']; ?>"
                                                       class="btn btn-sm btn-success"><i class="fa fa-eye"></i>
                                                        Visualizar</a>
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
                                    <tr>
                                        <th>Nome</th>
                                        <th>Tombo</th>
                                        <th>Especificação</th>
                                        <th>Setor</th>
                                        <th>Local</th>
                                        <th>Status</th>
                                        <th>Visualizar</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include(FOOTER_TEMPLATE); ?>
