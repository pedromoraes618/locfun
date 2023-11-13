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
if (isset($_GET['editlcc']) or isset($_GET['fechlcc'])) {
    if (isset($_GET['editlcc'])) {
        $acao = "Alterar";
    } else {
        $acao = 'Concluir';
    }
    $codigo = $_GET['codigo'];
    $resultado_tb = consulta_linhas_tb_filtro($conecta, 'locacao', "id_loc", $codigo); //consultar  tabela do usuario
    if ($resultado_tb) {
        foreach ($resultado_tb as $linha) { //trazer as informações das colunas
            $id_loc =  ($linha['id_loc']);
            $codigo_loc =  ($linha['codigo_loc']);
            $data_locacao = ($linha['data_loc']);
            $data_prevista = ($linha['data_prevista']);
            $data_retorno = ($linha['data_retorno']);
            $parceiro = ($linha['id_cliente']);
            $forma_pg = ($linha['id_pg']);
            $desconto = ($linha['desconto_loc']);
            $taxa = ($linha['taxa_loc']);
            $observacao =  ($linha['obs_loc']);
        }
    }
}

// /*acao de cadastro*/
if (isset($_GET['fechlcc'])) {
    $data_retorno = $datetime_atual;
    $acao = "Concluir";
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
            if ($data_retorno != "") { //definir o status da locação
                $status_loc = "FECHADO";
            } else {
                $status_loc = "ABERTO";
            }
            $valor_loc = ($valor_itens + $taxa) - $desconto; //valor total da locação
            $insert = "INSERT INTO `locacao` (`codigo_loc`, `data_loc`, `cod_user`,
             `id_cliente`, `data_prevista`, `data_retorno`, `valor_bruto_loc`,`valor_liquido_loc`, `desconto_loc`, `taxa_loc`, 
             `id_pg`, `pg_efetuado`, `status_loc`, `obs_loc`) VALUES
              ( '$codigo_loc', '$data_locacao', '$user_id', '$parceiro', '$data_prevista', '$data_retorno', '$valor_itens','$valor_loc', '$desconto', '$taxa', '$forma_pg', 
              '0', '$status_loc', '$observacao')";
            $operacao_insert = mysqli_query($conecta, $insert);
            if ($operacao_insert and atualiza_ajuste_estoque($conecta, 'SAIDA', $codigo_loc)) {
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
    } elseif ($acao == 'Alterar') { //editar 

        if ($data_prevista == "") {
            $alert = msg_alert_required("data prevista");
        } elseif ($parceiro == "0") {
            $alert = msg_alert_required("parceiro");
        } elseif ($forma_pg == "0") {
            $alert = msg_alert_required("forma pagamento");
        } elseif ($valor_itens == 0) {
            $alert = "Para incluir a locação, é necessario incluir os produtos";
        } else {
            if ($data_retorno != "") { //definir o status da locação
                $status_loc = "FECHADO";
            } else {
                $status_loc = "ABERTO";
            }
            $valor_loc = $taxa - $desconto + $valor_itens; //valor total da locação
            $update = "UPDATE `locfun`.`locacao` SET `id_cliente` = '$parceiro', `data_prevista` = '$data_prevista', 
            `data_retorno` = '$data_retorno', `valor_bruto_loc` = '$valor_itens', `valor_liquido_loc` = '$valor_loc',
             `desconto_loc` = '$desconto', `taxa_loc` = '$taxa', `status_loc` = '$status_loc', `obs_loc` = '$observacao' WHERE `id_loc` = $id_loc";
            $operacao_update = mysqli_query($conecta, $update);
            if ($operacao_update) {
                $alert_success = "Locação alterada com sucesso";
                $acao_log = ("Usuário $usuario_logado alterou a locação $id_loc ");
                registrar_log($conecta, $usuario_logado, $acao_log);
            } else {
                die(mysqli_error($conecta));
                $acao_log = ("Erro, ao realizar uma tentativa de alterar a locação $id_loc");
                registrar_log($conecta, $usuario_logado, $acao_log);
            }
        }
    } else { //concluir locação

        $status_locacao = consulta_tabela($conecta, 'locacao', 'codigo_loc', $codigo_loc, 'status_loc'); //verificar o status da cotação
        $status_pagamento = consulta_tabela($conecta, 'locacao', 'codigo_loc', $codigo_loc, 'pg_efetuado'); //verificar o status do pagamento
        $id_cliente = consulta_tabela($conecta, 'locacao', 'codigo_loc', $codigo_loc, 'id_cliente'); //coletar o id do cliente 
        $valor_loc = consulta_tabela($conecta, 'locacao', 'codigo_loc', $codigo_loc, 'valor_liquido_loc'); //coletar o valor liquido da locação

        $valor_total_pagamento = 0;
        mysqli_begin_transaction($conecta);
        $erro = false;

        if ($data_prevista == "") {
            $alert = msg_alert_required("data prevista");
        } elseif ($data_retorno == "") {
            $alert = msg_alert_required("data retorno");
        } elseif ($status_pagamento == "1" and $status_locacao == "FECHADO") {
            $alert = "Essa locação já está fechada, não é possivel concluir essa locação";
        } else {
            $resultados = consulta_linhas_tb($conecta, 'forma_pg');
            foreach ($resultados as $linha) {
                $id = $linha['id_pg'];
                if (isset($_POST["pgt$id"])) { //verificar se foi utlizado essa forma de pagamento para o pagamento
                    $valor_pagamento = $_POST["pgt$id"]; //coletar o valor da forma de pagamento
                    if ($valor_pagamento > 0) {
                        $valor_total_pagamento += $valor_pagamento;
                        inserir_lancamento($conecta, $id_cliente, $data_movimento, $data_movimento, $data_movimento, '2', $id, 'Pagamento referente a loc', $valor_pagamento, '1', "loc"); //inserir o pagamento no financeiro
                    }
                }
            }
            $update_data = update_registro($conecta, 'locacao', 'codigo_loc', $codigo_loc, 'data_retorno', $data_retorno);
            $update_status_loc = update_registro($conecta, 'locacao', 'codigo_loc', $codigo_loc, 'status_loc', 'FECHADO');
            $update_status_fpg = update_registro($conecta, 'locacao', 'codigo_loc', $codigo_loc, 'pg_efetuado', '1');

            if ($valor_total_pagamento == $valor_loc and $update_data and $update_status_fpg and $update_status_loc and atualiza_ajuste_estoque($conecta, 'ENTRADA', $codigo_loc)) {
                mysqli_commit($conecta); // Confirma a transação se tudo ocorreu bem
                $alert_success = "Locação concluida com sucesso";
            } else {
                mysqli_rollback($conecta); // Desfaz a transação em caso de erro
                $alert = 'Valores do pagamento difere do total da locação, favor, verifique';
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
    $estoque_prd = consulta_tabela($conecta, 'produtos', 'id_prod', $prd_id, 'qtd'); //verificar o estoque do produto
    $valor = consulta_tabela($conecta, 'produtos', 'id_prod', $prd_id, 'preco');


    if ($prd_id == "0") {
        $alert = msg_alert_required("produto");
    } elseif ($qtd == 0) {
        $alert = msg_alert_required("quantidade");
    } elseif ($estoque_prd == 0) { //validar estoque
        $alert = "O propduto está sem estoque, não é possivel adicionar  a locação";
    } elseif ($valor == 0) {
        $alert = "O propduto está sem valor de venda, não é possivel adicionar a locação";
    } else {
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
