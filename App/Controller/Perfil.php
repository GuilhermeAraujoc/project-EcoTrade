<?php
session_start();
require_once __DIR__ . '/../Model/config/Conexao.php';
require_once __DIR__ . '/../Model/ModelPerfil.php';

class PerfilController {
    private $perfilModel;
    private $conexao;

    public function __construct($conexao) {
        $this->conexao = $conexao;
        $this->perfilModel = new PerfilModel($conexao);
    }

    public function verificarAutenticacao() {
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] != true) {
            header('Location: Home.php');
            exit;
        }
    }

    public function exibirPerfil() {
        $this->verificarAutenticacao();

        $id = $_SESSION['id_usuario'];
        $tipo = $_SESSION['tipo_usuario'];

        switch ($tipo) {
            case 'admin':
                $this->exibirPerfilAdmin($id);
                break;
            
            case 'empresa':
                $this->exibirPerfilEmpresa($id);
                break;
            
            case 'produtor':
                $this->exibirPerfilProdutor($id);
                break;
            
            default:
                header('Location: Home.php');
                exit;
        }
    }

    private function exibirPerfilAdmin($id) {
        $dados = $this->perfilModel->buscarPerfilUsuario($id);
        
        if ($dados) {
            $htmlArquivo = __DIR__ . '/../View/PerfilAdmin.html';
            $htmlStr = file_get_contents($htmlArquivo);
            
            $htmlStr = str_replace('@nome@', htmlspecialchars($dados['nome']), $htmlStr);
            $htmlStr = str_replace('@email@', htmlspecialchars($dados['email']), $htmlStr);
            $htmlStr = str_replace('@tipo_usuario@', htmlspecialchars($dados['tipo']), $htmlStr);
            $htmlStr = str_replace('@senha@', '********', $htmlStr); // Não exibir senha real
            
            echo $htmlStr;
        } else {
            echo "Erro ao carregar perfil do administrador.";
        }
    }

    private function exibirPerfilEmpresa($id) {
        $dados = $this->perfilModel->buscarPerfilEmpresa($id);
        
        if ($dados) {
            $htmlArquivo = __DIR__ . '/../View/PerfilEmpresa.html';
            $htmlStr = file_get_contents($htmlArquivo);
            
            $htmlStr = str_replace('@nome@', htmlspecialchars($dados['nome']), $htmlStr);
            $htmlStr = str_replace('@email@', htmlspecialchars($dados['email']), $htmlStr);
            $htmlStr = str_replace('@tipo_usuario@', htmlspecialchars($dados['tipo']), $htmlStr);
            $htmlStr = str_replace('@senha@', '********', $htmlStr);
            $htmlStr = str_replace('@cnpj@', htmlspecialchars($dados['cnpj'] ?? 'Não informado'), $htmlStr);
            $htmlStr = str_replace('@razao_social@', htmlspecialchars($dados['razao_social'] ?? 'Não informado'), $htmlStr);
            $htmlStr = str_replace('@setor_atuacao@', htmlspecialchars($dados['setor_atuacao'] ?? 'Não informado'), $htmlStr);
            
            echo $htmlStr;
        } else {
            echo "Erro ao carregar perfil da empresa.";
        }
    }

    private function exibirPerfilProdutor($id) {
        $dados = $this->perfilModel->buscarPerfilProdutor($id);
        
        if ($dados) {
            $htmlArquivo = __DIR__ . '/../View/PerfilProdutor.html';
            $htmlStr = file_get_contents($htmlArquivo);
            
            $htmlStr = str_replace('@nome@', htmlspecialchars($dados['nome']), $htmlStr);
            $htmlStr = str_replace('@email@', htmlspecialchars($dados['email']), $htmlStr);
            $htmlStr = str_replace('@tipo_usuario@', htmlspecialchars($dados['tipo']), $htmlStr);
            $htmlStr = str_replace('@senha@', '********', $htmlStr);
            $htmlStr = str_replace('@cpf@', htmlspecialchars($dados['cpf'] ?? 'Não informado'), $htmlStr);
            $htmlStr = str_replace('@nome_fazenda@', htmlspecialchars($dados['nome_fazenda'] ?? 'Não informado'), $htmlStr);
            $htmlStr = str_replace('@localizacao@', htmlspecialchars($dados['localizacao'] ?? 'Não informado'), $htmlStr);
           //var_dump($dados);
            echo $htmlStr;
        } else {
            echo "Erro ao carregar perfil do produtor.";
        }
    }
}

// Instanciar e executar o controller
$controller = new PerfilController($conexao);
$controller->exibirPerfil();

$conexao->close();
?>