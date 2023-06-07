<?php
require('vendor/autoload.php');
include_once('database.php');

session_start();

if (!isset($_SESSION['email']) || !isset($_SESSION['senha']) || $_SESSION['T_userType_id_userType'] !== "1") {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    unset($_SESSION['T_userType_id_userType']);
    session_regenerate_id(true);
    header('Location: login.php');
    exit();
}

$email = $_SESSION['email'];
$sql = "SELECT * FROM t_usuario WHERE email = '$email'";
$result = mysqli_query($conexao, $sql);
$row = mysqli_fetch_assoc($result);
$nome = $row['nome'];

date_default_timezone_set('America/Sao_Paulo');
$currentDate = date('Y-m-d H:i:s');
$sql = "SELECT t_reserva.*, t_laboratorio.nome AS nome FROM t_reserva
        INNER JOIN t_laboratorio ON t_reserva.t_laboratorio_id_laboratorio = t_laboratorio.id_laboratorio
        WHERE t_reserva.horario_de_entrega < '$currentDate'
        ORDER BY t_reserva.horario_de_entrega ASC";
$result = mysqli_query($conexao, $sql);

function gerarRelatorioPDF($dados) {
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');

    $pdf->SetCreator('Seu Nome');
    $pdf->SetAuthor('Seu Nome');
    $pdf->SetTitle('Relatório de Consulta');
    $pdf->SetSubject('Relatório de Consulta');

    $pdf->AddPage();

    $pdf->SetFont('helvetica', '', 12);

    $pdf->Cell(45, 10, 'Laboratório', 1, 0, 'C');
    $pdf->Cell(45, 10, 'Usuário', 1, 0, 'C');
    $pdf->Cell(45, 10, 'Reserva', 1, 0, 'C');
    $pdf->Cell(45, 10, 'Entrega', 1, 1, 'C');

    foreach ($dados as $row) {
        $pdf->Cell(45, 10, $row['nome'], 1, 0, 'C');
        $pdf->Cell(45, 10, $row['nome'], 1, 0, 'C');
        $pdf->Cell(45, 10, $row['horario_de_reserva'], 1, 0, 'C');
        $pdf->Cell(45, 10, $row['horario_de_entrega'], 1, 1, 'C');
    }

    $pdf->Output('relatorio_de_reservas.pdf', 'D');
}

if (isset($_POST['download_pdf'])) {
    gerarRelatorioPDF(mysqli_fetch_all($result, MYSQLI_ASSOC));
}
?>