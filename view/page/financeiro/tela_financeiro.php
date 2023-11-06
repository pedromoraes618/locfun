<div class="p-3 shadow">
    <span class="badge mb-3 text-bg-dark"><?php echo $acao; ?> Lnaçamento Fiannceiro</span>
    <?php if ($alert != "") { //alert para usuario corrigir
        echo "<div class='alert alert-danger' role='alert'>$alert</div>";
    } ?>
    <?php if ($alert_success != "") { //alert acão realizada com sucesso
        echo "<div class='alert alert-success' role='alert'>$alert_success</div>";
    } ?>
    <form action="" method="POST">
        <div class="row mb-2">
            <div class="col-md-auto  mb-2">
                <label for="nome" class="form-label">Data Movimento</label>
                <input type="date" class="form-control" disabled id="nome" value="<?= $data_movimento ?>">
            </div>
            <div class="col-md-auto  mb-2">
                <label for="data_vencimento" class="form-label">Data Vencimento</label>
                <input type="date" class="form-control" name="data_vencimento" id="data_vencimento" value="<?= $data_vencimento; ?>">
            </div>
            <div class="col-md-auto  mb-2">
                <label for="data_pagamento" class="form-label">Data Pagamento</label>
                <input type="date" class="form-control" name="data_pagamento" id="data_pagamento" value="<?= $data_pagamento; ?>">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-6  mb-2">
                <label for="parceiro" class="form-label">Parceiro</label>
                <select class="form-select parceiro_select" name="parceiro" id="parceiro">
                    <option value="0">Selecione</option>
                    <?php
                    $resultados = consulta_linhas_tb($conecta, 'clientes');
                    if ($resultados) {
                        foreach ($resultados as $linha) {
                            $id = $linha['id_cliente'];
                            $parceiro_descricao = $linha['nome'];
                            $tipo = $linha['tipo'];
                            $selected = ($id == $parceiro) ? "selected" : "";
                            echo "<option value='$id' $selected>$parceiro_descricao - $tipo</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-2  mb-2">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" name="status" id="status">
                    <option value="0">Selecione</option>
                    <?php
                    $resultados = consulta_linhas_tb($conecta, 'status_financeiro');
                    if ($resultados) {
                        foreach ($resultados as $linha) {
                            $id = $linha['id_status'];
                            $descricao_status = $linha['nome'];
                            $selected = ($id == $status) ? "selected" : "";
                            echo "<option value='$id' $selected>$descricao_status</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-2  mb-2">
                <label for="forma_pg" class="form-label">Forma Pagamento</label>
                <select class="form-select" name="forma_pg" id="forma_pg">
                    <option value="0">Selecione</option>
                    <?php
                    $resultados = consulta_linhas_tb($conecta, 'forma_pg');
                    if ($resultados) {
                        foreach ($resultados as $linha) {
                            $id = $linha['id_pg'];
                            $descricao_fpg = $linha['nome_pg'];
                            $selected = ($id == $forma_pg) ? "selected" : "";
                            echo "<option value='$id' $selected>$descricao_fpg</option>";
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md  mb-2">
                <label for="descricao" class="form-label">Descrição</label>
                <input type="text" class="form-control" name="descricao" id="descricao" value="<?= $descricao; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-2  mb-2">
                <label for="valor" class="form-label">Valor</label>
                <input type="number" step="any" class="form-control" name="valor" id="valor" value="<?= $valor; ?>">
            </div>
        </div>

        <button type="submit" name="form_lancamento" class="btn btn-sm btn-success" onclick="return confirm('Deseja <?php echo $acao; ?> esse lancamento?')"><?php echo $acao; ?></button>
        <a href="?pg&lcf" class="btn btn-sm btn-secondary">Voltar</a>



    </form>


</div>

<script type="text/javascript" src="static/js/page/financeiro.js"></script>