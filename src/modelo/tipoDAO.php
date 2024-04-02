<?php

function comboTipo($conexao, $tipoMarcado){ //Função de acesso à tabela 'tipo'
    $selectTipo = "SELECT * FROM tipoproduto";

    
    $acesso = mysqli_query($conexao, $selectTipo) or die (mysqli_error($conexao));

    $resposta = null;
    while ($registro = mysqli_fetch_assoc($acesso)){ //Acessa cada linha da tabela
        $idTipo  = $registro["idtipoProduto"];
        $tipo  = $registro["tipo"];

        if ($idTipo==$tipoMarcado){
            $resposta=$resposta . "<OPTION selected value='$idTipo'>$tipo</OPTION>"; //Imprime o tipo acossiado ao seu ID
        }
        else{
            $resposta=$resposta . "<OPTION value='$idTipo'>$tipo</OPTION>"; 
        }

        
    }
    return $resposta;
    
}

function exibirTipo ($conexao, $tipoMarcado){
    $selectTipo = "SELECT * FROM tipoproduto";

    
    $acesso = mysqli_query($conexao, $selectTipo) or die (mysqli_error($conexao));

    $resposta = null;
    while ($registro = mysqli_fetch_assoc($acesso)){ //Acessa cada linha da tabela
        $idTipo  = $registro["idtipoProduto"];
        $tipo  = $registro["tipo"];

        if($tipoMarcado==$idTipo){
            $resposta=$resposta . "<a id='linkTipoMarcado' href='../visao/explorar.php?idTipo=$idTipo&&tipo=$tipo'>$tipo</a>"; 
        }else{
            $resposta=$resposta . "<a id='linkTipo' href='../visao/explorar.php?idTipo=$idTipo&&tipo=$tipo'>$tipo</a>";
        }
         
        
    }
    return $resposta;
}

function pesquisarTipoPorID ($conexao, $idTipo){
    $sql = "SELECT * FROM tipoproduto WHERE idtipoProduto = $idTipo";
                        
    $resultado = mysqli_query($conexao,$sql) or die ( mysqli_error($conexao) );
    return $resultado;
}


?>