<?php
$conteudo_pesquisa = null;
$status = null;
$qtd_consulta_clientes = 0;
$alert = null;
$alert_success = null;

/*iniciando variavel */
$codigo = null;
$nome = null;
$CpfCnpj = null;
$ie_estadual = null;
$telefone = null;
$cep = null;
$cidade = null;
$estado = null;
$bairro = null;
$endereco = null;
$email = null;
$status = null;
$tipo_parceiro = null;



if (isset($_POST['pesquisa_conteudo'])) { //pesquisar
    $conteudo_pesquisa = $_POST['pesquisa_conteudo'];
    $status = $_POST['status'];
    $select = "SELECT * from clientes where (nome  like '%$conteudo_pesquisa%' or cnpj like '%$conteudo_pesquisa%'  or cpf like '%$conteudo_pesquisa%')  ";
    if ($status != "sn") {
        $select .= " and ativo ='$status'";
    }
    $select .= " order by id_cliente asc";
    $consulta_clientes = mysqli_query($conecta, $select);
    if ($consulta_clientes) { //verifica se ocorreu tudo ok
        $qtd_consulta_clientes = mysqli_num_rows($consulta_clientes);
    } else {
        die("erro na consulta:" . mysqli_error($conecta));
    }
} else {
    $select = "SELECT * from clientes ";
    $consulta_clientes = mysqli_query($conecta, $select);
    if ($consulta_clientes) { //verifica se ocorreu tudo ok
        $qtd_consulta_clientes = mysqli_num_rows($consulta_clientes);
    } else {
        die("erro na consulta:" . mysqli_error($conecta));
    }
}



/*acao de cadastro*/
if (isset($_GET['addclt'])) {
    $acao = "Cadastrar";
}
/*acao de editar*/
if (isset($_GET['editclt'])) {
    $acao = "Alterar";
    $codigo = $_GET['codigo'];

    $resultado_tb = consulta_linhas_tb_filtro($conecta, 'clientes', "id_cliente", $codigo); //consultar  tabela do usuario
    if ($resultado_tb) {
        foreach ($resultado_tb as $linha) { //trazer as informações das colunas
            $nome = $linha['nome'];
            $tipo =   $linha['fisica_juridica'];
            if ($tipo == "f") {
                $CpfCnpj =   $linha['cpf'];
            } else {
                $CpfCnpj =   $linha['cnpj'];
            }

            $ie_estadual =  $linha['insc_est'];
            $telefone =  $linha['telefone'];
            $cep =  $linha['cep'];
            $cidade =   ($linha['cidade']);
            $estado =   $linha['estado'];
            $bairro =   ($linha['bairro']);
            $endereco = ($linha['logradouro']);
            $email = $linha['email'];
            $status = $linha['ativo'];
            $tipo_parceiro = $linha['tipo'];
        }
    }
}

