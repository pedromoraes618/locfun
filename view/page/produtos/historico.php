<div class="p-3 shadow">
    <span class="badge mb-3 text-bg-dark">Histórico de Movimentação</span>
    <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
        <a href="?pg&prd" class="btn btn-sm btn-secondary">Voltar</a>
    </div>
    <div class="table-container">
        <table class="table  table-hover">
            <thead>
                <tr>
                    <th>Dt Movimento</th>
                    <th>Nº Doc</th>
                    <th>Produto</th>
                    <th>Saida</th>
                    <th>Entrada</th>
                    <th>Saldo</th>
                    <th>Preço Saida</th>
                    <th>Preço Entrada</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($linha = mysqli_fetch_assoc($consulta_historico)) {
                    $data_mov = formatDateB($linha['data_mov']);
                    $produto = $linha['produto'];
                    $produto = $linha['produto'];
                    $id_mov = $linha['id_mov'];
                    $saida = $linha['saida'];
                    $entrada = $linha['entrada'];
                    $preco_saida = $linha['preco_saida'];
                    $preco_entrada = $linha['preco_entrada'];
                    $status = $linha['status'];
                    $serie_doc = $linha['serie_doc'];
                    $saldo = $entrada - $saida;
                    if ($status == "ok") {
                        $status = "<span class='badge text-bg-success' title='finalizado'><i class='bi bi-check2-circle'></i></span>";
                    } else {
                        $status = "<span class='badge text-bg-danger'  title='cancelado'><i class='bi bi-x-circle'></i></span>";
                    }

                ?>
                    <tr>
                        <td><?php echo $data_mov; ?></td>
                        <td><?php echo $serie_doc . " " . $id_mov; ?></td>
                        <td><?php echo $produto; ?></td>
                        <td><?php echo $saida; ?></td>
                        <td><?php echo $entrada; ?></td>
                        <td><?php echo $saldo; ?></td>
                        <td><?php echo $preco_saida; ?></td>
                        <td><?php echo $preco_entrada; ?></td>
                        <td><?php echo $status; ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

</div>