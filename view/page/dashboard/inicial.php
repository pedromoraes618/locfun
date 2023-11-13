<div class="row  p-1">
    <div class="col-sm m-1   mb-1 ">
        <div id="card-top-1-1" class="card  border-0 Regular shadow">
            <div id="card_receita" class="card-header text-bg-dark">
                Receita
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <h5 class="card-title"><?php echo real_format($total_receitas); ?></h5>
                    </div>
                    <div class="col-4 text-center">
                        <i class="bi btn btn-outline-light bi-graph-up-arrow "></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm m-1  mb-1 ">
        <div id="card-top-1-2" class="card  border-0 Regular shadow">
            <div id="card_despesa" class="card-header text-bg-dark">
                Despesa
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <h5 class="card-title"><?php echo real_format($total_despesas); ?></h5>
                    </div>

                    <div class="col-4 text-center">
                        <i class="bi btn btn-outline-light bi-graph-down-arrow"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm m-1  mb-1 ">
        <div title="O Caixa Diário é composto pelas formas de pagamento associadas à conta financeira da Caixa, somado ao saldo inicial do período anterior e ao saldo atual" id="card-top-1-3" class="card  border-0 Regular shadow">
            <div class="card-header text-bg-dark">
                Caixa
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-8 ">
                        <h5 class="card-title"><?php echo real_format($total_caixa); ?></h5>
                    </div>
                    <div class="col-4 text-center">
                        <i class="bi bi-bag-fill btn btn-outline-light"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm m-1 mb-1 ">
        <div id="card-top-1-4" class="card  border-0 Regular shadow">
            <div class="card-header text-bg-dark">
                Alugueis
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-8  ">
                        <h5 class="card-title"><?php echo real_format($total_locacao); ?></h5>
                    </div>
                    <div class="col-4 text-center">
                        <i class="bi bi-cart-check btn btn-outline-light"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-6">
        <div id="card-top-1-1" class="card  border-0 Regular shadow">
            <div id="card_receita" class="card-header text-bg-dark">
                locações Em aberto <?php echo $qtd_consulta_locacao; ?>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table  table-hover">
                        <?php
                        if ($qtd_consulta_locacao > 0) {
                        ?>
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Dt Locação</th>
                                    <th>Dt Prevista</th>
                                    <th>Cliente</th>
                                    <th></th>
                                    <th>Valor</th>
                             

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total = 0;
                                while ($linha = mysqli_fetch_assoc($consulta_locacao)) {
                                    $codigo = ($linha['id_loc']);
                                    $data_loc = formatarTimeStamp($linha['data_loc']);
                                    $data_prevista = formatarTimeStamp($linha['data_prevista']);
                                    $cliente = ($linha['cliente']);
                                    $valor_liquido_loc = ($linha['valor_liquido_loc']);
                                    $status_loc = ($linha['status_loc']);
                                    if ($status_loc == "ABERTO") {
                                        $status = "<span class='badge text-bg-info'>Aberto</span>";
                                    } elseif ($status_loc == "FECHADO") {
                                        $status = "<span class='badge text-bg-success'>Fechado</span>";
                                    } else {
                                        $status = "<span class='badge text-bg-warning'>Aguardando Pagamento</span>";
                                    }

                                    $total += $valor_liquido_loc;

                                    // $ativo = $linha['ativo'];
                                    // if ($ativo == 1) {
                                    //     $ativo = "<span class='badge text-bg-success'>Sim</span>";
                                    // } else {
                                    //     $ativo = "<span class='badge text-bg-danger'>Não</span>";
                                    // }

                                ?>
                                    <tr>

                                        <td><?php echo $codigo; ?></td>
                                        <td><?php echo $data_loc; ?></td>
                                        <td><?php echo $data_prevista; ?></td>
                                        <td><?php echo $cliente; ?></td>
                                        <td><?php echo $status; ?></td>
                                        <td><?php echo $valor_liquido_loc; ?></td>
                                    </tr>

                                <?php
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5">Total</th>
                                    <th><?= real_format($total); ?></th>
                           
                                </tr>
                            </tfoot>
                        <?php

                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div id="card-top-1-1" class="card  border-0 Regular shadow">
            <div id="card_receita" class="card-header text-bg-dark">
                Financeiro a quitar <?php echo $qtd_consulta_financeiro; ?>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table  table-hover">
                        <?php
                        if ($qtd_consulta_financeiro > 0) {
                        ?>
                            <thead>
                                <tr>
                                    <th>Dt Vencimento</th>
                                    <th>Parceiro</th>
                                    <th>Descrição</th>
                                    <th>Status</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total = 0;
                                while ($linha = mysqli_fetch_assoc($consulta_financeiro)) {
                                    $codigo = ($linha['id_fin']);
                                    $data_pagamento = formatDateB($linha['data_pagamento']);
                                    $data_vencimento = formatDateB($linha['data_vencimento']);
                                    $tipo_operacao = ($linha['tipo_operacao']);
                                    $descricao = $linha['descricao'];
                                    $nome_pg = $linha['nome_pg'];
                                    $parceiro = ($linha['parceiro']);
                                    $valor = ($linha['valor']);
                                    $statusf = ($linha['statusf']);
                                    if ($tipo_operacao == "RECEITA") {
                                        $statusf = "<span class='text-success'>$statusf</span>";
                                        $total += $valor;
                                    } elseif ($tipo_operacao == "DESPESA") {
                                        $statusf = "<span class='text-danger'>$statusf</span>";
                                        $total -= $valor;
                                    } else {
                                        $statusf = "<span class='text-danger'>$statusf</span>";
                                    }

                                    // $ativo = $linha['ativo'];
                                    // if ($ativo == 1) {
                                    //     $ativo = "<span class='badge text-bg-success'>Sim</span>";
                                    // } else {
                                    //     $ativo = "<span class='badge text-bg-danger'>Não</span>";
                                    // }

                                ?>
                                    <tr>

                                        <td><?php echo $data_vencimento; ?></td>
                                        <td><?php echo $parceiro ?></td>
                                        <td><?php echo $descricao ?></td>
                                        <td><?php echo $statusf; ?></td>
                                        <td><?php echo real_format($valor); ?></td>
                                    </tr>

                                <?php
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4">Total</th>
                                    <th><?= real_format($total); ?></th>
                                </tr>
                            </tfoot>
                        <?php

                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <div class="img-dashboard">
    <img src="static/img/das.svg" class="img-fluid" alt="Dashboard">
</div> -->