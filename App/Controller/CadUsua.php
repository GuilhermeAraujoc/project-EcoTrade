<?php
session_start();
include __DIR__ . '/../Model/config/Conexao.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    include __DIR__ . '/../Model/ModelCadUsua.php';
    exit;
}
if (!isset($_SESSION['logado']) || $_SESSION['logado'] != true) {
    $htmlArquivo = __DIR__ . '/../View/Cadastro.html';
    $htmlStr = file_get_contents($htmlArquivo);
    $htmlStr = str_replace('@cabecalho@', '', $htmlStr);
    echo $htmlStr;
    $conexao->close();
} else {
    header('Location: Dashboard.php'); 
    exit;
}