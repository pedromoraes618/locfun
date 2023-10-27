<?php
$conteudo_pesquisa = null;
$status = null;
$qtd_operacao_select_user = 0;
$alert = null;
$alert_success = null;






if (isset($_POST['pesquisa_conteudo'])) {//com filtro
    $conteudo_pesquisa = $_POST['pesquisa_conteudo'];
    $data_inicial = $_POST['data_inicial'];
    $data_final = $_POST['data_final'];
    $select = "SELECT * from log_usuarios where 
    data_hora between '$data_inicial' and '$data_final' and  ( acao like '%$conteudo_pesquisa%' or 
    usuario like '%$conteudo_pesquisa%' ) order by id desc ";
    $consultar_log = mysqli_query($conecta, $select);
    if ($consultar_log) { //verifica se ocorreu tudo ok
        $qtd_consultar_log = mysqli_num_rows($consultar_log);
    } else {
        die("erro na consulta:" . mysqli_error($conecta));
    }
} else {
    $select = "SELECT * from log_usuarios order by id desc ";
    $consultar_log = mysqli_query($conecta, $select);
    if ($consultar_log) { //verifica se ocorreu tudo ok
        $qtd_consultar_log = mysqli_num_rows($consultar_log);
    } else {
        die("erro na consulta:" . mysqli_error($conecta));
    }
}
