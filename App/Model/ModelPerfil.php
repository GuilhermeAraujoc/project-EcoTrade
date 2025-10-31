<?php
class PerfilModel {
    private $conexao;

    public function __construct($conexao) {
        $this->conexao = $conexao;
    }

    public function buscarPerfilUsuario($id) {
        $sql = "SELECT id, nome, email, senha, tipo FROM usuarios WHERE id = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows > 0) {
            return $resultado->fetch_assoc();
        }
        return null;
    }

    public function buscarPerfilEmpresa($usuario_id) {
        $sql = "SELECT e.id, e.usuario_id, e.cnpj, e.razao_social, e.setor_atuacao,
                       u.nome, u.email, u.senha, u.tipo
                FROM empresas e
                INNER JOIN usuarios u ON e.usuario_id = u.id
                WHERE e.usuario_id = ?";
        
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows > 0) {
            return $resultado->fetch_assoc();
        }
        return null;
    }

    public function buscarPerfilProdutor($usuario_id) {
        $sql = "SELECT p.id, p.usuario_id, p.cpf, p.nome_fazenda, p.localizacao,
                       u.nome, u.email, u.senha, u.tipo
                FROM produtores p
                INNER JOIN usuarios u ON p.usuario_id = u.id
                WHERE p.usuario_id = ?";
        
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows > 0) {
            return $resultado->fetch_assoc();
        }
        return null;
    }

    public function atualizarSenha($id, $novaSenha) {
        $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET senha = ? WHERE id = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("si", $senhaHash, $id);
        return $stmt->execute();
    }
}
?>