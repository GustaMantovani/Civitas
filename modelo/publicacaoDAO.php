<?php
    function pesquisarPublicacaoPorIDProduto ($conexao, $id){
        $sql = "SELECT * FROM publicacao WHERE produtoCultural_idproduto = $id"
        ." ORDER BY idpublicacao DESC";
                        
        $resultado = mysqli_query($conexao,$sql ) or die ( mysqli_error($conexao) );
        return $resultado;
    }

    function cadPublicacao ($conexao, $dataPubli, $temaPubli, $comentario, $avaliacao, $idproduto, $idLogado){
        $sql = "INSERT INTO publicacao "
            . "(dataPublicacao, produtoCultural_idproduto, Usuario_idusuario, tema, comentario, avaliacao) VALUES "
            . "('$dataPubli', '$idproduto', '$idLogado', '$temaPubli', '$comentario', '$avaliacao')";

            $sql = $sql . "ORDER BY idpublicacao";

        mysqli_query($conexao,$sql) or die ( mysqli_error($conexao) );
    
        $resposta = ("Publicação cadastrada.");
        
    
        return $resposta; 
    }

    function excluirPubliPorIDProduto ($conexao, $idProduto){
        $delete = "DELETE FROM publicacao WHERE produtoCultural_idproduto = $idProduto";
        mysqli_query($conexao,$delete ) or die ( mysqli_error($conexao) );
    }

    function excluirPubliPorIDUsr ($conexao, $idUsr){
        $delete = "DELETE FROM publicacao WHERE Usuario_idusuario = $idUsr";
        mysqli_query($conexao,$delete ) or die ( mysqli_error($conexao) );
    }

    function excluirPubli($conexao, $id){
        $delete = "DELETE FROM publicacao WHERE idpublicacao = $id";
        mysqli_query($conexao,$delete ) or die ( mysqli_error($conexao) );
    }

    function pesquisarPublicacaoPorIDUsr($conexao, $idUsr){
        $sql = "SELECT * FROM publicacao WHERE Usuario_idusuario = $idUsr"
        ." ORDER BY idpublicacao DESC";
                        
        $resultado = mysqli_query($conexao,$sql ) or die ( mysqli_error($conexao) );
        return $resultado;
    }

?>