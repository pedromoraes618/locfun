<?php
session_start(); //startando sessao
include("conexao/conexao.php"); //conexao com o banco de dados
include("funcao/funcao.php"); //funcões php

if (isset($_SESSION['user_loc_fun'])) { //verificando se existe sessao
    $sessao = true;
} else {
    $sessao = false;
}


if (!$_GET) { // Verifica se não há parâmetros na URL (GET)
    if ($sessao) {
        include "model/models/inicial/menu.php";
        include "view/menu/inicial.php"; // Se o usuário estiver logado, inclui a tela do menu principal
    } else {
        include "model/models/login/login.php";
        include "view/login/login.php";
    }
} else {
    if ($sessao) {
        include "model/models/inicial/menu.php";
        if (isset($_GET['pg'])) { //acesasr tela menu
            include "view/menu/inicial.php";
        } elseif (isset($_GET['rspw'])) { //acessar tela para resetar senha
            include "model/models/login/reset_senha.php";
            include "view/login/reset_senha.php";
        } elseif (isset($_GET['logout'])) {
            include "logout.php";
        } else {
            include "view/menu/inicial.php";
        }
    } elseif (isset($_GET['rspw'])) { //acessar tela para resetar senha
        include "model/models/login/reset_senha.php";
        include "view/login/reset_senha.php";
    } else {
        include "model/models/login/login.php";

        include "view/login/login.php";
    }
}

// Fecha a conexão com o banco de dados
mysqli_close($conecta);
