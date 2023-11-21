<?php
$conteudo_pesquisa = null;
$status_lancamento = null;
$qtd_consulta_financeiro = 0;
$alert = null;
$alert_success = null;


// /*iniciando variavel */
$data_vencimento = null;
$data_pagamento = null;
$status = null;
$forma_pg = null;
$descricao = null;
$valor = null;
$parceiro = null;
$title = null;

if (isset($_POST['pesquisa_conteudo_rlt'])) {
    $conteudo_pesquisa = $_POST['pesquisa_conteudo_rlt'];
    $data_inicial = $_POST['data_inicial'];
    $data_final = $_POST['data_final'];
    $ordem = $_POST['ordem'];
    if (isset($_POST['consultar_a_receber'])) {
        $acao = 'consultar_a_receber';
        $title = "Contas a Receber";
    } elseif (isset($_POST['consultar_a_pagar'])) {
        $acao = 'consultar_a_pagar';
        $title = "Contas a Pagar";
    } elseif (isset($_POST['consultar_recebidas'])) {
        $acao = 'consultar_recebidas';
        $title = "Contas Recebidas";
    } elseif (isset($_POST['consultar_pagas'])) {
        $acao = 'consultar_pagas';
        $title = "Contas Pagas";
    }
    if ($acao == 'consultar_a_receber') {
        $select = "SELECT   DATEDIFF(CURRENT_DATE(),fn.data_vencimento) as atraso,fn.doc, fn.id_fin, fn.descricao, stf.nome as statusf,
        fn.data_operacao,fn.data_vencimento,fn.data_pagamento,fn.valor,clt.nome as parceiro,fn.id_cliente,fpg.id_pg ,
        fpg.nome_pg, stf.tipo_operacao from financeiro as fn
         inner join clientes as clt on clt.id_cliente = fn.id_cliente 
         inner join forma_pg as fpg on fpg.id_pg = fn.id_pg 
         inner join status_financeiro as stf on stf.id_status = fn.id_status 
        where  fn.data_vencimento between '$data_inicial' and '$data_final' and fn.id_status = '1'
        and (fn.descricao  like '%$conteudo_pesquisa%' or clt.nome like '%$conteudo_pesquisa%' ) ";

        if ($ordem == 1) {
            $select .= "  order by fn.id_cliente  asc ";
        } elseif ($ordem == 2) {
            $select .= "  order by fn.id_pg asc ";
        } elseif ($ordem == 3) {
            $select .= "  order by fn.data_vencimento asc ";
        } else {
            $select .= " order by fn.id_cliente asc ";
        }
    } elseif ($acao == 'consultar_a_pagar') {

        $select = "SELECT   DATEDIFF(CURRENT_DATE(),fn.data_vencimento) as atraso,fn.doc, fn.id_fin, fn.descricao, stf.nome as statusf,
        fn.data_operacao,fn.data_vencimento,fn.data_pagamento,fn.valor,clt.nome as parceiro,fn.id_cliente,fpg.id_pg ,
        fpg.nome_pg, stf.tipo_operacao from financeiro as fn
         inner join clientes as clt on clt.id_cliente = fn.id_cliente 
         inner join forma_pg as fpg on fpg.id_pg = fn.id_pg 
         inner join status_financeiro as stf on stf.id_status = fn.id_status 
        where  fn.data_vencimento between '$data_inicial' and '$data_final' and fn.id_status = '3'
        and (fn.descricao  like '%$conteudo_pesquisa%' or clt.nome like '%$conteudo_pesquisa%' ) ";

        if ($ordem == 1) {
            $select .= "  order by fn.id_cliente  asc ";
        } elseif ($ordem == 2) {
            $select .= "  order by fn.id_pg asc ";
        } elseif ($ordem == 3) {
            $select .= "  order by fn.data_vencimento asc ";
        } else {
            $select .= " order by fn.id_cliente asc ";
        }
    } elseif ($acao == 'consultar_recebidas') {

        $select = "SELECT   DATEDIFF(fn.data_pagamento,fn.data_vencimento) as atraso,fn.doc, fn.id_fin, fn.descricao, stf.nome as statusf,
        fn.data_operacao,fn.data_vencimento,fn.data_pagamento,fn.valor,clt.nome as parceiro,fn.id_cliente,fpg.id_pg ,
        fpg.nome_pg, stf.tipo_operacao from financeiro as fn
         inner join clientes as clt on clt.id_cliente = fn.id_cliente 
         inner join forma_pg as fpg on fpg.id_pg = fn.id_pg 
         inner join status_financeiro as stf on stf.id_status = fn.id_status 
        where  fn.data_vencimento between '$data_inicial' and '$data_final' and fn.id_status = '2'
        and (fn.descricao  like '%$conteudo_pesquisa%' or clt.nome like '%$conteudo_pesquisa%' ) ";

        if ($ordem == 1) {
            $select .= "  order by fn.id_cliente  asc ";
        } elseif ($ordem == 2) {
            $select .= "  order by fn.id_pg asc ";
        } elseif ($ordem == 3) {
            $select .= "  order by fn.data_vencimento asc ";
        } else {
            $select .= " order by fn.id_cliente asc ";
        }
    } elseif ($acao == 'consultar_pagas') {
        $select = "SELECT   DATEDIFF(fn.data_pagamento,fn.data_vencimento) as atraso,fn.doc, fn.id_fin, fn.descricao, stf.nome as statusf,
        fn.data_operacao,fn.data_vencimento,fn.data_pagamento,fn.valor,clt.nome as parceiro,fn.id_cliente,fpg.id_pg ,
        fpg.nome_pg, stf.tipo_operacao from financeiro as fn
         inner join clientes as clt on clt.id_cliente = fn.id_cliente 
         inner join forma_pg as fpg on fpg.id_pg = fn.id_pg 
         inner join status_financeiro as stf on stf.id_status = fn.id_status 
        where  fn.data_vencimento between '$data_inicial' and '$data_final' and fn.id_status = '4'
        and (fn.descricao  like '%$conteudo_pesquisa%' or clt.nome like '%$conteudo_pesquisa%' ) ";

        if ($ordem == 1) {
            $select .= "  order by fn.id_cliente  asc ";
        } elseif ($ordem == 2) {
            $select .= "  order by fn.id_pg asc ";
        } elseif ($ordem == 3) {
            $select .= "  order by fn.data_vencimento asc ";
        } else {
            $select .= " order by fn.id_cliente asc ";
        }
    }
    $consulta_relatorio = mysqli_query($conecta, $select);
    if (!$consulta_relatorio) {
        die("Erro na consulta: " . mysqli_error($conecta));
    }
    $qtd_consulta = mysqli_num_rows($consulta_relatorio);
} else {
    $ordem = 1;
    $select = "SELECT   DATEDIFF(fn.data_pagamento,fn.data_vencimento) as atraso,fn.doc, fn.id_fin, fn.descricao, stf.nome as statusf,
    fn.data_operacao,fn.data_vencimento,fn.data_pagamento,fn.valor,clt.nome as parceiro,fn.id_cliente,fpg.id_pg ,
    fpg.nome_pg, stf.tipo_operacao from financeiro as fn
     inner join clientes as clt on clt.id_cliente = fn.id_cliente 
     inner join forma_pg as fpg on fpg.id_pg = fn.id_pg 
     inner join status_financeiro as stf on stf.id_status = fn.id_status 
    where  fn.data_vencimento between '$data_inicial' and '$data_final' and fn.id_status = '1'";

    $consulta_relatorio = mysqli_query($conecta, $select);
    if (!$consulta_relatorio) {
        die("Erro na consulta: " . mysqli_error($conecta));
    }
    $qtd_consulta = mysqli_num_rows($consulta_relatorio);
}