if (isset($_POST['form_cliente'])) {

    foreach ($_POST as $name => $value) { //define os valores das variaveis e os nomes com refencia do name do input no formulario
        ${$name} = ($value);
    }

    if ($acao == 'Cadastrar') { //cadastrar 
        $valida_cliente_cpf = consulta_tabela($conecta, 'clientes', "cpf", $CpfCnpj, "id_cliente"); //verificar se já existe algun cliente com o mesmo cpf
        $valida_cliente_cnpj = consulta_tabela($conecta, 'clientes', "cnpj", $CpfCnpj, "id_cliente"); //verificar se já existe  algun cliente com o mesmo cnpj

        if ($nome == "") {
            $alert = msg_alert_required("nome");
        } elseif ($telefone == "") {
            $alert = msg_alert_required("telefone");
        } elseif ($cidade == "") {
            $alert = msg_alert_required("cidade");
        } elseif ($estado == "0") {
            $alert = msg_alert_required("estado");
        } elseif ($endereco == "") {
            $alert = msg_alert_required("endereco");
        } elseif ($status == "sn") {
            $alert = msg_alert_required("status");
        } elseif ($tipo_parceiro == "0") {
            $alert = msg_alert_required("tipo");
        } elseif (valida_cliente_fornecedor($conecta, "", $CpfCnpj, $CpfCnpj)) {
            $alert = "Cpf/Cnpj já cadastrado no sistema, favor, verifique";
        } else {
            $CpfCnpj = preg_replace('/[^0-9]/', '', $CpfCnpj); //remover caracteres
            $cep = preg_replace('/[^0-9]/', '', $cep); //remover caracteres

            if (identifyCpfOrCnpj($CpfCnpj) == "0" or identifyCpfOrCnpj($CpfCnpj) == "-1") { //funcao para verificar se o cliente é cpf ou cnpj //0-cpf 1-cnpj
                $cpf = $CpfCnpj;
                $cnpj = "";
                $tipo = "f";
            } elseif (identifyCpfOrCnpj($CpfCnpj) == "1") { //cnpj
                $cpf = "";
                $cnpj = $CpfCnpj;
                $tipo = "j";
            }


            $insert = "INSERT INTO `clientes` (`nome`, `email`, `telefone`, `cpf`, `cnpj`, `insc_est`,
             `fisica_juridica`, `cep`, `logradouro`, `bairro`, `cidade`, `estado`,`ativo`,`tipo`) VALUES
              ('$nome', '$email', '$telefone','$cpf', '$cnpj', '$ie_estadual', '$tipo',
               '$cep', '$endereco', '$bairro', '$cidade', '$estado', '$status', '$tipo_parceiro') ";
            $operacao_insert = mysqli_query($conecta, $insert);


            if ($operacao_insert) {
                $alert_success = "Cadastrado realizado com sucesso";

                $acao_log = ("Usuário $usuario_logado cadastrou o novo cliente/fornecedor $nome");
                registrar_log($conecta, $usuario_logado, $acao_log);

                /*resetar input*/
                foreach ($_POST as $name => $value) { //define os valores das variaveis e os nomes com refencia do name do input no formulario
                    ${$name} = "";
                }
            } else {
                die(mysqli_error($conecta));
                $acao_log = ("Erro, ao realizar o cadastro");
                registrar_log($conecta, $usuario_logado, $acao_log);
            }
        }
    } else { //editar 


        if ($nome == "") {
            $alert = msg_alert_required("nome");
        } elseif ($telefone == "") {
            $alert = msg_alert_required("telefone");
        } elseif ($cidade == "") {
            $alert = msg_alert_required("cidade");
        } elseif ($estado == "0") {
            $alert = msg_alert_required("estado");
        } elseif ($endereco == "") {
            $alert = msg_alert_required("endereco");
        } elseif ($status == "sn") {
            $alert = msg_alert_required("status");
        } elseif (valida_cliente_fornecedor($conecta, $codigo, $CpfCnpj, $CpfCnpj)) {
            $alert = "Cpf/Cnpj já cadastrado no sistema, favor, verifique";
        } else {
            $CpfCnpj = preg_replace('/[^0-9]/', '', $CpfCnpj); //remover caracteres
            $cep = preg_replace('/[^0-9]/', '', $cep); //remover caracteres

            if (identifyCpfOrCnpj($CpfCnpj) == "0" or identifyCpfOrCnpj($CpfCnpj) == "-1") { //funcao para verificar se o cliente é cpf ou cnpj //0-cpf 1-cnpj
                $cpf = $CpfCnpj;
                $cnpj = "";
                $tipo = "f";
            } elseif (identifyCpfOrCnpj($CpfCnpj) == "1") { //cnpj
                $cpf = "";
                $cnpj = $CpfCnpj;
                $tipo = "j";
            }


            $update = "UPDATE `clientes` SET `nome` = '$nome',
             `email` = '$email', `telefone` = '$telefone', `cpf` = '$cpf',
              `cnpj` = '$cnpj', `insc_est` = '$ie_estadual', `fisica_juridica` = '$tipo',
               `cep` = '$cep', `logradouro` = '$endereco', 
            `bairro` = '$bairro', `cidade` = '$cidade', `estado` = '$estado', `ativo` = '$status', `tipo` = '$tipo_parceiro' WHERE 
            `id_cliente` = $codigo ";
            $operacao_update = mysqli_query($conecta, $update);
            if ($operacao_update) {

                $alert_success = "Alteração realizada com sucesso";
                $acao_log = ("Usuário $usuario_logado alterou o cliente/fornecedor de código $codigo");
                registrar_log($conecta, $usuario_logado, $acao_log);
            } else {
                die(mysqli_error($conecta));
                $acao_log = ("Erro, ao realizar o cadastro de cliente/fornecedor");
                registrar_log($conecta, $usuario_logado, $acao_log);
            }
        }
    }
}
