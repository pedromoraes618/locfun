<?php
$conteudo_pesquisa = null;
$status = null;
$qtd_operacao_select_user = 0;
$alert = null;
$alert_success = null;


/*iniciando variavel */
$usuario = null;
$senha = null;
$email = null;
$ativo = null;
$grupo = null;



if (isset($_POST['pesquisa_conteudo_user'])) { //pesquisar cliente
    $conteudo_pesquisa = $_POST['pesquisa_conteudo_user'];
    $status = $_POST['status'];
    $select = "SELECT nome,cod_user,ativo,gp.grupo as grupouser FROM usuarios  as user
     inner join grup_user as gp on gp.cod_grup = user.cod_grup  where (nome  like '%$conteudo_pesquisa%' or cod_user like '%$conteudo_pesquisa%')  ";
    if ($status != "sn") {
        $select .= " and ativo ='$status'";
    }
    $select .= " order by cod_user asc";
    $operacao_select_user = mysqli_query($conecta, $select);
    if ($operacao_select_user) { //verifica se ocorreu tudo ok
        $qtd_operacao_select_user = mysqli_num_rows($operacao_select_user);
    } else {
        die("erro na consulta:" . mysqli_error($conecta));
    }
}


/*acao de resetar senha*/
if (isset($_GET['resetuser'])) {
    $acao = "Resetar";
    $codigo = $_GET['codigo'];
}
/*acao de cadastro*/
if (isset($_GET['adduser'])) {
    $acao = "Cadastrar";
}
/*acao de editar*/
if (isset($_GET['edituser'])) {
    $acao = "Alterar";
    $codigo = $_GET['codigo'];

    $resultado_tb = consulta_linhas_tb_filtro($conecta, 'usuarios', "cod_user", $codigo); //consultar  tabela do usuario
    if ($resultado_tb) {
        foreach ($resultado_tb as $linha) { //trazer as informações das colunas
            $usuario = $linha['nome'];
            //   $senha = $linha['senha'];
            $email = $linha['email'];
            $grupo = $linha['cod_grup'];
            $ativo = $linha['ativo'];
        }
    }
}

if (isset($_POST['form_usuario'])) {
    $usuario = utf8_decode($_POST['usuario']);
    if (isset($_POST['senha'])) { //verificar se está cadastrando, a edição não irá passar a senha
        $senha = utf8_decode($_POST['senha']);
    }
    $email = $_POST['email'];
    $ativo = $_POST['ativo'];
    $grupo = $_POST['grupo'];


    if ($acao == 'Cadastrar') { //cadastrar o usuario
        $valida_usuario = consulta_linhas_tb_filtro($conecta, 'usuarios', "nome", $usuario); //verificar se já existe o mesmo usuario cadastrado

        if ($usuario == "") {
            $alert = msg_alert_required("usuário");
        } elseif ($valida_usuario == true) {
            $alert = 'Esse usuário já está cadastrado, favor, verifique';
        } elseif ($senha == "") {
            $alert = msg_alert_required("senha");
        } elseif ($grupo == "0") {
            $alert = msg_alert_required("grupo");
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) and $email != "") { //se o email for preenchido verifica se esá correeto
            $alert = "O email informado está incorreto, favor, verifique";
        } else {
            $senha = password_hash($senha, PASSWORD_DEFAULT); //codificando senha

            $insert = "INSERT INTO `usuarios` (`nome`, `senha`, `email`, `cod_grup`, `ativo`) 
VALUES ('$usuario', '$senha', '$email', '$grupo', '$ativo') ";
            $operacao_insert = mysqli_query($conecta, $insert);
            if ($operacao_insert) {
                $alert_success = "Usuário cadastrado com sucesso";

                $acao_log = ("Usuário $usuario_logado cadastrou o novo usuário $usuario");
                registrar_log($conecta, $usuario_logado, $acao_log);

                /*resetar input*/
                $usuario = '';
                $senha = '';
                $email = '';
                $ativo = '';
                $grupo = '';
            } else {
                die(mysqli_error($conecta));
                $acao_log = ("Erro, ao realizar o cadastro");
                registrar_log($conecta, $usuario_logado, $acao_log);
            }
        }
    } else { //editar o usuario

        if ($grupo == "0") {
            $alert = msg_alert_required("grupo");
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) and $email != "") { //se o email for preenchido verifica se esá correeto
            $alert = "O email informado está incorreto, favor, verifique";
        } else {
            $update = "UPDATE `usuarios` SET `email` = '$email', `cod_grup` = '$grupo', `ativo` = '$ativo' WHERE `usuarios`.`cod_user` = $codigo ";
            $operacao_update = mysqli_query($conecta, $update);
            if ($operacao_update) {

                $alert_success = "Usuário alterado com sucesso";
                $acao_log = ("Usuário $usuario_logado alterou o usuário de codigo $codigo");
                registrar_log($conecta, $usuario_logado, $acao_log);
            } else {
                die(mysqli_error($conecta));
                $acao_log = ("Erro, ao realizar o cadastro");
                registrar_log($conecta, $usuario_logado, $acao_log);
            }
        }
    }
}

if (isset($_POST['form_reset_usuario'])) {

    if ($acao == "Resetar") {
        $senha = utf8_decode($_POST['senha']);
        $confirmar_senha = utf8_decode($_POST['confirmar_senha']);

        if ($senha == "") {
            $alert = msg_alert_required("senha");
        } elseif ($confirmar_senha != $senha) {
            $alert = "A confirmação da senha não está igual a senha, favor, verifique";
        } else {
            $senha = password_hash($senha, PASSWORD_DEFAULT); //codificando senha

            $update = "UPDATE `usuarios` SET `senha` = '$senha' WHERE `usuarios`.`cod_user` = $codigo ";
            $operacao_update = mysqli_query($conecta, $update);
            if ($operacao_update) {
                $alert_success = "Senha resetada com sucesso";
                $acao_log = ("Usuário $usuario_logado resetou a senha do usuário de código $codigo");
                registrar_log($conecta, $usuario_logado, $acao_log);
                $senha = '';
                $confirmar_senha = '';
            } else {
                die(mysqli_error($conecta));
                $acao_log = ("Erro, ao realizar o resete da senha");
                registrar_log($conecta, $usuario_logado, $acao_log);
            }
        }
    }
}


// $select = "SELECT * FROM forma_pg";
// $consulta_forma_pg = mysqli_query($conecta, $select);

// $delete = "DELETE FROM produtos where id_prod = '$produto_id'";
// $operacao_delete = mysqli_query($conecta, $delete);
