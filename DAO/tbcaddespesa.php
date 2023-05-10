<?php
require_once 'func_conexao_banco.php';

class TBCadDespesa
{
    private $conexao;

    public function __construct()
    {
        $this->conexao = ConexaoBanco::IniciarConexao();
    }

    public function CadastroDespesa($dado)
    {

        $descricao  = addslashes($dado['desc_despesa'])  ? addslashes($dado['desc_despesa'])  : null;
        $vencimento = addslashes($dado['vencimento'])    ? addslashes($dado['vencimento'])    : null;
        $previsao   = addslashes($dado['pag_previsto'])  ? addslashes($dado['pag_previsto'])  : null;
        $despesa    = addslashes($dado['valor_despesa']) ? addslashes($dado['valor_despesa']) : null;
        $fornecedor = addslashes($dado['fornecedor'])   ? addslashes($dado['fornecedor'])    : null;
        $observacao = addslashes($dado['observacao'])    ? addslashes($dado['observacao'])    : null;
        $situacao   = 'aberto';
        try {

            $sql = $this->conexao->prepare("INSERT INTO tbcaddespesa (descricao, dt_vencimento, dt_pg_previsto,
                                                                      valor_despesa, fornecedor, situacao, observacao)
                                                   VALUES ('$descricao', '$vencimento', '$previsao', '$despesa',  
                                                           '$fornecedor', '$situacao', '$observacao')");

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
}