if (isset($_POST['pesquisa_conteudo'])) { //pesquisar
    $conteudo_pesquisa = $_POST['pesquisa_conteudo'];
    $status_lancamento = $_POST['status_lancamento'];
    $data_inicial = $_POST['data_inicial'];
    $data_final = $_POST['data_final'];
    $tipo_lancamento = $_POST['tipo_lancamento'];
    $select = "SELECT fn.id_fin, fn.descricao, stf.nome as statusf,
    fn.data_operacao,fn.data_vencimento,fn.data_pagamento,fn.valor,clt.nome as parceiro,
    fpg.nome_pg,stf.tipo_operacao  from financeiro as fn
     inner join clientes as clt on clt.id_cliente = fn.id_cliente 
     inner join forma_pg as fpg on fpg.id_pg = fn.id_pg 
     inner join status_financeiro as stf on stf.id_status = fn.id_status 
    where  fn.data_vencimento between '$data_inicial' and '$data_final' 
    and (fn.descricao  like '%$conteudo_pesquisa%' or clt.nome like '%$conteudo_pesquisa%' ) ";
    if ($status_lancamento != "0") {
        $select .= " and fn.id_status ='$status_lancamento'";
    }
    if ($tipo_lancamento != "0") {
        $select .= " and stf.tipo_operacao ='$tipo_lancamento'";
    }
    $select .= " order by fn.data_vencimento asc";
    $consulta_financeiro = mysqli_query($conecta, $select);
    if ($consulta_financeiro) { //verifica se ocorreu tudo ok
        $qtd_consulta_financeiro = mysqli_num_rows($consulta_financeiro);
    } else {
        die("erro na consulta:" . mysqli_error($conecta));
    }
} else {
    $select = "SELECT fn.id_fin, fn.descricao, stf.nome as statusf,
    fn.data_operacao,fn.data_vencimento,fn.data_pagamento,fn.valor,clt.nome as parceiro,
    fpg.nome_pg,stf.tipo_operacao  from financeiro as fn
     inner join clientes as clt on clt.id_cliente = fn.id_cliente 
     inner join forma_pg as fpg on fpg.id_pg = fn.id_pg 
     inner join status_financeiro as stf on stf.id_status = fn.id_status where fn.data_vencimento between '$data_inicial' and '$data_final' ";
    $consulta_financeiro = mysqli_query($conecta, $select);
    if ($consulta_financeiro) { //verifica se ocorreu tudo ok
        $qtd_consulta_financeiro = mysqli_num_rows($consulta_financeiro);
    } else {
        die("erro na consulta:" . mysqli_error($conecta));
    }
}



