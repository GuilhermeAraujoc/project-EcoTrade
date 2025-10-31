<?php
session_start();
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['tipo_usuario'] !== 'admin') {
    header('Location: Login.php');
    exit();
}
$htmlArquivo = "../View/ListaCarbono.html";
$htmlStr = file_get_contents($htmlArquivo);
echo $htmlStr;
