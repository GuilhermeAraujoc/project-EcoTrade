<?php
session_start();

// Verifica se o usuário está logado e é admin
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['tipo_usuario'] !== 'admin') {
    header('Location: Login.php');
    exit();
}

// Carrega o HTML base
$htmlArquivo = "../View/ListaCarbono.html";
$htmlStr = file_get_contents($htmlArquivo);
echo $htmlStr;
?>
