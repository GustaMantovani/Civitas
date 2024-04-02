<?php

    // Inserção no banco de dados

    function cadastrarObra($conexao, $nome, $autor, $tipoobra, $genero){
        $insertObra = "INSERT INTO produtocultural "
            . "(titulo, autor, descricao, capa, idTipo, idGenero, sugestao) VALUES "
            . "('$nome', '$autor', '', '', '$tipoobra', '$genero', 0 )";

        mysqli_query($conexao,$insertObra) or die ( mysqli_error($conexao) );
        $idProduto = mysqli_insert_id($conexao); //Retorna o id do produto cadastrado

        require_once 'livrosDAO.php'; //Se o tipo do produto for 1 (Livro), seu ID é inserido na tabela livro
        if ($tipoobra==1){
            cadLivro($conexao, $idProduto); //Função que cadastra o ID na tabela 'livro'
        }

        $resposta = ("Sugestão cadastrada.");

        return $resposta; 
    }


    function cadObrasAdm($conexao, $nome, $autor, $descricao, $tipoobra, $genero, $imgCapa){

        $tamanhoImg = $imgCapa["size"]; 
        $arqAberto = fopen ( $imgCapa["tmp_name"], "r" );
        $capaBin = addslashes( fread ( $arqAberto , $tamanhoImg ) );

        $insertObra = "INSERT INTO produtocultural "
            . "(titulo, descricao, autor, idTipo, idGenero, capa, sugestao) VALUES "
            . "('$nome', '$descricao', '$autor', '$tipoobra', '$genero', '$capaBin', 1 )";

        mysqli_query($conexao,$insertObra) or die ( mysqli_error($conexao) );
        $idProduto = mysqli_insert_id($conexao); 

        require_once 'livrosDAO.php'; 
        if ($tipoobra==1){
            cadLivro($conexao, $idProduto); 
        }

        $resposta = ("Sugestão cadastrada.");

        return $resposta; 
    }

    function exibirObrasSugeridas ($conexao){
        $sql = "SELECT * FROM produtocultural WHERE "
            . "sugestao = 0";

        $resultado = mysqli_query($conexao,$sql ) or die ( mysqli_error($conexao) );
        return $resultado;
        
    }

    function exibirObrasAprovadas ($conexao){
        $sql = "SELECT * FROM produtocultural WHERE "
            . "sugestao = 1";

        $resultado = mysqli_query($conexao,$sql ) or die ( mysqli_error($conexao) );
        return $resultado;
    }

    function exibirObrasAprovadasPorAdicao ($conexao){
        $sql = "SELECT * FROM produtocultural WHERE "
            . "sugestao = 1 "
            ."ORDER BY idproduto DESC";

        $resultado = mysqli_query($conexao,$sql ) or die ( mysqli_error($conexao) );
        return $resultado;
    }

    function exibirObrasAprovadasPorTipo ($conexao, $idTipo){
        $sql = "SELECT * FROM produtocultural WHERE "
            . "sugestao = 1 AND idTipo=$idTipo "
            ."ORDER BY idproduto DESC";

        $resultado = mysqli_query($conexao,$sql ) or die ( mysqli_error($conexao) );
        return $resultado;
    }

    function pesquisarObras ($conexao, $txtPesq){
        $sql = "SELECT * FROM produtocultural WHERE "
            . "titulo LIKE '$txtPesq%' AND sugestao = 1 ";

        $sql = $sql . "ORDER BY titulo";
        
        $resultado = mysqli_query($conexao,$sql ) or die ( mysqli_error($conexao) );
        return $resultado;
    }

    function excluirObras($conexao, $tipo, $id) {
        if ($tipo == 1){
            require_once 'interesseDAO.php';
            require_once 'livrosDAO.php'; 

            excluirProdutoInteresse ($conexao, $id);
            excluirLivros($conexao, $id); 
        }

        require_once 'publicacaoDAO.php';
        excluirPubliPorIDProduto($conexao, $id);

        $deleteProduto = "DELETE FROM produtocultural WHERE idProduto = $id";
        mysqli_query($conexao,$deleteProduto ) or die ( mysqli_error($conexao) );
    }

    function alterarObras($conexao, $id, $nome, $autor, $descricao, $tipoOriginal, $tipoobra, $genero, $capa){

        $tamanhoImg = $capa["size"]; 
        $arqAberto = fopen ( $capa["tmp_name"], "r" );
        $capaBin = addslashes( fread ( $arqAberto , $tamanhoImg ) );

        $update = "UPDATE produtocultural SET titulo='$nome', autor='$autor', descricao='$descricao', idTipo=$tipoobra, idGenero=$genero, capa='$capaBin', sugestao=1 WHERE idproduto=$id";

        mysqli_query($conexao,$update) or die ( mysqli_error($conexao) );
        require_once 'livrosDAO.php';
        require_once 'interesseDAO.php';
        if ($tipoobra==1 && $tipoobra!=$tipoOriginal){
            cadLivro ($conexao, $id);
             
        }
        elseif($tipoobra!=1){
            excluirProdutoInteresse ($conexao, $id);
            excluirLivros($conexao, $id);
        }
    }

    function alterarObrasSemImg($conexao, $id, $nome, $autor, $descricao, $tipoOriginal, $tipoobra, $genero){

        $update = "UPDATE produtocultural SET titulo='$nome', autor='$autor', descricao='$descricao', idTipo=$tipoobra, idGenero=$genero, sugestao=1 WHERE idproduto=$id";

        mysqli_query($conexao,$update) or die ( mysqli_error($conexao) );
        require_once 'livrosDAO.php';
        require_once 'interesseDAO.php';
        if ($tipoobra==1 && $tipoobra!=$tipoOriginal){
            cadLivro ($conexao, $id);
             
        }
        elseif($tipoobra!=1){
            excluirProdutoInteresse ($conexao, $id);
            excluirLivros($conexao, $id);
        }
    }

    function pesquisarObraPorID($conexao, $id) {
        $sql = "SELECT * FROM produtocultural WHERE idproduto = $id";
                        
        $resultado = mysqli_query($conexao,$sql ) or die ( mysqli_error($conexao) );
        return $resultado;
        
    }

    function calcularMediaAvalObra ($conexao, $idproduto){
        require_once "../modelo/publicacaoDAO.php";
        $acessoAval = pesquisarPublicacaoPorIDProduto ($conexao, $idproduto);


        $somaAval = 0;
        $contAval = 0;

        while ($registroAval = mysqli_fetch_assoc($acessoAval)){
            $somaAval += $registroAval["avaliacao"];
            $contAval++;
        }

        if ($contAval>0){
            $mediaObra = $somaAval/$contAval;
        }
        elseif($contAval==0){
            $mediaObra = -1;
        }
        else{
            $mediaObra = 0;
        }
        return $mediaObra;
    }

?>