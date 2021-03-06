</div>

<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2020 <a href="http://emcm.ufrn.br" target="_blank">Escola Multicampi de Ciências
            Médicas</a>.</strong> Todos os direitos reservados
</footer>

<div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="<?php echo BASEURL; ?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo BASEURL; ?>bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo BASEURL; ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- jvectormap -->
<script src="<?php echo BASEURL; ?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo BASEURL; ?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo BASEURL; ?>bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo BASEURL; ?>bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?php echo BASEURL; ?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo BASEURL; ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- DataTables -->
<script src="<?php echo BASEURL; ?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo BASEURL; ?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo BASEURL; ?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>

<!-- AdminLTE App -->
<script src="<?php echo BASEURL; ?>dist/js/adminlte.min.js"></script>

<!-- AdminLTE for demo purposes -->
<script src="<?php echo BASEURL; ?>dist/js/demo.js"></script>

<script src="<?php echo BASEURL; ?>dist/js/main.js"></script>

<script src="<?php echo BASEURL; ?>dist/js/notificacao.js"></script>

<script src="<?php echo BASEURL; ?>dist/js/tabelas.js"></script>

<?php
//Pega a url operacioal ou admin

$url = $_SERVER['REQUEST_URI'];
$url = (explode('/', $url));
$url =  ($url[2]);

?>
<!--Libera o acesso ao chamado
--><!--Inicio das notificacoes-->

<script>
    // Função responsável por atualizar as notificacões
    function atualizar() {
        // Fazendo requisição AJAX
        $.post('<?php echo BASEURL; ?>model/chamado/notificacao.php', function (frase) {
            // Exibindo frase
            $('#notificacao').html('<i>' + frase.notificacao + '</i>');
        }, 'JSON');
    }

    // Definindo intervalo que a função será chamada
    setInterval("atualizar()", 10000);
    // Quando carregar a página
    $(function () {
        // Faz a primeira atualização
        atualizar();
    });
</script>

<script>
    // Função responsável por listar as notificacões
    function listar() {
        var valor = "";
        $.get('<?php echo BASEURL; ?>model/chamado/list_notificacao.php', function (frase) {
            // Exibindo frase

            for (var [key, value] of Object.entries(frase)) {
                valor += '<li>' +
                    '<a href="" class="col-xs-2 text-center" title="Marca como lida"' +
                    'data-toggle="modal"' +
                    'data-target="#msgLida-modal"' +
                    'data-customer="' + value.id_destino + '&id=' + value.chamado_id + '">' +
                    '<i class="fa fa-circle text-green"></i>' +
                    '</a>' +

                    '<a href="<?php echo BASEURL.$url; ?>/chamado/view.php?id=' + value.chamado_id + '">' +
                    value.descricao + ' #' + value.chamado_id +
                    '</a>'
                    + '</li>'
            }

            $('#list_notificacao').html(valor);
        }, 'JSON');
    }

</script>


<!-- Modal de fechar notificacao chamado-->
<div class="modal fade" id="msgLida-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalLabel">Marcar como lida?</h4>
            </div>
            <div class="modal-body">
                Está notificação será apagada! Você poderá visualizar este chamado na
                seção de chamado!

            </div>

            <div class="modal-footer">
                <a id="confirm" class="btn btn-primary" href="#">Sim</a>
                <a id="cancel" class="btn btn-default" data-dismiss="modal">N&atilde;o</a>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->

<script>
    /**     * Passa os dados da notificação do chamado para o Modal */
    $('#msgLida-modal').on('show.bs.modal', function (event) {

        var button = $(event.relatedTarget);
        var id = button.data('customer');
        var modal = $(this);
        var url = "<?php echo BASEURL.$url; ?>" + '/chamado/view.php';

        //modal.find('.modal-title').text('O sistema precisa de sua confirmação');
        modal.find('#confirm').attr('href', url + '?msgLida_id=' + id);
    })
</script>

<!--FIM  das notificacoes-->


