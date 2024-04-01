<?php

    //Funções para validação de dados

    //Validar dados do cadastro de usuários
    function validarCampos($conexao, $id, $nome, $usuario, $email, $data, $cpf, $senha1, $senha2, $termo, $imgPerfil) {
        require_once '../modelo/usuariosDAO.php';

        $msgErro = "";
        
        //Nome
        if ( empty($nome) ) {
            $msgErro = $msgErro . "Informe seu nome.<BR>";
        }

        elseif (validarNome($nome)==false){
            $msgErro = $msgErro . "Nome inválido.<BR>";
        }

        //Usuário
        if ( empty($usuario) ) {
            $msgErro = $msgErro . "Crie um nome de usuário.<BR>";
        }

        else{ //Caso o campo do formulário tenha sido preenchido, a função para verificar se já um mesmo usuário cadastrado no banco de dados é executada
            $msgErro = $msgErro . verificaUsuarioTabela($conexao, $id, $usuario);
        }

        //Email
        if (empty($email)){
            $msgErro = $msgErro . "Informe seu email.<BR>";
        }

        else{//Caso o campo do formulário tenha sido preenchido, a função para verificar se já um mesmo email cadastrado no banco de dados é executa
            $msgErro = $msgErro . verificaEmailTabela($conexao, $id, $email);
        }

        //Data
        if (empty($data)){
            $msgErro = $msgErro . "Informe sua data de nascimento.<BR>";
        }

        elseif ( validarData($data) == false ) {
            $msgErro = $msgErro . "Data de nascimento inválida.<BR>";
        }

        //CPF
        if (empty ($cpf)){
            $msgErro = $msgErro . "Informe seu CPF.<BR>";

        }

        elseif ( validaCPF($cpf) == false ) {
            $msgErro = $msgErro . "CPF inválido.<BR>"; 
        }

        else { //Caso o campo do formulário tenha sido preenchido, a função para verificar se já um mesmo cpf cadastrado no banco de dados é executa
            $msgErro = $msgErro . verificaCpfTabela($conexao, $id, $cpf);
        }

        //Senha
        if ( strlen($senha1) < 6 ) {
            $msgErro = $msgErro . "A senha deve ter mais que 6 caracteres.<BR>";
        }
        if ( strcmp($senha1,$senha2) != 0 ) {
            $msgErro = $msgErro . "As senhas não conferem.<BR>";
        }

        if ($termo==0){
            $msgErro = $msgErro . "Você deve ler e concordar com os 'Termos de Uso e Serviço' para poder se cadastrar.<BR>";
        }

        if ( empty($id) && ( $imgPerfil["type"] != "image/gif" ) && //Tratando o tipo da imagem
        ( $imgPerfil["type"] != "image/jpeg" ) &&
        ( $imgPerfil["type"] != "image/pjpeg" ) &&
        ( $imgPerfil["type"] != "image/png" ) &&
        ( $imgPerfil["type"] != "image/x-png" ) &&
        ( $imgPerfil["type"] != "image/jfiif" ) &&
        ( $imgPerfil["type"] != "image/bmp" )) {
            $msgErro = $msgErro . "Formato de imagem não permitido!";
        }
        
        return $msgErro;
    }

    //Validar o CPF
    function validaCPF($cpf) {
        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }
    
        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }
    
        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    
    }
    
    //Validar a data
    function validarData($data) {
        // Separa a data onde encontrar a '/' 
        // O resultado deverá ser um vetor com três posições 
        $dtSep = explode("/", $data); 
        if ( count($dtSep) != 3 ) { 
            return false; 
        } 
        $dia = $dtSep[0]; 
        $mes = $dtSep[1]; 
        $ano = $dtSep[2]; 
        return checkdate($mes,$dia,$ano);   
    }

    function converterData ($data) {
        if ( validarData($data) ) {
            $dtSep = explode("/", $data);
            $dia = $dtSep[0];
            $mes = $dtSep[1];
            $ano = $dtSep[2];
            return "$ano-$mes-$dia";
        } else {
            return null;
        }
    }

    function converterDataBD ($data) {
        $dtSep = explode("-", $data);
        $dia = $dtSep[0];
        $mes = $dtSep[1];
        $ano = $dtSep[2];
        return "$ano/$mes/$dia";
    }

    //Verifica se o nome inserido possui ao menos um elemento do grupo alpha ('A' até 'Z' e 'a' até 'z')
    function validarNome($nome){
        $pattern = '~^[ [:alpha:] ]+$~u'; 
        return preg_match($pattern, $nome); //Retorna falso caso o nome possua caractéres inválidos
    }

    //Validar dados do cadastro de obras
    function ValidarCamposObras($nome, $autor, $tipoobra, $genero){

        $msgErro = "";
        
        //Nome da obra
        if( empty($nome) ) {
            $msgErro = $msgErro . "Insira o nome da obra.<BR>";
        }
        elseif (!validarNome($nome)) {
            $msgErro .= "Título inválido.<BR>";
        }

        //Nome do autor
        if( empty($autor) ) {
            $msgErro = $msgErro . "Insira o nome do autor/diretor da obra.<BR>";
        }
        elseif (!validarNome($nome)) {
            $msgErro .= "Nome do autor inválido.<BR>";
        }

        //Tipo da obra

        if( empty($tipoobra) ) {
            $msgErro = $msgErro . "Selecione o tipo da obra.<BR>";
        }

        //Gênero da obra

        if( empty($genero) ) {
            $msgErro = $msgErro . "Selecione o gênero da obra.<BR>";
        }
        return $msgErro;
    }

    //Função para validar o cadastro de obras do administrador (ainda não estão sendo usadas)
    function ValidarCamposObrasAdm($nome, $autor,$descricao, $tipoobra, $genero, $imgCapa, $id, $tipoAlteracao){ 

        $msgErro = "";
        
        //Nome da obra
        if( empty($nome) ) {
            $msgErro = $msgErro . "Insira o nome da obra.<BR>";
        }

        //Nome do autor
        if( empty($autor) ) {
            $msgErro = $msgErro . "Insira o nome do autor/diretor da obra.<BR>";
        }

        //Descrição da obra
        if( empty($descricao) ) {
            $msgErro = $msgErro . "Insira a descrição da obra.<BR>";
        }

        //Tipo da obra

        if( empty($tipoobra) ) {
            $msgErro = $msgErro . "Selecione o tipo da obra.<BR>";
        }

        //Gênero da obra

        if( empty($genero) ) {
            $msgErro = $msgErro . "Selecione o gênero da obra.<BR>";
        }

        //Imagem de capa
        if (($tipoAlteracao==1 || $tipoAlteracao==2) && ( $imgCapa["type"] != "image/gif" ) && //Tratando o tipo da imagem
        ( $imgCapa["type"] != "image/jpeg" ) &&
        ( $imgCapa["type"] != "image/pjpeg" ) &&
        ( $imgCapa["type"] != "image/png" ) &&
        ( $imgCapa["type"] != "image/x-png" ) &&
        ( $imgCapa["type"] != "image/jfiif" ) &&
        ( $imgCapa["type"] != "image/bmp" ) ) {
            $msgErro = $msgErro . "Formato de imagem não permitido!";
        }

        return $msgErro;
    }

    function montarAvalComem ($avaliacao){
        $avaliacaoArredondada = round($avaliacao);
        $cont=1;
        $result = null;
        while ($cont<=$avaliacaoArredondada){
            $result=$result."<img width='11px' src='img/strB.png'>";
            $cont++;
        }
        while (($avaliacaoArredondada)<=4){
            $result=$result."<img width='11px' src='img/strT.png'>";
            $avaliacaoArredondada++;
        }
        return $result;
    }

    function validarCamposLogin ($login, $senha){
        $resposta = null;
        if (empty($login)){
            $resposta = $resposta . "Digite seu nome de usuário.<BR>";
        }

        if (empty($senha)){
            $resposta = $resposta . "Digite sua senha";
        }

        return $resposta;
    }


    function buscarISBNLivroPorNome($searchString){
        $apiKey = getenv('GOOGLE_BOOKS_API_KEY'); 

        $url = "https://www.googleapis.com/books/v1/volumes?q=" . urlencode($searchString) . "&key=" . $apiKey;

        $response = file_get_contents($url);
        $data = json_decode($response, true);

        if ($data['totalItems'] > 0) {
            $isbn = $data['items'][0]['volumeInfo']['industryIdentifiers'][0]['identifier'];

            return $isbn;
        } else {
            return null;
        }
    }

    function buscarTrailerFilmePorNome($name){
        $apiKey = getenv('TMDB_API_KEY'); 
        $name = urlencode($name); 
        $apiUrl = "https://api.themoviedb.org/3/search/movie?api_key=$apiKey&query=$name";
        $response = file_get_contents($apiUrl);
        $data = json_decode($response, true);
        if(isset($data['results'])){
            $video_id = $data['results'][0]['id'];
            $details_url = "https://api.themoviedb.org/3/movie/$video_id/videos?api_key=e37e1a6ae23133c45ca60758f1cfedbd&append_to_response=videos";
            $response = file_get_contents($details_url);
            $data = json_decode($response,true);
            if(isset($data['results'])){

                //obter o indice do primeiro resultado que tenha a key para um trailer
                $resultados = $data["results"];
                $indice_trailer = null;
                foreach ($resultados as $indice => $resultado) {
                    if ($resultado["type"] === "Trailer") {
                        $indice_trailer = $indice;
                        break; 
                    }
                }
                if(isset($indice_trailer)){
                    $youtubeKey = $data['results'][$indice_trailer]['key'];
                    $link = "https://www.youtube.com/watch?v=" . $youtubeKey;
                    return $link;
                }else{
                    return null;
                }
            }else{
                return null;
            }
        }else{
            return null;
        }
    }
?>
