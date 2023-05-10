<?php
require_once __DIR__ . '/../func_conexao_banco.php';

class TBCadProduto
{
    private $conexao;

    public function __construct()
    {
        $this->conexao = ConexaoBanco::IniciarConexao();
    }

    public function CadastroProduto($dado)
    {

        $descricao  = addslashes($dado['nome_produto'])  ? addslashes($dado['nome_produto'])  : null;
        $marca      = addslashes($dado['marca'])         ? addslashes($dado['marca'])         : null;
        $modelo     = addslashes($dado['modelo'])        ? addslashes($dado['modelo'])        : null;
        $cor        = addslashes($dado['cor'])           ? addslashes($dado['cor'])           : null;
        $medida     = addslashes($dado['medida'])        ? addslashes($dado['medida'])        : null;
        $minimo     = addslashes($dado['minimo'])        ? addslashes($dado['minimo'])        : null;
        $maximo     = addslashes($dado['maximo'])        ? addslashes($dado['maximo'])        : null;
        try {

            $sql = $this->conexao->prepare("INSERT INTO tbcadproduto (descricao, marca, modelo,
                                                                      cor, medida, qtde_minima, qtde_maxima, quantidade)
                                                   VALUES ('$descricao', '$marca', '$modelo', '$cor', '$medida', '$minimo', '$maximo', '0')");

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

    public function BuscaProdutoEntrada($modelo, $marca)
    {
        try {
            $sql = $this->conexao->prepare("SELECT * 
                                            FROM tbcadproduto 
                                            WHERE modelo = '$modelo' AND
                                                  marca = '$marca'");

            $sql->execute();
            $dado = $sql->fetchAll();
            return $dado;
        } catch (\Throwable $th) {
            echo 'erro ' . $th->getMessage();
        }
    }

    public function BuscaProdutoSaida($modelo, $marca)
    {
        try {
            $sql = $this->conexao->prepare("SELECT * 
                                            FROM tbcadproduto 
                                            WHERE modelo = '$modelo' AND
                                                  marca = '$marca' AND
                                                  quantidade <> 0");

            $sql->execute();
            $dado = $sql->fetchAll();
            return $dado;
        } catch (\Throwable $th) {
            echo 'erro ' . $th->getMessage();
        }
    }

    public function BuscaQuantidade($dado)
    {
        try {

            $sql = $this->conexao->prepare("SELECT * FROM tbcadproduto WHERE id_produto = $dado");

            $sql->execute();
            $dado = $sql->fetchAll();
            return $dado;
        } catch (\Throwable $th) {
            echo 'erro ' . $th->getMessage();
        }
    }

    public function GravaEstoque($update)
    {

        $valor_custo    = addslashes($update['custo'])          ? addslashes($update['custo'])          : null;
        $porcen_ganho   = addslashes($update['ganho'])          ? addslashes($update['ganho'])          : null;

        $qtde_entrada   = addslashes($update['qtde_entrada'])   ? addslashes($update['qtde_entrada'])   : null;
        $qtde           = addslashes($update['qtde'])           ? addslashes($update['qtde'])           : null;
        $quantidade     = $qtde_entrada + $qtde;

        $valor_venda    = addslashes($update['valorVenda'])     ? addslashes($update['valorVenda'])     : null;
        $data_entrada   = addslashes($update['data'])           ? addslashes($update['data'])           : null;
        $id_produto     = addslashes($update['produto_id'])     ? addslashes($update['produto_id'])     : null;

        try {

            $sql = $this->conexao->prepare("UPDATE tbcadproduto
                                            SET quantidade = '$quantidade', valor_custo = '$valor_custo', porcen_ganho = '$porcen_ganho', 
                                                valor_venda = '$valor_venda', data_entrada = '$data_entrada'
                                            WHERE id_produto = '$id_produto'");

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

    public function BuscaProdutoLista($produto)
    {
        try {
            $sql = $this->conexao->prepare("select a.id_produto, a.descricao produto, b.nome marca, c.descricao modelo
                                            from tbcadproduto a, tbcadmarca b, tbcadmodelo c
                                            where a.id_produto = $produto and
                                                a.marca = b.id_marca and
                                                a.modelo = c.id_modelo");

            $sql->execute();
            $dado = $sql->fetchAll();
            return $dado;
        } catch (\Throwable $th) {
            echo 'erro ' . $th->getMessage();
        }
    }

    public function BuscaQuantidadeDisponivel($produto)
    {
        try {
            $sql = $this->conexao->prepare("select a.quantidade from tbcadproduto a 
                                            where a.id_produto = $produto");

            $sql->execute();
            $dado = $sql->fetchAll();
            return $dado;
        } catch (\Throwable $th) {
            echo 'erro ' . $th->getMessage();
        }
    }
}
