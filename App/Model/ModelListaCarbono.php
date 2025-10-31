<?php
require_once "config/Conexao.php";

// Consulta os créditos de carbono e o nome do produtor
$sql = "SELECT cc.id, cc.quantidade, cc.data_geracao, cc.status, p.nome_fazenda, u.nome AS nome_produtor
        FROM creditos_carbono cc
        INNER JOIN produtores p ON cc.produtor_id = p.id
        INNER JOIN usuarios u ON p.usuario_id = u.id
        ORDER BY cc.data_geracao DESC";

$result = $conexao->query($sql);

$lista = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $lista[] = $row;
    }
}

echo json_encode($lista);
exit;
?>
