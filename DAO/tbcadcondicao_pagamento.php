<?php
require_once 'func_conexao_banco.php';

class TBCadCondicaoPagamento
{
    private $conexao;

    public function __construct()
    {
        $this->conexao = ConexaoBanco::IniciarConexao();
    }

    public function CadastroCondicaoPagamento($dado)
    {

        $descricao  = addslashes($dado['descricao'])    ? addslashes($dado['descricao'])    : null;
        $modalidade = addslashes($dado['modalidade'])   ? addslashes($dado['modalidade'])   : null;
        $parcelas   = addslashes($dado['parcelas'])     ? addslashes($dado['parcelas'])     : null;
        $juros      = addslashes($dado['juros'])        ? addslashes($dado['juros'])        : null;
        $pagamento  = addslashes($dado['forma_pagamento'])    ? addslashes($dado['forma_pagamento'])    : null;

        try {

            $sql = $this->conexao->prepare("INSERT INTO tbcadcondicao_pagamento (descricao, modalidade, parcelas, porcent_juros, forma_pagamento)
                                                   VALUES ('$descricao', '$modalidade', '$parcelas', '$juros', '$pagamento')");

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

    public function BuscaCondicaoPagamento()
    {

        try {

            $sql = $this->conexao->prepare("SELECT *
                                            FROM tbcadcondicao_pagamento");

            $sql->execute();
            $dado = $sql->fetchAll();
            return $dado;
        } catch (\Throwable $th) {
            echo 'erro ' . $th->getMessage();
        }
    }

    public function BuscaParcelas($id_forma)
    {
        try {

            $sql = $this->conexao->prepare("SELECT *
                                            FROM tbcadcondicao_pagamento 
                                            WHERE id_condicao = $id_forma");

            $sql->execute();
            $dado = $sql->fetchAll();
            return $dado;
        } catch (\Throwable $th) {
            echo 'erro ' . $th->getMessage();
        }
    }
}
