<?php
$conteudo_pesquisa = null;
$status_lancamento = null;
$qtd_consulta_produtos = 0;
$qtd_consulta_locacao = 0;
$alert = null;
$alert_success = null;


// /*iniciando variavel */
$codigo_loc = null;
$data_prevista = null;
$data_retorno = null;
$parceiro = null;
$forma_pg = null;
$desconto = 0;
$taxa = 0;
$qtd = null;
$prd_id = null;
$observacao = null;
$qtd = 1;



if (isset($_POST['pesquisa_conteudo'])) { //pesquisar
    $conteudo_pesquisa = $_POST['pesquisa_conteudo'];
    $data_inicial = $_POST['data_inicial'];
    $data_final = $_POST['data_final'];

    $select = "SELECT loc.*,clt.nome as cliente from locacao as loc 
    inner join clientes as clt on clt.id_cliente = loc.id_cliente 
    where loc.data_loc between '$data_inicial  01:01:01' and '$data_final 23:59:59' and clt.nome like '%$conteudo_pesquisa%' ";
    $consulta_locacao = mysqli_query($conecta, $select);
    if ($consulta_locacao) { //verifica se ocorreu tudo ok
        $qtd_consulta_locacao = mysqli_num_rows($consulta_locacao);
    } else {
        die("erro na consulta:" . mysqli_error($conecta));
    }
} else {
    $select = "SELECT loc.*,clt.nome as cliente from locacao as loc 
    inner join clientes as clt on clt.id_cliente = loc.id_cliente 
    where loc.data_loc between '$data_inicial_date_time' and '$data_final_date_time' ";
    $consulta_locacao = mysqli_query($conecta, $select);
    if ($consulta_locacao) { //verifica se ocorreu tudo ok
        $qtd_consulta_locacao = mysqli_num_rows($consulta_locacao);
    } else {
        die("erro na consulta:" . mysqli_error($conecta));
    }
}



// /*acao de cadastro*/
if (isset($_GET['addlcc'])) {
    $data_locacao = $datetime_atual;
    $acao = "Incluir";
    if (!isset($_POST['codigo_loc'])) {
        $codigo_loc = md5(uniqid(time())); //gerar um codigo aleatorio para a locação
    }
}
/*acao de editar*/
if (isset($_GET['editlcc'])) {
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

if (isset($_POST['form_locacao'])) {

    foreach ($_POST as $name => $value) { //define os valores das variaveis e os nomes com refencia do name do input no formulario
        ${$name} = ($value);
    }
    $valor_itens = consulta_tabela($conecta, 'vlr_total_itens_locacao', 'cod_locacao', $codigo_loc, 'total');

    if ($acao == 'Incluir') { //Incluir 
        if ($data_prevista == "") {
            $alert = msg_alert_required("data prevista");
        } elseif ($parceiro == "0") {
            $alert = msg_alert_required("parceiro");
        } elseif ($forma_pg == "0") {
            $alert = msg_alert_required("forma pagamento");
        } elseif ($valor_itens == 0) {
            $alert = "Para incluir a locação, é necessario incluir os produtos";
        } else {
            $valor_loc = ($valor_itens + $taxa) - $desconto; //valor total da locação
            $insert = "INSERT INTO `locacao` (`codigo_loc`, `data_loc`, `cod_user`,
             `id_cliente`, `data_prevista`, `data_retorno`, `valor_bruto_loc`,`valor_liquido_loc`, `desconto_loc`, `taxa_loc`, 
             `id_pg`, `pg_efetuado`, `status_loc`, `obs_loc`) VALUES
              ( '$codigo_loc', '$data_locacao', '$user_id', '$parceiro', '$data_prevista', '$data_retorno', '$valor_itens','$valor_loc', '$desconto', '$taxa', '$forma_pg', 
              '0', 'ABERTO', '$observacao')";
            $operacao_insert = mysqli_query($conecta, $insert);
            if ($operacao_insert) {
                $locacao_new = mysqli_insert_id($conecta);
                $alert_success = "Locação $locacao_new incluida com sucesso";
                $acao_log = ("Usuário $usuario_logado incluiu a locação $locacao_new  ");
                registrar_log($conecta, $usuario_logado, $acao_log);
                foreach ($_POST as $name => $value) { //redefinir os valores
                    ${$name} = "";
                }
                $codigo_loc = md5(uniqid(time())); //gerar um codigo aleatorio para a locação

            } else {
                die(mysqli_error($conecta));
                $acao_log = ("Erro, ao realizar uma tentativa de incluir uma locação");
                registrar_log($conecta, $usuario_logado, $acao_log);
            }
        }
    } else { //editar 

        if ($data_vencimento == "") {
            $alert = msg_alert_required("data vencimento");
        } elseif ($parceiro == "0") {
            $alert = msg_alert_required("parceiro");
        } elseif ($forma_pg == "0") {
            $alert = msg_alert_required("forma pagamento");
        } else {
            $valor_itens = consulta_tabela($conecta, 'vlr_total_itens_locacao', 'cod_locacao', $codigo_loc, 'total');
            $valor_loc = $taxa - $desconto + $valor_itens; //valor total da locação
            $insert = "INSERT INTO `locacao` (`codigo_loc`, `data_loc`, `cod_user`,
             `id_cliente`, `data_prevista`, `data_retorno`, `valor_loc`, `desconto_loc`, `taxa_loc`, 
             `id_pg`, `pg_efetuado`, `status_loc`, `obs_loc`) VALUES
              ( '$codigo_loc', '$data_locacao', '$cod', '15', '2023-11-06', '2023-11-06', '200', '2', '20', '1', '5', NULL, 'teste')";
            $operacao_insert = mysqli_query($conecta, $insert);
            if ($operacao_insert) {
                $locacao_new = mysqli_insert_id($conecta);
                $alert_success = "Locação $locacao_new incluida com sucesso";
                $acao_log = ("Usuário $usuario_logado incluiu a locação $locacao_new  ");
                registrar_log($conecta, $usuario_logado, $acao_log);
            } else {
                die(mysqli_error($conecta));
                $acao_log = ("Erro, ao realizar uma tentativa de incluir uma locação");
                registrar_log($conecta, $usuario_logado, $acao_log);
            }
        }
    }
}

if (isset($_POST['addDesconto']) or isset($_POST['addTaxa'])) {
    foreach ($_POST as $name => $value) {
        ${$name} = ($value);
    }
}

if (isset($_POST['addProduto'])) {
    foreach ($_POST as $name => $value) { //define os valores das variaveis e os nomes com referencia do name do input no formulario
        ${$name} = ($value);
    }
    if ($prd_id == "0") {
        $alert = msg_alert_required("produto");
    } elseif ($qtd == 0) {
        $alert = msg_alert_required("quantidade");
    } else {
        $valor = consulta_tabela($conecta, 'produtos', 'id_prod', $prd_id, 'preco');
        $insert = "INSERT INTO `itens_locados` 
        (`id_prod`, `cod_locacao`, `qtd`, `valor`)
         VALUES ('$prd_id', '$codigo_loc', '$qtd', $valor) ";
        $operacao_insert = mysqli_query($conecta, $insert);

        if ($operacao_insert) {
            $prd_id = 0;
            $qtd = 1;
        } else {
            die(mysqli_error($conecta));
        }
    }
}
