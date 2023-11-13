<?php
if (isset($_GET['clt'])) {
    $check = 'clt'; //defiinir o check no menu 
    $title = 'Clientes'; //defiinir o titulo
} elseif (isset($_GET['prd']) or isset($_GET['ajstest'])) {
    $check = 'prd';
    $title = 'Produtos';
} elseif (isset($_GET['user']) or isset($_GET['edituser']) or isset($_GET['adduser']) or isset($_GET['resetuser'])) {
    $check = 'user';
    $title = 'Usuários';
} elseif (isset($_GET['clt']) or isset($_GET['editclt']) or isset($_GET['addclt'])) {
    $check = 'clt';
    $title = 'Clientes';
} elseif (isset($_GET['alg']) or isset($_GET['editalg']) or isset($_GET['addalg'])) {
    $check = 'alg';
    $title = 'Alguel';
} elseif (isset($_GET['alg']) or isset($_GET['editprd']) or isset($_GET['addprd']) or isset($_GET['historprd'])) {
    $check = 'prd';
    $title = 'Histórico';
} elseif (isset($_GET['lcf']) or isset($_GET['addlcf']) or isset($_GET['editlcf'])) {
    $check = 'lcf';
    $title = 'Financeiro';
} elseif (isset($_GET['lcc']) or isset($_GET['addlcc']) or isset($_GET['editlcc']) or isset($_GET['fechlcc'])) {
    $check = 'lcc';
    $title = 'Locação';
} elseif (isset($_GET['log'])) {
    $check = 'log';
    $title = 'Log de sistema';
}elseif (isset($_GET['fpg']) or isset($_GET['addfpg']) or isset($_GET['editfpg']) ) {
    $check = 'fpg';
    $title = 'Forma Pagamento';
} else {
    $check = false;
    $title = "Inicial";
}


$user_id = $_SESSION['user_loc_fun']; //pegr o id do usuario logado
$usuario_logado = consulta_tabela($conecta, "usuarios", "cod_user", "$user_id", "nome"); //validando o nome de usuario
