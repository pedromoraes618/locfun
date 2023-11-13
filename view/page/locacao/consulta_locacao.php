<div class="p-3 shadow">
    <span class="badge mb-3 text-bg-dark">locações</span>
    <form action="" method="POST">

        <div class="row">
            <div class="col-md-auto  mb-2">
                <div class="input-group">
                    <span class="input-group-text">Dt. Locação</span>
                    <input type="date" class="form-control  " id="data_inicial" name="data_inicial" placeholder="Data Inicial" value="<?php echo $data_inicial ?>">
                    <input type="date" class="form-control " id="data_final" name="data_final" placeholder="Data Final" value="<?php echo $data_final; ?>">
                </div>
            </div>

            <div class="col-md  mb-2">
                <div class="input-group">
                    <input type="text" class="form-control" name="pesquisa_conteudo" value="<?php echo $conteudo_pesquisa; ?>" placeholder="Pesquise pelo nome do cliente" aria-label="Recipient's username" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary" type="submit" id="pesquisar_filtro_pesquisa">Pesquisar</button>
                </div>
            </div>
            <div class="col-md-auto d-grid gap-2 d-sm-block mb-1">
                <a href="?pg&addlcc" class="btn  btn-dark">Adicionar Locação</a>
            </div>
        </div>
        <!-- <div class="row mb-2">
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
        </div> -->
    </form>
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
                        <th></th>
                        <th></th>

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
                            <td class="btn-group">
                                <a href="?pg&editlcc&codigo=<?php echo $codigo; ?>" class="btn btn-sm btn-info">Editar</a>
                                <?php if ($status_loc != "FECHADO") {
                                ?>
                                    <a href="?pg&fechlcc&codigo=<?php echo $codigo; ?>" class="btn btn-sm btn-warning">Fechar</a>
                                <?php
                                } ?>
                            </td>


                        </tr>

                    <?php
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5">Total</th>
                        <th><?= real_format($total); ?></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            <?php

            }
            ?>
        </table>
    </div>

</div>