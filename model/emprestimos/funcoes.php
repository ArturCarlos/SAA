<?php
require_once('../../config.php');
require_once(DBAPI);

require_once PDF;

/* guardar um conjunto de registros de usuario */
$itens_emprestimos = null;
/* guardará um único cliente, para os casos de inserção e atualização (CREATE e UPDATE) */
$item_emprestimos = null;

/** *  Listagem de itens_emprestimos     */
function index_emprestimos()
{
    global $itens_emprestimos;
    $status = "emprestado";

    if (isset($_POST['filtro'])) {
        $status = $_POST['filtro'];
    }
    $itens_emprestimos = find_all_emprestimos('emprestimos', $status);
}

function add_emprestimos()
{
    if (!empty($_POST['user_solicitou']) && !empty($_POST['patrimonio']) && !empty($_POST['data_prazo_devolucao']) && !empty($_POST['nome'])
        && !empty($_POST['destinatario']) && !empty($_POST['matricula'])) {
        $id_emprestimo = null;
        $patrimonio = $_POST['patrimonio'];

        foreach ($patrimonio as $id_patrimonio):
            foreach ($id_patrimonio as $id_patri):
                $user_solicitou = @$_POST['user_solicitou'];
                $patrimonio_id = $id_patri;
                $data_prazo_devolucao = @$_POST['data_prazo_devolucao'];
                $nome = @$_POST['nome'];
                $destinatario = @$_POST['destinatario'];
                $matricula = @$_POST['matricula'];

                /* Adicionar emprestimo no banco de dados */
                if (save_emp($user_solicitou, $patrimonio_id, 'emprestado', $data_prazo_devolucao)) {
                    /* Se adicionou, edita o status do patrimônio */
                    update_status('patrimonio', $patrimonio_id, 'indisponivel');
                }
                $id_emprestimo = $id_emprestimo . "_" . id_empretimo($id_patri);
            endforeach;
        endforeach;


        header('location: ' . EMPRESTIMOS_PDF . '?id=' . $id_emprestimo);

        exit();
    }
}

//Gerar o pdf dos emprestimos
class PDF extends FPDF
{
    function Header()
    {
        // Logo
        $this->Image("../../dist/img/cabecalho1.png", 25, 23, 160);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        $this->Ln(20);
    }
}

function pdf_emprestimos($nome_patri, $tombo_patri, $data_emprestimo, $data_prazo, $user_realizou, $user_solicitou, $user_matricula, $user_categoria)
{
    // Instanciation of inherited class
    $pdf = new PDF('P', 'mm', 'A4');
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 12);

    $pdf->SetXY(25, 78);
    $pdf->SetMargins(15, 15, 25);
    $pdf->MultiCell(0, 9, utf8_decode("      Eu, $user_solicitou, matrícula n° $user_matricula, $user_categoria(a)" .
        " vinculado(a) a esta Universidade, na Escola Multicampi de Ciências Médicas, solicito empréstimo " .
        "de $nome_patri$tombo_patri. Tenho ciência da responsabilidade em manter a integridade do(s) objeto(s) retirado(s) " .
        "nesta data, me comprometendo a o entregar nas mesmas condições de retirada e no prazo máximo de 3 dias " .
        "contados a partir da data de emissão deste termo.         
Obs.: O não cumprimento da devolução do equipamento emprestado poderá " .
        "acarretar em suspensão temporária da solicitação de empréstimos futuros."), 'C');


    $pdf->Cell(0, 20, utf8_decode("Caicó, $data_emprestimo"), 0, 2, 'R');
    $pdf->Cell(180, 20, utf8_decode("Saída: ___________________________    Entrega: _________________________"), 0, 2, 'C');
    $pdf->Cell(110, -10, utf8_decode("Assinatura"), 0, '0', 'C');
    $pdf->Cell(65, -10, utf8_decode("Assinatura"), 0, '0', 'C');

    $pdf->Cell(0, 15, utf8_decode("Data de entrega: _____/_____/_______"), 0, 1, 'R');
    $pdf->Cell(0, 25, "________________________________________", 'C', 1, 'C');

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, -15, "$user_realizou", 'C', 1, 'C');


    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 25, utf8_decode("Responsável pela entrega do produto."), 'C', 2, 'C');

    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 8, "________________________________________", 'C', 1, 'C');
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(0, 3, utf8_decode("Responsável pelo recebimento do produto."), 0, 1, 'C');

    //Realiza o download do pdf
    $pdf->Output($nome_patri . "-" . $tombo_patri . "-" . $data_emprestimo . ".pdf", "I");

}

function edit_emprestimos()
{
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        if (isset($_POST['emprestimos'])) {
            $item_emprestimos = $_POST['emprestimos'];
            $patrimonio_id = find_patrimonio_emprestimo('emprestimos', $id);
            update_status('patrimonio', $patrimonio_id, 'disponivel');
            update('emprestimos', $id, $item_emprestimos);
            header('location: index.php');
            exit();
        } else {
            global $item_emprestimos;
            $item_emprestimos = find('emprestimos', $id);
        }
    } else {
        header('location: index.php');
        exit();
    }
}

function verifica_atraso($id)
{

    $data_atual = date('d-M-y');
    $data_prazo = find_data_prazo_emprestimo('emprestimos', $id);
// Usa a função strtotime() e pega o timestamp das duas datas:
    $time_atual = strtotime($data_atual);
    $time_prazo = strtotime($data_prazo);
// Calcula a diferença de segundos entre as duas datas:
    $diferenca = $time_prazo - $time_atual; // 19522800 segundos
// Calcula a diferença de dias
    $dias = (int)floor($diferenca / (60 * 60 * 24)); // 225 dias

    if ($dias < 0) {
        if ($dias == -1) {
            return "atrasado: " . -$dias . " dia";
        } else {
            return "atrasado: " . -$dias . " dias";
        }
    } else {
        return "não está atrasado";
    }
}

function view_emprestimos($id = null)
{
    global $item_emprestimos;
    $item_emprestimos = find('emprestimos', $id);
}

function delete_emprestimos($id = null)
{
    global $item_emprestimos;
    $patrimonio_id = find_patrimonio_emprestimo('emprestimos', $id);
    update_status('patrimonio', $patrimonio_id, 'disponivel');
    $item_emprestimos = remove('emprestimos', $id);
    echo $patrimonio_id;
    header('location: index.php');
    exit();
}


function filtro()
{
    global $itens_emprestimos;

    //Verifica se foi passa algun parametro de pesquisa
    $result = 0;

    $like = "%";
    $filtro = array();
    if (isset($_GET['nome'])) {
        if (($_GET['nome'])) {
            $nome = $like . "" . $_GET['nome'] . "" . $like;
            $filtro[] = "nome LIKE '{$nome}'";

            $result = 1;
        }
    }
    if (isset($_GET['tombo'])) {
        if (($_GET['tombo'])) {
            $tombo = $_GET['tombo'];
            $filtro[] = "tombo='{$tombo}'";

            $result = 1;
        }
    }

    if (isset($_GET['setor'])) {
        if (($_GET['setor'])) {
            $setor = $_GET['setor'];
            $filtro[] = "setor_id='{$setor}'";

            $result = 1;
        }
    }

    if ((sizeof($filtro)) > 0) {
        $itens_emprestimos = emprestimos_filtro('patrimonio', $filtro);
    }

    return $result;

}

/** *  Pega o id do emprestimo através do id do patrimonio     */
function id_empretimo($patrimonio_id)
{
    return find_id_empretimo('emprestimos', $patrimonio_id);
}

?>


