<?php
$usuario = null;
$senha = null;
$alert = null;

if ($_POST) {
    $usuario = ($_POST['usuario']);
    $senha = ($_POST['senha']);
    if ($usuario == "") {
        $alert = "Informe o seu Usuário";
    } elseif ($senha == "") {
        $alert = "Informe a sua Senha";
    } else {

        $valida_usuario = consulta_tabela($conecta, "usuarios", "nome", "$usuario", "cod_user"); //validando o nome de usuario
        $senha_bash = (consulta_tabela($conecta, "usuarios", "nome", "$usuario", "senha")); //coleta s senha codificada do bd

        if ($valida_usuario == "") {
            $alert = "Usuario Incorreto";
        } elseif (!password_verify($senha, $senha_bash)) {
            $alert = "Senha incorreta";
        } else {
            $_SESSION['user_loc_fun'] = $valida_usuario; //sessao vai pegar o id do usuario
            header("location:?pg=1");
        }
    }
}
