<?php
require_once 'func_conexao_banco.php';

class TBCadCliente
{
    private $conexao;

    public function __construct()
    {
        $this->conexao = ConexaoBanco::IniciarConexao();
    }

    public function CadastroCliente($dados)
    {

        $nome       = addslashes($dados['nome'])         ? addslashes($dados['nome'])        : null;
        $sobrenome  = addslashes($dados['sobrenome'])    ? addslashes($dados['sobrenome'])   : null;
        $cpf        = addslashes($dados['cpf'])          ? addslashes($dados['cpf'])         : null;
        $dtnasc     = addslashes($dados['dtnasc'])       ? addslashes($dados['dtnasc'])      : null;
        $endereco   = addslashes($dados['endereco'])     ? addslashes($dados['endereco'])    : null;
        $cep        = addslashes($dados['cep'])          ? addslashes($dados['cep'])         : null;
        $cidade     = addslashes($dados['cidade'])       ? addslashes($dados['cidade'])      : null;
        $numero     = addslashes($dados['numero'])       ? addslashes($dados['numero'])      : null;
        $estado     = addslashes($dados['estado'])       ? addslashes($dados['estado'])      : null;
        $email      = addslashes($dados['email'])        ? addslashes($dados['email'])       : null;
        $telefone   = addslashes($dados['telefone'])     ? addslashes($dados['telefone'])    : null;
        $celular    = addslashes($dados['celular'])      ? addslashes($dados['celular'])     : null;
        $bairro     = addslashes($dados['bairro'])       ? addslashes($dados['bairro'])      : null;

        try {
            $sql = $this->conexao->prepare("INSERT INTO tbcadcliente (nome_rsocial, sobrenome_fantasia, cpf_cnpj,
                                                                 ie, dt_nascimento, rua, numero, estado, cidade,
                                                                 email, telefone, celular, cep, bairro)
                                                   VALUES ('$nome', '$sobrenome', '$cpf', '', '$dtnasc',  
                                                           '$endereco', '$numero','$estado', '$cidade', 
                                                           '$email', '$telefone', '$celular', '$cep', '$bairro')");
            $dado = $sql->execute();

            if ($dado == '1') {

                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            echo 'erro ' . $th->getMessage();
        }
    }

    public function BuscaEstado()
    {
        try {
            $sql = $this->conexao->prepare("SELECT * FROM tbcadestado");
            $sql->execute();
            $dado = $sql->fetchAll();
            return $dado;
        } catch (\Throwable $th) {
            echo 'erro ' . $th->getMessage();
        }
    }

    public function BuscaCidade($estado)
    {
        try {
            $sql = $this->conexao->prepare("SELECT * FROM tbcadcidade WHERE id_estado = $estado ORDER BY nome");
            $sql->execute();
            $dado = $sql->fetchAll();
            return $dado;
        } catch (\Throwable $th) {
            echo 'erro ' . $th->getMessage();
        }
    }

    public function BuscaCliente()
    {
        try {
            $sql = $this->conexao->prepare("SELECT a.id_cliente, a.nome_rsocial, a.sobrenome_fantasia, a.cpf_cnpj 
                                            FROM tbcadcliente a");

            $sql->execute();
            $dado = $sql->fetchAll();
            return $dado;
        } catch (\Throwable $th) {
            echo 'erro ' . $th->getMessage();
        }
    }

    public function teste($cliente = NULL)
    {
        try {

            $sql = $this->conexao->prepare("SELECT a.id_cliente, a.nome_rsocial, a.sobrenome_fantasia, a.cpf_cnpj,
                                                   a.email, a.celular, a.telefone 
                                            FROM tbcadcliente a
                                            WHERE a.id_cliente = '$cliente'");

            $sql->execute();
            $dado = $sql->fetchAll();
            return $dado;
        } catch (\Throwable $th) {
            echo 'erro ' . $th->getMessage();
        }
    }
}
