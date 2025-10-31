<?php
include '../Model/config/Conexao.php';
session_start();
if (isset($_SESSION['logado']) && $_SESSION['logado'] == true) {
  $htmlarquivo = "../view/CadCarbono.html";
  $htmlstr = file_get_contents($htmlarquivo);
  echo $htmlstr;
    //
}else{
    header('Location: Login.php');
    exit;
}