<!-- Tempo de sessão -->
<?php if (isset($_SESSION['id'])): ?>
    <script>
        var tempo = new Number();
        // Tempo em segundos
        tempo = 1800;

        function startCountdown() {
            // Se o tempo não for zerado
            if ((tempo - 1) >= 0) {

                // Pega a parte inteira dos minutos
                var min = parseInt(tempo / 60);
                // Calcula os segundos restantes
                var seg = tempo % 60;

                // Formata o número menor que dez, ex: 08, 07, ...
                if (min < 10) {
                    min = "0" + min;
                    min = min.substr(0, 2);
                }
                if (seg <= 9) {
                    seg = "0" + seg;
                }

                // Cria a variável para formatar no estilo hora/cronômetro
                horaImprimivel = '00:' + min + ':' + seg;
                //JQuery pra setar o valor
                $("#cronometro").html(horaImprimivel);

                // Define que a função será executada novamente em 1000ms = 1 segundo
                setTimeout('startCountdown()', 1000);

                // diminui o tempo
                tempo--;

                // Quando o contador chegar a zero faz esta ação
            } else {
                window.open('<?php echo BASEURL;?>model/logout/funcoes.php', '_self');

            }
        }

        // Chama a função ao carregar a tela
        startCountdown();
    </script>
<?php endif; ?>

<!--Tempo das messagens de aletas-->
<script>
    window.setTimeout(function () {
        $("#alertas").fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
        });
    }, 5000);
</script>

<script>
    function validarSenha() {
        var senha = form_senha.senha.value;
        var senha2 = form_senha.senha2.value;
        if (senha === "mudar123") {
            alert("Vixeee, você não poderá usar a senha padrão como sua senha.\nPor favor, digite uma senha diferente");
            return false;
        } else if (senha === "") {
            alert("Vixeee, sem digitar você nos complica.\nPor favor, digite sua senha");
            return false;
        } else if (senha.length < 5) {
            alert("Vixeee, sua senha deve conter no mínimo 6 caracteres.\nPor favor, digite uma senha diferente");
            return false;
        } else {
            if (senha !== senha2) {
                alert("Vixeee, as senhas não conferem!\nDigite as senhas iguais");
                return false;
            } else {
                return true;
            }
        }
    }
</script>

<script>
    function validarData() {
        var data_prazo_devolucao = new Date(form_add_emprestimo.data_prazo_devolucao.value);
        var data_atual = new Date();
        var timeDiff = (data_prazo_devolucao.getTime() - data_atual.getTime());
        var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
        if (diffDays <= 0) {
            alert("A data informada do prazo de devolução deve ser após a data atual");
            return false;
        } else if (diffDays > 7) {
            alert("O prazo de devolução não pode ultrapassar 7 dias");
            return false;
        } else {
            return true;
        }
    }
</script>

<script type="text/javascript">
    function optionCheck() {
        var option = document.getElementById("status").value;
        if (option == 1) {
            document.getElementById("nome_pessoa_entregou").style.visibility = "hidden";
            document.getElementById("documento_pessoa_entregou").style.visibility = "hidden";
            document.getElementById("telefone").style.visibility = "hidden";
        } else {
            document.getElementById("nome_pessoa_entregou").style.visibility = "visible";
            document.getElementById("documento_pessoa_entregou").style.visibility = "visible";
            document.getElementById("telefone").style.visibility = "visible";
        }
    }
</script>

<!--
    1° código: executa a partir do clique
    2° código: executa somente na primeira vez
-->
<script type="text/javascript">
    $('input[name="FlgPontua"]').change(function () {
        if ($('input[name="FlgPontua"]:checked').val() === "Sim") {
            $('.mesmo_usuario').hide();
            $('.outro_usuario').show();
        } else {
            $('.outro_usuario').hide();
            $('.mesmo_usuario').show();
        }
    });

    if ($('input[name="FlgPontua"]:checked').val() === "Sim") {
        $('.mesmo_usuario').hide();
        $('.outro_usuario').show();
    } else {
        $('.outro_usuario').hide();
        $('.mesmo_usuario').show();
    }
</script>

<!--<script type="text/javascript">
    $(document).ready(function() {
        $('#id_local').change(function(e) {
            $('#id_setor').empty();
            var id = $(this).val();
            $.post('call_cidades.php', {id:id}, function(data){
                var cmb = '<option value="">Setor onde o item foi encontrado </option>';
                $.each(data, function (index, value){
                    cmb = cmb + '<option value="' + value.cidadeid + '">' + value.cidade + '</option>';;
                });
                $('#id_setor').html(cmb);
            }, 'json');
        });
    });
</script>-->

</body>
</html>
