<?php
require_once 'func_conexao_banco.php';

class TBCadCor
{
    private $conexao;

    public function __construct()
    {
        $this->conexao = ConexaoBanco::IniciarConexao();
    }

    public function CadastroCor($dado)
    {

        $cor         = addslashes($dado['cor'])         ? addslashes($dado['cor'])         : null;
        $observacao  = addslashes($dado['observacao'])  ? addslashes($dado['observacao'])  : null;

        try {

            $sql = $this->conexao->prepare("INSERT INTO tbcadcor (descricao, observacao)
                                                   VALUES ('$cor', '$observacao')");

            $dado = $sql->execute();

            if ($dado == "1") {

                return true;
            } else {

                return false;
            }
        } catch (\Throwable $th) {
            echo 'erro ' . $th->getMessage();
        }
    }
    public function BuscaCor()
    {
        try {

            $sql = $this->conexao->prepare("SELECT * FROM tbcadcor");

            $sql->execute();
            $dado = $sql->fetchAll();
            return $dado;
        } catch (\Throwable $th) {
            echo 'erro ' . $th->getMessage();
        }
    }

    public function BuscaCorCampo($produto)
    {

        try {

            $sql = $this->conexao->prepare("SELECT a.descricao, b.quantidade, b.valor_venda 
                                            FROM tbcadcor a, tbcadproduto b
                                            WHERE b.id_produto = $produto and
                                                a.id_cor = b.cor");

            $sql->execute();
            $dado = $sql->fetchAll();

            return $dado;
        } catch (\Throwable $th) {
            echo 'erro ' . $th->getMessage();
        }
    }
}
