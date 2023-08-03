<?php
    function inserirLista ($conexao, $idUsr, $idLivro){
        $sql = "INSERT INTO interesse "
        . "(Usuario_idusuario, livro_produtoCultural_idproduto) VALUES "
        . "('$idUsr', '$idLivro')";

        mysqli_query($conexao,$sql) or die ( mysqli_error($conexao) );
    }

    function verificaIdTabela($conexao, $idLista, $idUsr){
        $sql = "SELECT * FROM interesse";
        $acesso = mysqli_query($conexao, $sql) or die (mysqli_error($conexao));

        $resposta = true;
        while ($registro = mysqli_fetch_assoc($acesso)){

    
            $idTabela = $registro["livro_produtoCultural_idproduto"];
            $idDoadorTabela = $registro["Usuario_idusuario"];

            if ($idLista == $idTabela && $idUsr == $idDoadorTabela){
                $resposta = false;
            }
        }
        return $resposta;
    }

    function excluirProdutoInteresse ($conexao, $id){
        $deleteProduto = "DELETE FROM interesse WHERE livro_produtoCultural_idproduto = $id";
        mysqli_query($conexao,$deleteProduto ) or die ( mysqli_error($conexao) );
    }


    function exibirInteressesPorIdObra ($conexao, $idLivro){
        $sql = "SELECT * FROM interesse WHERE $idLivro = livro_produtoCultural_idproduto";
        $acesso = mysqli_query($conexao, $sql) or die (mysqli_error($conexao));
        return $acesso;
    }

    function exibirInteressesPorIdUsr ($conexao, $idUsr){
        $sql = "SELECT * FROM interesse WHERE $idUsr = Usuario_idusuario";
        $acesso = mysqli_query($conexao, $sql) or die (mysqli_error($conexao));
        return $acesso;     
    }

    function excluirInteresseId ($conexao, $idInteresse){
        $delete = "DELETE FROM interesse WHERE idInteresse = $idInteresse";
        mysqli_query($conexao,$delete ) or die ( mysqli_error($conexao) );
    }

    function excluirInteresseIdUsr ($conexao, $idUsr){
        $delete = "DELETE FROM interesse WHERE Usuario_idusuario = $idUsr";
        mysqli_query($conexao,$delete ) or die ( mysqli_error($conexao) );
    }

    function pesquisaInteresse ($conexao, $idUsr, $idLivro){
        $sql = "SELECT * FROM interesse WHERE $idUsr = Usuario_idusuario AND $idLivro = livro_produtoCultural_idproduto";
        $acesso = mysqli_query($conexao, $sql) or die (mysqli_error($conexao));
        
        return $acesso;     
    }


?>