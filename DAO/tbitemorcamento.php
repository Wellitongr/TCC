<?php
require_once 'func_conexao_banco.php';
session_start();

class TBItemorcamento
{
    private $conexao;

    public function __construct()
    {
        $this->conexao = ConexaoBanco::IniciarConexao();
    }

    public function GravaItemOrcamento($dado)
    {
        foreach ($dado as $dados) {
            $id_orcamento   = isset($dados['id_orcamento'])     ? addslashes($dados['id_orcamento'])     : '';
            $id_produto     = isset($dados['id_produto'])       ? addslashes($dados['id_produto'])       : '';
            $descricao      = isset($dados['descricao'])        ? addslashes($dados['descricao'])        : '';
            $marca          = isset($dados['marca'])            ? addslashes($dados['marca'])            : '';
            $modelo         = isset($dados['modelo'])           ? addslashes($dados['modelo'])           : '';
            $cor            = isset($dados['cor'])              ? addslashes($dados['cor'])              : '';
            $quantidade     = isset($dados['quantidade'])       ? addslashes($dados['quantidade'])       : '';
            $valor_unitario = isset($dados['valor_unitario'])   ? addslashes($dados['valor_unitario'])   : '';
            $valor_total    = isset($dados['valor_total'])      ? addslashes($dados['valor_total'])      : '';
            $tipo           = isset($dados['tipo'])             ? addslashes($dados['tipo'])             : '';

            if ($tipo == "P") {
                try {

                    $sql = $this->conexao->prepare("INSERT INTO db_tcc.tbitemorcamento(id_orcamento, id_produto, descricao, marca, 
                                                                            modelo, cor, quantidade, 
                                                                            valor_unitario, valor_total, tipo)
                                            VALUES ($id_orcamento, $id_produto, '$descricao', '$marca', '$modelo', '$cor', 
                                                    $quantidade, $valor_unitario, $valor_total, '$tipo')");

                    $dado = $sql->execute();
                } catch (\Throwable $th) {
                    echo 'erro ' . $th->getMessage();
                }
            } else {
                try {

                    $sql = $this->conexao->prepare("INSERT INTO db_tcc.tbitemorcamento(id_orcamento, id_produto, descricao, marca, 
                                                                            modelo, cor, quantidade, 
                                                                            valor_unitario, valor_total, tipo)
                                            VALUES ($id_orcamento, '$id_produto', '$descricao', '', '', '', 
                                                    '', '', $valor_total, '$tipo')");

                    $dado = $sql->execute();
                } catch (\Throwable $th) {
                    echo 'erro ' . $th->getMessage();
                }
            }
        }
    }
}
