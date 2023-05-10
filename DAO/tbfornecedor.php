<?php
require_once 'func_conexao_banco.php';

class TBCadFornecedor
{
    private $conexao;

    public function __construct()
    {
        $this->conexao = ConexaoBanco::IniciarConexao();
    }

    public function CadastroFornecedor($dado)
    {

        $razao_social   = addslashes($dado['rsocial'])       ? addslashes($dado['rsocial'])       : null;
        $fantasia       = addslashes($dado['fantasia'])      ? addslashes($dado['fantasia'])      : null;
        $cnpj           = addslashes($dado['cnpj'])          ? addslashes($dado['cnpj'])          : null;
        $ie             = addslashes($dado['ie'])            ? addslashes($dado['ie'])            : null;
        $endereco       = addslashes($dado['endereco'])      ? addslashes($dado['endereco'])      : null;
        $bairro         = addslashes($dado['bairro'])        ? addslashes($dado['bairro'])        : null;
        $cep            = addslashes($dado['cep'])           ? addslashes($dado['cep'])           : null;
        $cidade         = addslashes($dado['cidade'])        ? addslashes($dado['cidade'])        : null;
        $numero         = addslashes($dado['numero'])        ? addslashes($dado['numero'])        : null;
        $estado         = addslashes($dado['estado'])        ? addslashes($dado['estado'])        : null;
        $email          = addslashes($dado['email'])         ? addslashes($dado['email'])         : null;
        $celular        = addslashes($dado['celular'])       ? addslashes($dado['celular'])       : null;
        $telefone       = addslashes($dado['telefone'])      ? addslashes($dado['telefone'])      : null;
        $observacao     = addslashes($dado['observacao'])    ? addslashes($dado['observacao'])    : null;
        $situacao   = 'aberto';
        try {

            $sql = $this->conexao->prepare("INSERT INTO tbcadfornecedor (razao_social, nome_fantasia, cnpj, ie,
                                                                         endereco, bairro, cep, cidade, numero,
                                                                         estado, email, celular, telefone, observacao)
                                                   VALUES ('$razao_social', '$fantasia', '$cnpj', '$ie', '$endereco',   
                                                           '$bairro', '$cep', '$cidade', '$numero', '$estado', 
                                                           '$email', '$celular', '$telefone', '$observacao')");

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
}
