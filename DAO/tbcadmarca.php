<?php
require_once 'func_conexao_banco.php';

class TBCadMarca
{
    private $conexao;

    public function __construct()
    {
        $this->conexao = ConexaoBanco::IniciarConexao();
    }

    public function CadastroMarca($dado)
    {

        $nome_marca  = addslashes($dado['nome_marca'])  ? addslashes($dado['nome_marca'])  : null;
        $fornecedor  = addslashes($dado['fornecedor'])  ? addslashes($dado['fornecedor'])  : null;
        $descricao   = addslashes($dado['desc'])        ? addslashes($dado['desc'])        : null;
        $observacao  = addslashes($dado['obs'])         ? addslashes($dado['obs'])         : null;

        try {

            $sql = $this->conexao->prepare("INSERT INTO tbcadmarca (nome, fornecedor, descricao, observacao)
                                                   VALUES ('$nome_marca', '$fornecedor', '$descricao', '$observacao')");

            $dado = $sql->execute();

            if ($dado == '1') {
                return true;
            } else {
                return false;
            }

            return $dado;
        } catch (\Throwable $th) {
            echo 'erro ' . $th->getMessage();
        }
    }

    public function BuscaMarca()
    {

        try {

            $sql = $this->conexao->prepare("SELECT * FROM tbcadmarca");
            $sql->execute();
            $dado = $sql->fetchAll();
            return $dado;
        } catch (\Throwable $th) {
            echo 'erro ' . $th->getMessage();
        }
    }

    public function BuscaMarcaPreencheCampo($dado)
    {

        try {

            $sql = $this->conexao->prepare("SELECT * FROM tbcadmarca WHERE fornecedor = '$dado' ");
            $sql->execute();
            $dado = $sql->fetchAll();
            return $dado;
        } catch (\Throwable $th) {
            echo 'erro ' . $th->getMessage();
        }
    }
}
