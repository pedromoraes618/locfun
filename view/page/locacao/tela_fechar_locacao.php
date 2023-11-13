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
                        <label for="data_prevista" class="form-label">Data Prevista</label>
                        <input type="datetime-local" class="form-control" name="data_prevista" id="data_prevista" value="<?= $data_prevista; ?>">
                    </div>
                    <div class="col-md-auto  mb-2">
                        <label for="data_retorno" class="form-label">Data Retorno</label>
                        <input type="datetime-local" class="form-control" name="data_retorno" id="data_retorno" value="<?= $data_retorno; ?>">
                    </div>

                </div>
                <span class="badge mb-3 text-bg-dark">Pagamento</span>

                <div class="row mb-2">

                    <?php
                    $resultados = consulta_linhas_tb($conecta, 'forma_pg');
                    if ($resultados) {
                        foreach ($resultados as $linha) {
                            $id = $linha['id_pg'];
                            $descricao_fpg = $linha['nome_pg'];
                    ?>
                            <div class="col-md-4  mb-2">
                                <span class="input-group-text" id="basic-addon1"><?php echo $descricao_fpg; ?></span>
                                <input type="number" step="any" class="form-control" name="pgt<?php echo $id; ?>" id="pgt" value="">
                            </div>
                    <?php
                        }
                    }
                    ?>

                </div>
                <hr>


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