<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (!isset($_SESSION['logado']) || $_SESSION['tipo_usuario'] !== 'admin') {
    header('Location: Login.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['credito_id']) && isset($_POST['acao'])) {
    
    include __DIR__ . '/../Model/config/Conexao.php';

    $credito_id = $_POST['credito_id'];
    $admin_id = $_SESSION['id_usuario'];
    $status = ($_POST['acao'] == 'aprovado') ? 'aprovado' : 'rejeitado';

    $stmt_update = $conexao->prepare("UPDATE creditos_carbono SET status = ? WHERE id = ?");
    $stmt_update->bind_param("si", $status, $credito_id);
    $stmt_update->execute();
    $stmt_log = $conexao->prepare("INSERT INTO validacoes (credito_id, admin_id, status) VALUES (?, ?, ?)");
    $stmt_log->bind_param("iis", $credito_id, $admin_id, $status);
    $stmt_log->execute();

    $stmt_update->close();
    $stmt_log->close();
    $conexao->close();
}
header('Location: Dashboard.php');
exit;