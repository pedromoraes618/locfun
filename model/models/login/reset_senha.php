<?php

/*declarando variavel */
$alert = null;
$usuario = null;
$senha_atual = null;
$nova_senha = null;
$confirma_senha = null;

if ($_POST) {
    $senha_atual = ($_POST['senha_atual']);
    $nova_senha = ($_POST['nova_senha']);
    $confirma_senha = ($_POST['confirmar_senha']);
    $usuario = ($_POST['usuario']);
    if ($usuario == "" or $senha_atual == "" or $nova_senha == "" or $confirma_senha == "") {
        $alert = "Informe todos os campos";
    } elseif ($nova_senha != $confirma_senha) {
        $alert = "A confirmação da senha está diferente da nova senha";
    } else {
        $codigo_user = consulta_tabela($conecta, "usuarios", "nome", "$usuario", "cod_user"); //validando o nome de usuario
        $senha_bash = (consulta_tabela($conecta, "usuarios", "nome", "$usuario", "senha")); //coleta s senha codificada do bd

        if ($codigo_user == "") {
            $alert = "Usuario Inexitente";
        } elseif (!password_verify($senha_atual, $senha_bash)) {
            $alert = "Credenciais Incorretas";
        } else {
            $nova_senha = password_hash($nova_senha, PASSWORD_DEFAULT); //codificando senha

            $update = "UPDATE `usuarios` SET `senha` = '$nova_senha' WHERE `usuarios`.`cod_user` = $codigo_user ";
            $operacao_update = mysqli_query($conecta, $update);
            if ($operacao_update) {
                $alert_success = "Senha resetada com sucesso";
                $acao_log = ("Usuário $usuario resetou a sua senha");
                registrar_log($conecta, $usuario, $acao_log);
                header("location:?login");
            } else {
                die(mysqli_error($conecta));
                $acao_log = ("Erro, ao realizar o resete da senha");
                registrar_log($conecta, $usuario, $acao_log);
            }
        }
    }
}
