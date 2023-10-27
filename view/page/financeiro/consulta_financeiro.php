<div class="p-3 shadow">
    <span class="badge mb-3 text-bg-dark">Lançamento Financeiros</span>
    <form action="" method="POST">

        <div class="row">
            <div class="col-md-auto  mb-2">
                <div class="input-group">
                    <span class="input-group-text">Dt. Vencimento</span>
                    <input type="date" class="form-control  " id="data_inicial" name="data_inicial" title="Data vencimento" placeholder="Data Inicial" value="<?php echo $data_inicial ?>">
                    <input type="date" class="form-control " id="data_final" name="data_final" title="Data vencimento" placeholder="Data Final" value="<?php echo $data_final; ?>">
                </div>
            </div>
        
            <div class="col-md  mb-2">
                <div class="input-group">
                    <input type="text" class="form-control" name="pesquisa_conteudo" value="<?php echo $conteudo_pesquisa; ?>" placeholder="Pesquise pelo nome do parceiro ou pela descrição" aria-label="Recipient's username" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary" type="submit" id="pesquisar_filtro_pesquisa">Pesquisar</button>
                </div>
            </div>
            <div class="col-md-auto d-grid gap-2 d-sm-block mb-1">
                <a href="?pg&addlcf" class="btn  btn-dark">Adicionar Lançamento</a>
            </div>
        </div>
        <div class="row mb-2">
        <div class="col-md-2 mb-2">
                <select name="status_lancamento" class="form-select" id="status_lancamento">
                    <option value="0">Status..</option>
                    <?php
                    $resultados = consulta_linhas_tb($conecta, 'status_financeiro');
                    if ($resultados) {
                        foreach ($resultados as $linha) {
                            $id = $linha['id_status'];
                            $descricao = $linha['nome'];
                            $selected = ($id == $status_lancamento) ? "selected" : "";
                            echo "<option value='$id' $selected>$descricao</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-2 mb-2">
                <select name="tipo_lancamento" class="form-select" id="tipo_lancamento">
                    <option value="0">Tipo..</option>
                    <option value="RECEITA">Receita</option>
                    <option value="DESPESA">Despesa</option>

                </select>
            </div>
        </div>
    </form>
    <div class="table-container" style="overflow: auto;">
        <table class="table  table-hover">
            <?php
            if ($qtd_consulta_financeiro > 0) {
            ?>
                <thead>
                    <tr>
                        <th>Dt Vencimento</th>
                        <th>Dt Pagamento</th>
                        <th>Parceiro</th>
                        <th>Descrição</th>
                        <th>Forma Pgt</th>
                        <th>Status</th>
                        <th>Valor</th>
                        <th></th>
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
                            <td><?php echo $data_pagamento; ?></td>
                            <td><?php echo $parceiro ?></td>
                            <td><?php echo $descricao ?></td>
                            <td><?php echo $nome_pg; ?></td>
                            <td><?php echo $statusf; ?></td>
                            <td><?php echo real_format($valor); ?></td>
                            <td><a href="?pg&editlcf&codigo=<?php echo $codigo; ?>" class="btn btn-sm btn-info">Editar</a></td>
                        </tr>

                    <?php
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="6">Total</th>
                        <th><?= real_format($total); ?></th>
                        <th></th>
                    </tr>
                </tfoot>
            <?php

            }
            ?>
        </table>
    </div>

</div>