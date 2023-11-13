<?php

$select = "SELECT 
SUM(CASE WHEN id_status = 2 THEN valor ELSE 0 END) AS totalreceitas,
SUM(CASE WHEN id_status = 4 THEN valor ELSE 0 END) AS totaldespesas
FROM financeiro ";
$consulta = mysqli_query($conecta, $select);
$linha = mysqli_fetch_assoc($consulta);
$total_receitas = $linha['totalreceitas'];
$total_despesas = $linha['totaldespesas'];
$total_caixa = $total_receitas - $total_despesas ;

$select = "SELECT sum(valor_liquido_loc) AS totalloc
FROM locacao where  status_loc ='FECHADO' ";
$consulta = mysqli_query($conecta, $select);
$linha = mysqli_fetch_assoc($consulta);
$total_locacao = $linha['totalloc'];

/*consultar locações que estão com o status aberto */
$select = "SELECT loc.*,clt.nome as cliente from locacao as loc 
inner join clientes as clt on clt.id_cliente = loc.id_cliente where loc.status_loc = 'ABERTO' ";
$consulta_locacao = mysqli_query($conecta, $select);
if ($consulta_locacao) { //verifica se ocorreu tudo ok
    $qtd_consulta_locacao = mysqli_num_rows($consulta_locacao);
} else {
    die("erro na consulta:" . mysqli_error($conecta));
}

/*consultar financeiro que estão com status a pagar e a receber*/
$select = "SELECT fn.id_fin, fn.descricao, stf.nome as statusf,
fn.data_operacao,fn.data_vencimento,fn.data_pagamento,fn.valor,clt.nome as parceiro,
fpg.nome_pg,stf.tipo_operacao  from financeiro as fn
 inner join clientes as clt on clt.id_cliente = fn.id_cliente 
 inner join forma_pg as fpg on fpg.id_pg = fn.id_pg 
 inner join status_financeiro as stf on stf.id_status = fn.id_status where fn.id_status ='1' or fn.id_status ='3' ";
$consulta_financeiro = mysqli_query($conecta, $select);
if ($consulta_financeiro) { //verifica se ocorreu tudo ok
    $qtd_consulta_financeiro = mysqli_num_rows($consulta_financeiro);
} else {
    die("erro na consulta:" . mysqli_error($conecta));
}