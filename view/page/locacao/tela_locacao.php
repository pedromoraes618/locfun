<div class="p-3 shadow">
    <span class="badge mb-3 text-bg-dark"><?php echo $acao; ?> locação</span>
    <span style="display: none;" class='alert alert_api' role='alert'></span>

   <?php if ($alert != "") { //alert para usuario corrigir
        echo "<div class='alert alert-danger' role='alert'>$alert</div>";
    } ?>
    <?php if ($alert_success != "") { //alert acão realizada com sucesso
        echo "<div class='alert alert-success' role='alert'>$alert_success</div>";
    } ?>
    <div class="row">
        <div class="col-md card border-0 m-2 p-2 mb-2 shadow">
            <form action="" method="POST">
                <input type="hidden" name="codigo_loc" value="<?php echo $codigo_loc; ?>">

                <div class="row mb-2">
                    <div class="col-md-auto  mb-2">
                        <label for="nome" class="form-label">Data Locação</label>
                        <input type="datetime-local" class="form-control" disabled id="data_locacao" value="<?= $data_locacao ?>">
                    </div>
                    <div class="col-md-auto  mb-2">
                        <label for="data_prevista" class="form-label">Data Prevista</label>
                        <input type="datetime-local" class="form-control" name="data_prevista" id="data_prevista" value="<?= $data_prevista; ?>">
                    </div>
                    <div class="col-md-auto  mb-2">
                        <label for="data_retorno" class="form-label">Data Retorno</label>
                        <input type="datetime-local" class="form-control" name="data_retorno" id="data_retorno" value="<?= $data_retorno; ?>">
                    </div>

                </div>
                <div class="row mb-2">
                    <div class="col-md-7  mb-2">
                        <label for="parceiro" class="form-label">Cliente</label>
                        <select class="form-select select2 " name="parceiro" id="parceiro">
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

                    <div class="col-md-5  mb-2">
                        <label for="forma_pg" class="form-label">Forma Pagamento</label>
                        <select class="form-select select2" name="forma_pg" id="forma_pg">
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
                <hr>
                <div class="row mb-2">
                    <div class="col-md  mb-2">
                        <label for="prd_id" class="form-label">Produto</label>
                        <select class="form-select select2" name="prd_id" id="prd_id">
                            <option value="0">Selecione</option>
                            <?php
                            $resultados = consulta_linhas_tb($conecta, 'produtos');
                            if ($resultados) {
                                foreach ($resultados as $linha) {
                                    $id_produto = $linha['id_prod'];
                                    $descricao_prd = $linha['nome'];
                                    $estoque = $linha['qtd'];
                                    $preco = real_format($linha['preco']);
                                    $selected = ($id_produto == $prd_id) ? "selected" : "";
                                    echo "<option value='$id_produto' $selected>$descricao_prd - $preco h / Estoque $estoque  </option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-5 mb-2">
                        <label for="qtd" class="form-label">Quantidade</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="qtd" id="qtd" value="<?= $qtd; ?>">
                            <button class="btn btn-success" type="submit" name="addProduto" id="addProduto">Adicionar</button>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md  mb-2">
                        <label for="addTaxa" class="form-label">Taxa</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">R$</span>
                            <input type="number" step="any" class="form-control" name="taxa" id="taxa" value="<?= $taxa; ?>">
                            <button class="btn btn-dark" type="submit" name="addTaxa" id="addTaxa">Taxa</button>
                        </div>
                    </div>


                    <div class="col-md  mb-2">
                        <label for="addDesconto" class="form-label">Desconto</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">R$</span>
                            <input type="number" step="any" class="form-control" name="desconto" id="desconto" value="<?= $desconto; ?>">
                            <button class="btn btn-info" type="submit" name="addDesconto" id="addDesconto">Desconto</button>
                        </div>

                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md  mb-2">
                        <label for="observacao" class="form-label">Observação</label>
                        <textarea class="form-control" class="form-control" name="observacao" id="observacao"><?= $observacao; ?></textarea>
                    </div>
                </div>



                <button type="submit" name="form_locacao" class="btn btn-sm btn-success" onclick="return confirm('Deseja <?php echo $acao; ?> esse lancamento?')"><?php echo $acao; ?></button>
                <a href="?pg&lcc" class="btn btn-sm btn-secondary">Voltar</a>

            </form>
        </div>
        <div class="col-md table-responsive card-itens-loc card border-0 m-2 p-2 mb-2 shadow">
            <?php
            include "view/page/locacao/tabela_produto.php";
            ?>
        </div>

    </div>

</div>

<script type="text/javascript" src="static/js/page/locacao.js"></script>