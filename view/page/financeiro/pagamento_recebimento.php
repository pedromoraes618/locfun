<div class="p-3 shadow">
    <span class="badge mb-3 text-bg-dark">Pagamentos e Recebimentos</span>
    <form action="" method="POST">

        <div class="row">
            <div class="col-md-auto  mb-2">
                <div class="input-group">
                    <span class="input-group-text">Dt. Vencimento</span>
                    <input type="date" class="form-control  " id="data_inicial" name="data_inicial" title="Data vencimento" placeholder="Data Inicial" value="<?php echo $data_inicial ?>">
                    <input type="date" class="form-control " id="data_final" name="data_final" title="Data vencimento" placeholder="Data Final" value="<?php echo $data_final; ?>">
                </div>
            </div>
            <div class="col-md-auto mb-2">
                <select name="ordem" class="form-control" id="ordem">
                    <option value="0">Ordernar Por.</option>
                    <option value="1">Cliente / Fornecedor</option>
                    <option value="2">Forma Pgt</option>
                    <option value="3">Periodo</option>

                </select>
            </div>

            <div class="col-md  mb-2">
                <div class="input-group">
                    <input type="text" class="form-control" name="pesquisa_conteudo_rlt" value="<?php echo $conteudo_pesquisa; ?>" placeholder="Pesquise pelo nome do parceiro ou pela descrição" aria-label="Recipient's username" aria-describedby="button-addon2">
                </div>
            </div>

        </div>
        <div class="row mb-2">
            <div class="col-md-auto  d-grid gap-2 d-sm-block mb-2">
                <button type="submit" class="btn btn-sm btn-dark" active name="consultar_a_receber" id="consultar_a_receber">Contas a Receber</button>
                <button type="submit" class="btn btn-sm btn-dark" name="consultar_a_pagar" id="consultar_a_pagar">Contas a Apagar</button>
                <button type="submit" class="btn btn-sm btn-dark" name="consultar_recebidas" id="consultar_recebidas">Contas Recebidas</button>
                <button type="submit" class="btn btn-sm btn-dark" name="consultar_pagas" id="consultar_pagar">Contas Pagas</button>
                <!-- <button class="btn btn-dark" id="print_relatorio" type="button">Imprimir</button> -->
            </div>
        </div>
    </form>
    <span class="badge mb-3 text-bg-info"><?= $title; ?></span>

    <div class="table-container" style="overflow: auto;">
        <table class="table  table-hover">
            <thead>
                <tr>
                    <th scope="col">Data Vencimento</th>
                    <th scope="col">Data Pagamento</th>
                    <th scope="col">Doc</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Forma pgto</th>
                    <th scope="col">Atraso</th>
                    <th scope="col">Vlr liquido</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Inicializar as variáveis
                $cliente_id_anterior = null; // Variável para rastrear o cliente anterior
                $subtotalLiquido = 0; // Subtotal para cada cliente

        
                $totalLiquido = 0;

                while ($linha = mysqli_fetch_assoc($consulta_relatorio)) {
                    $data_vencimento = $linha['data_vencimento'];
                    $data_pagamento = $linha['data_pagamento'];
                    $documento = ($linha['doc']);
                    $cliente = ($linha['parceiro']);
                    $parceiro_id = ($linha['id_cliente']);
                    $pagamento_id = ($linha['id_pg']);
                    $forma_pagamento = ($linha['nome_pg']);

                    $tipo_lancamento = ($linha['tipo_operacao']);
                    $valor_liquido = ($linha['valor']);
                    $atraso = ($linha['atraso']);
                    if ($atraso > 0) {
                        $atraso = $atraso . " Dia(s)";
                    } else {
                        $atraso = null;
                    }


                    if ($ordem == "1" or $ordem == "0") {
                        $parceiro_id = $parceiro_id;
                    } elseif ($ordem == "2") {
                        $parceiro_id = $pagamento_id;
                    } elseif ($ordem == "3") {
                        $parceiro_id = $data_vencimento;
                    }





                    // Verificar se o cliente_id atual é diferente do cliente_id anterior
                    if ($cliente_id_anterior !== $parceiro_id) {
                        // Exibir o subtotal acumulado para o cliente anterior, se houver
                        if ($cliente_id_anterior !== null) {
                ?>
                            <tr class="table-active">
                                <th scope="col" colspan="6">Sub Total</th>
                    
                                <th scope="col"><?php echo  real_format($subtotalLiquido); ?></th>

                            </tr>
                    <?php
                        }

                        // Atualizar o cliente_id anterior e redefinir o subtotal
                        $cliente_id_anterior = $parceiro_id;
             
                        $subtotalLiquido = 0;
                    }
                    // Adicionar o valor líquido da transação ao subtotal do cliente atual
      
                    $subtotalLiquido += $valor_liquido;

              
                    $totalLiquido += $valor_liquido;
                    ?>
                    <tr>
                        <td><?php echo formatDateB($data_vencimento); ?></td>
                        <td><?php echo formatDateB($data_pagamento); ?></td>
                        <td><?php echo $documento;  ?></td>
                        <td><?php echo $cliente; ?></td>
                        <td><?php echo $forma_pagamento; ?></td>
                        <td style="color: red;"><?php echo $atraso; ?></td>
                        <td><?php echo real_format($valor_liquido); ?></td>
                    </tr>
                <?php


                }
                // Exibir o subtotal final para o último cliente, se houver transações
                if ($cliente_id_anterior !== null) {
                ?>
                    <tr class="table-active">
                        <th scope="col" colspan="6">Sub Total</th>

                        <th scope="col"><?php echo  real_format($subtotalLiquido); ?></th>

                    </tr>
                <?php
                }
                ?>

            </tbody>
            <tfoot>
                <tr class="table-active">
                    <th scope="col" colspan="6">Total</th>

                    <th scope="col"><?php echo  real_format($totalLiquido); ?></th>

                </tr>
                <tr>
                    <th>Qtd Registros: <?php echo $qtd_consulta;  ?></th>
                </tr>
            </tfoot>
        
        </table>
    </div>

</div>