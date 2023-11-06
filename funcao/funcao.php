<?php
date_default_timezone_set('America/Fortaleza');
$data_inicial_date_time = date('Y-m-01 01:01:01');
$data_final_date_time = date('Y-m-t 23:59:59');

$data_inicial = date('Y-m-01');
$data_inicial = date('Y-m-01');
$data_final = date('Y-m-t');
$data_movimento = date('Y-m-d');
$datetime_atual = date('Y-m-d H:i:s'); // Formato: YYYY-MM-DD HH:MM:SS

//consultar qualuer tabela do bd
function consulta_tabela($conecta, $tabela, $coluna_filtro, $valor, $coluna_valor)
{
    $select = "SELECT * from $tabela where $coluna_filtro = '$valor' ";
    $consulta_tabela = mysqli_query($conecta, $select);
    $linha = mysqli_fetch_assoc($consulta_tabela);
    $valor = $linha["$coluna_valor"];
    return $valor;
}
function valida_cliente_fornecedor($conecta, $id, $cnpj, $cpf)
{
    if ($id == "") {
        $select = "SELECT * from clientes where cnpj = '$cnpj' or cpf ='$cpf' ";
        $consulta_tabela = mysqli_query($conecta, $select);
        $qtd_resultado = mysqli_num_rows($consulta_tabela);
        return $qtd_resultado;
    } else { //cliente cadastrado
        $select = "SELECT * from clientes where (cnpj = '$cnpj' or cpf ='$cpf') and id_cliente!='$id' ";
        $consulta_tabela = mysqli_query($conecta, $select);
        $qtd_resultado = mysqli_num_rows($consulta_tabela);
        return $qtd_resultado; //cliente/fornecedor já cadastado
    }
}

function msg_alert_required($valor)
{
    return "Favor, informe o campo $valor";
}
function formatDateB($value)
{
    if (($value != "") and ($value != "0000-00-00")) {
        $value = date("d/m/Y", strtotime($value));
        return $value;
    }
}

///formatar formatarTimeStamp 
function formatarTimeStamp($value)
{
    $value = date("d/m/Y H:i:s", strtotime($value));
    return $value;
}

function registrar_log($conecta, $usuario_id, $acao)
{
    $insert = "INSERT INTO `log_usuarios` (`usuario`, `acao`)
     VALUES ('$usuario_id', '$acao')";
    $operacao_insert = mysqli_query($conecta, $insert);
    return true;
}

// Consultar todas as linhas de uma tabela dinamicamente
function consulta_linhas_tb($conecta, $tabela)
{
    $select = "SELECT * from $tabela";
    $consulta_tabela = mysqli_query($conecta, $select);

    if (!$consulta_tabela) {
        die("Erro na consulta: " . mysqli_error($conecta));
    }

    $linhas = array();
    while ($linha = mysqli_fetch_assoc($consulta_tabela)) {
        $linhas[] = $linha;
    }

    return $linhas;
}


// Consultar todas as linhas de uma tabela com filtro
function consulta_linhas_tb_filtro($conecta, $tabela, $filtro, $valor_filtro)
{
    $select = "SELECT * from $tabela where $filtro = '$valor_filtro' ";
    $consulta_tabela = mysqli_query($conecta, $select);

    if (!$consulta_tabela) {
        die("Erro na consulta: " . mysqli_error($conecta));
    }

    $linhas = array();
    while ($linha = mysqli_fetch_assoc($consulta_tabela)) {
        $linhas[] = $linha;
    }

    return $linhas;
}


function identifyCpfOrCnpj($number)
{
    // Remove caracteres não numéricos
    $number = preg_replace('/[^0-9]/', '', $number);

    // Verifica se o número tem 11 dígitos (CPF)
    if (strlen($number) === 11) {
        // Validação do CPF
        if (preg_match('/(\d)\1{10}/', $number) || !preg_match('/^\d{11}$/', $number)) {
            return -1; // Número inválido
        }

        // Calcula os dígitos verificadores do CPF
        for ($i = 9, $j = 0, $sum = 0; $i > 1; $i--, $j++) {
            $sum += $number[$j] * $i;
        }
        $remainder = $sum % 11;
        if ($number[9] != ($remainder < 2 ? 0 : 11 - $remainder)) {
            return -1; // Número inválido
        }

        for ($i = 10, $j = 0, $sum = 0; $i > 2; $i--, $j++) {
            $sum += $number[$j] * $i;
        }
        $remainder = $sum % 11;
        return $number[10] == ($remainder < 2 ? 0 : 11 - $remainder) ? 0 : -1; // Retorna 0 para CPF válido, -1 para inválido
    }
    // Verifica se o número tem 14 dígitos (CNPJ)
    elseif (strlen($number) === 14) {
        // Validação do CNPJ
        $sum = 0;
        $weight = 5;
        for ($i = 0; $i < 12; $i++) {
            $sum += intval($number[$i]) * $weight;
            $weight = ($weight === 2) ? 9 : ($weight - 1);
        }
        $remainder = $sum % 11;
        if ($number[12] != ($remainder < 2 ? 0 : 11 - $remainder)) {
            return -1; // Número inválido
        }

        $sum = 0;
        $weight = 6;
        for ($i = 0; $i < 13; $i++) {
            $sum += intval($number[$i]) * $weight;
            $weight = ($weight === 2) ? 9 : ($weight - 1);
        }
        $remainder = $sum % 11;
        return $number[13] == ($remainder < 2 ? 0 : 11 - $remainder) ? 1 : -1; // Retorna 1 para CNPJ válido, -1 para inválido
    }

    // Se não tiver 11 ou 14 dígitos, não é válido
    return -1; // Número inválido
}
//formatar para moeda real
function real_format($valor)
{
    $valor  = number_format($valor, 2, ",", ".");
    return "R$ " . $valor;
}

function inserir_lancamento($conecta, $parceiro, $data_movimento, $dava_vencimento, $data_pagmento, $status, $forma_pagamento, $descricao, $valor, $operacao, $doc)
{
    $insert = "INSERT INTO `financeiro` ( `id_pg`, `id_cliente`, `valor`, `id_operacao`, `descricao`, `data_operacao`, `data_vencimento`, `data_pagamento`,
     `id_status`, `doc`) VALUES ( '$forma_pagamento', '$parceiro', '$valor', '1', '$descricao', '$data_movimento', '$dava_vencimento', '$data_pagmento', '$status', '$doc' )";
    $operacao_insert = mysqli_query($conecta, $insert);
    if ($operacao_insert) {
        return true;
    } else {
        return false;
    }
}
