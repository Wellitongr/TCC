<?php
require_once 'func_conexao_banco.php';

class TBOrcamento
{
    private $conexao;

    public function __construct()
    {
        $this->conexao = ConexaoBanco::IniciarConexao();
    }

    public function GravaOrcamento($dado)
    {
        $data = str_replace("/", "-", $dado['validade']);
        $validade = date('Y-m-d', strtotime($data));

        $id                 = addslashes($dado['id'])                   ? addslashes($dado['id'])                   : '';
        $cliente            = addslashes($dado['cliente'])              ? addslashes($dado['cliente'])              : '';
        $data_orcamento     = addslashes($dado['data_orcamento'])       ? addslashes($dado['data_orcamento'])       : '';
        $observacao         = addslashes($dado['observacao'])           ? addslashes($dado['observacao'])           : '';
        $descricao_desconto = addslashes($dado['descricao_desconto'])   ? addslashes($dado['descricao_desconto'])   : '';
        $porcentagem        = addslashes($dado['porcentagem'])          ? addslashes($dado['porcentagem'])          : 0;
        //$validade           = addslashes($dado['validade'])             ? addslashes($dado['validade'])             : '';
        $valor_com_desconto = addslashes($dado['valor_com_desconto'])   ? addslashes($dado['valor_com_desconto'])   : '';
        $valor_sem_desconto = addslashes($dado['valor_sem_desconto'])   ? addslashes($dado['valor_sem_desconto'])   : '';
        $situacao           = 'A';

        try {

            $sql = $this->conexao->prepare("INSERT INTO db_tcc.tborcamento(id_orcamento, id_cliente, dt_orcamento, dt_validade, 
                                                                            observacao, porcent_desc, descricao, 
                                                                            valor_com_desc, valor_sem_desc, situacao)
                                            VALUES ($id, $cliente, '$data_orcamento', '$validade', '$observacao', $porcentagem, 
                                                    '$descricao_desconto', $valor_com_desconto, $valor_sem_desconto, '$situacao')");

            $dado = $sql->execute();
            return $dado;
            /*if ($dado == '1') {

                return true;
            } else {

                return false;
            }*/
        } catch (\Throwable $th) {
            echo 'erro ' . $th->getMessage();
        }
    }

    public function BuscaFornecedor()
    {
        try {

            $sql = $this->conexao->prepare("SELECT a.id_fornecedor, a.razao_social, a.nome_fantasia FROM tbcadfornecedor a");

            $sql->execute();
            $dado = $sql->fetchAll();
            return $dado;
        } catch (\Throwable $th) {
            echo 'erro ' . $th->getMessage();
        }
    }

    public function BuscaIdOrcamento()
    {
        try {

            $sql = $this->conexao->prepare("select coalesce(MAX(id_orcamento), 0) + 1 as id_orcamento from tborcamento");

            $sql->execute();
            $dado = $sql->fetchAll();
            return $dado;
        } catch (\Throwable $th) {
            echo 'erro ' . $th->getMessage();
        }
    }
}