// /*acao de cadastro*/
if (isset($_GET['addlcf'])) {
    $acao = "Incluir";
}

/*acao de editar*/
if (isset($_GET['editlcf'])) {
    $acao = "Alterar";
    $codigo = $_GET['codigo'];

    $resultado_tb = consulta_linhas_tb_filtro($conecta, 'financeiro', "id_fin", $codigo); //consultar  tabela do usuario
    if ($resultado_tb) {
        foreach ($resultado_tb as $linha) { //trazer as informações das colunas

            $data_movimento = ($linha['data_operacao']);
            $data_pagamento = ($linha['data_pagamento']);
            $data_vencimento = ($linha['data_vencimento']);
            $descricao = $linha['descricao'];
            $forma_pg = $linha['id_pg'];
            $parceiro = ($linha['id_cliente']);
            $valor = ($linha['valor']);
            $status = ($linha['id_status']);
        }
    }
}

if (isset($_POST['form_lancamento'])) {

    foreach ($_POST as $name => $value) { //define os valores das variaveis e os nomes com refencia do name do input no formulario
        ${$name} = ($value);
    }

    if ($acao == 'Incluir') { //Incluir 
        if ($data_vencimento == "") {
            $alert = msg_alert_required("data vencimento");
        } elseif ($status == "0") {
            $alert = msg_alert_required("status");
        } elseif ($forma_pg == "0") {
            $alert = msg_alert_required("forma pagamento");
        } elseif ($valor == "") {
            $alert = msg_alert_required("valor");
        } elseif ($parceiro == "0") {
            $alert = msg_alert_required("parceiro");
        } elseif ($data_pagamento == "" and ($status == '2' or $status == "4")) {
            $alert = msg_alert_required("data pagamento");
        } else {

            $operacao_insert = inserir_lancamento($conecta, $parceiro, $data_movimento, $data_vencimento, $data_pagamento, $status, $forma_pg, $descricao, $valor, "", "lcf");

            if ($operacao_insert) {
                $alert_success = "Lançamento incluido com sucesso";
                foreach ($_POST as $name => $value) { //redefinir os valores
                    ${$name} = "";
                }

                $acao_log = ("Usuário $usuario_logado inclui um novo lançamento $status no valor $valor");
                registrar_log($conecta, $usuario_logado, $acao_log);

                /*resetar input*/
            } else {
                die(mysqli_error($conecta));
                $acao_log = ("Erro ao realizar a inclusão de um lançamento");
                registrar_log($conecta, $usuario_logado, $acao_log);
            }
        }
    } else { //editar 

        if ($data_vencimento == "") {
            $alert = msg_alert_required("data vencimento");
        } elseif ($status == "0") {
            $alert = msg_alert_required("status");
        } elseif ($forma_pg == "0") {
            $alert = msg_alert_required("forma pagamento");
        } elseif ($valor == "") {
            $alert = msg_alert_required("valor");
        } elseif ($parceiro == "0") {
            $alert = msg_alert_required("parceiro");
        } elseif ($data_pagamento == "" and ($status == '2' or $status == "4")) {
            $alert = msg_alert_required("data pagamento");
        } else {
            $update = "UPDATE `financeiro` SET `id_cliente` = '$parceiro', `valor` = '$valor',
             `descricao` = '$descricao', `data_vencimento` = '$data_vencimento', `data_pagamento` = '$data_pagamento', 
             `id_status` = '$status',`id_pg` = '$forma_pg' WHERE 
            `id_fin` = $codigo ";
            $operacao_update = mysqli_query($conecta, $update);
            if ($operacao_update) {

                $alert_success = "Lançamento alterado com sucesso";
                $acao_log = ("Usuário $usuario_logado alterou o lançamento $codigo ");
                registrar_log($conecta, $usuario_logado, $acao_log);
            } else {
                die(mysqli_error($conecta));
                $acao_log = ("Erro, ao realizar uma alteração no lançamento $codigo");
                registrar_log($conecta, $usuario_logado, $acao_log);
            }
        }
    }
}
